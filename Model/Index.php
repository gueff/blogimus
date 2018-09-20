<?php

/**
 * Index.php
 *
 * @package myMVC
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusModel
 */
namespace Blogimus\Model;

/**
 * Index
 */
class Index
{
    public $sDataDir;
    public $sPageDir;
    public $sPostDir;
    protected $_sCheckSum;

    /**
     * routing array for current page
     * 
     * @var array
     * @access protected
     */
    public $aRoutingCurrent = array();

    /**
     * Construcor
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_createFolders();
        $this->aRoutingCurrent = \MVC\Registry::get('MVC_ROUTING_CURRENT');
        $this->sDataDir = \MVC\Registry::get('BLOG_DATA_DIR');
        $this->sPageDir = \MVC\Registry::get('BLOG_DATA_DIR') . '/page';
        $this->sPostDir = \MVC\Registry::get('BLOG_DATA_DIR') . '/post';
    }

    /**
     * @access public
     * @return void
     */
    public function init()
    {
        if (true === $this->_updateCheckSum())
        {
            $this->_buildCache();
            $this->buildGoogleSitemap();
        }
    }

    /**
     * @access private
     * @return void
     */
    private function _createFolders()
    {
        (!file_exists(\MVC\Registry::get('BLOG_DATA_DIR')))                 ? mkdir(\MVC\Registry::get('BLOG_DATA_DIR')) : false;
        (!file_exists(\MVC\Registry::get('BLOG_DATA_DIR') . '/post'))       ? mkdir(\MVC\Registry::get('BLOG_DATA_DIR') . '/post') : false;
        (!file_exists(\MVC\Registry::get('BLOG_DATA_DIR') . '/page'))       ? mkdir(\MVC\Registry::get('BLOG_DATA_DIR') . '/page') : false;
        (!file_exists(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus'))   ? mkdir(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus') : false;
    }

    /**
     * creates a checksum about folder /data and its contents
     * saves this to the application/cache folder
     * and reads existing from there
     * 
     * @access private
     * @return boolean update (true=there are changes in data folder | false=no changes)
     */
    private function _updateCheckSum()
    {
        $sCmd = \MVC\Registry::get('BLOG_BIN_LS') . ' -alR ' . \MVC\Registry::get('BLOG_DATA_DIR') . '/* | ' . \MVC\Registry::get('BLOG_BIN_MD5SUM');
        $this->_sCheckSum = shell_exec($sCmd);
        $this->_sCheckSum.= '_BLOG_MAX_POST_ON_PAGE:' . \MVC\Registry::get('BLOG_MAX_POST_ON_PAGE');
        $sCheckSumOld = '';

        $sCheckSumFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/checksum.txt';

        if (file_exists($sCheckSumFile))
        {
            $sCheckSumOld = file_get_contents($sCheckSumFile);
        }

        if ($this->_sCheckSum !== $sCheckSumOld)
        {
            file_put_contents(\MVC\Registry::get('MVC_CACHE_DIR') . '/checksum.txt', $this->_sCheckSum);

            return true;
        }

        return false;
    }

    /**
     * builds a cache index
     * 
     * @access private
     * @return void
     */
    private function _buildCache()
    {
        // Page
        $aPage = $this->_getPages();
        $sJsonPage = json_encode($aPage);

        $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPage.json';
        (file_exists($sFile)) ? unlink($sFile) : false;
        file_put_contents($sFile, $sJsonPage);

        foreach ($aPage as $sUrl => $aValue)
        {
            $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/' . self::toCacheName($sUrl) . '.json';
            (file_exists($sFile)) ? unlink($sFile) : false;

            file_put_contents(
                $sFile, json_encode($aPage[$sUrl])
            );
        }

        // Post		
        $aPost = $this->_getPosts();
        $aJsonPost = json_encode($this->_getPosts());

        $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPost.json';
        (file_exists($sFile)) ? unlink($sFile) : false;
        file_put_contents($sFile, $aJsonPost);

        $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPostDate.json';
        (file_exists($sFile)) ? unlink($sFile) : false;
        file_put_contents($sFile, json_encode($aPost['sCreateStamp']));

        $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPostUrl.json';
        (file_exists($sFile)) ? unlink($sFile) : false;
        file_put_contents($sFile, json_encode($aPost['sUrl']));

        foreach ($aPost['sUrl'] as $sUrl => $aValue)
        {
            $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/' . self::toCacheName($sUrl) . '.json';
            (file_exists($sFile)) ? unlink($sFile) : false;

            file_put_contents(
                $sFile, json_encode($aPost['sUrl'][$sUrl])
            );
        }

        // Tags
        $aTag = $this->getTags();
        $sFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aTag.json';
        (file_exists($sFile)) ? unlink($sFile) : false;
        file_put_contents($sFile, json_encode($aTag));
    }

	
	/**
	 * build google sitemap.txt
     * @see https://support.google.com/webmasters/answer/183668?hl=en
	 */
	public function buildGoogleSitemap()
	{
		$aPage = array_keys(json_decode(file_get_contents(\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogimus/aPage.json'), true));
		$aPage[] = '/';		
		$aPost = array_keys(json_decode(file_get_contents(\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogimus/aPostUrl.json'), true));
		$aTmp = $aFinal = array();
        
		$aFinal = array_map(
			function($sUrl) {
				$aUrl = \MVC\Request::GETCURRENTREQUEST();
				return $aUrl['protocol'] . $aUrl['host'] . $sUrl;
			}, 
			array_unique(
				array_merge(
					$aPage, 
                    $aPost, 
                    $aTmp
				)
			)
		);
		
		$sSitemapAbsFile = \MVC\Registry::get('MVC_BASE_PATH') . '/public/sitemap.txt';
		(file_exists($sSitemapAbsFile)) ? unlink($sSitemapAbsFile) : false;
			
		foreach ($aFinal as $sUrl)
		{
			file_put_contents(
                $sSitemapAbsFile, 
                $sUrl . "\n", 
                FILE_APPEND
            );
		}
	}    
    
    /**
     * converts a filepath string into cachename string
     * 
     * @access public
     * @param type $sString
     * @return string
     */
    public static function toCacheName($sString)
    {
        return str_replace('/', '#|#', $sString);
    }

    /**
     * converts a cachename string into a filepath string
     * 
     * @access public
     * @param type $sString
     * @return string 
     */
    public static function fromCacheName($sString)
    {
        return str_replace('#|#', '/', $sString);
    }

    /**
     * checks which markdown (*.md) pages exist
     * @access public
     */
    private function _getPages()
    {
        $aFiles = array_diff(scandir($this->sPageDir), array('..', '.'));
        $aCurrent = \MVC\Registry::get('MVC_ROUTING_CURRENT');
        $aFinal = array();

        foreach ($aFiles as $sFile)
        {
            $sName = basename($sFile, '.md');
            $sUrl = $aCurrent['path'] . 'page/' . $this->seoname($sName) . '/';

            $aFinal[$sUrl] = array();
            $aFinal[$sUrl]['sName'] = $sName;
            $aFinal[$sUrl]['sUrl'] = $sUrl;
            $aFinal[$sUrl]['sFilePath'] = $this->sPageDir . '/' . $sFile;
            $aFinal[$sUrl]['sCreateStamp'] = date("Y-m-d H:i:s", filectime($aFinal[$sUrl]['sFilePath']));
            $aFinal[$sUrl]['sChangeStamp'] = date("Y-m-d H:i:s", filemtime($aFinal[$sUrl]['sFilePath']));
        }

        return $aFinal;
    }

    /**
     * checks which markdown (*.md) posts exist
     * 
     * @access private
     * @return array	 
     */
    private function _getPosts()
    {
        // get file list
        $sCmd = \MVC\Registry::get('BLOG_BIN_FIND') . ' ' . $this->sPostDir . ' -name "*.md" -type f -print';
        $sList = shell_exec($sCmd);
        $aList = preg_split("@\n@", $sList, NULL, PREG_SPLIT_NO_EMPTY);
        rsort($aList);

        $aCurrent = \MVC\Registry::get('MVC_ROUTING_CURRENT');
        $aFinal = array();
        $aFinal['sCreateStamp'] = array();
        $aFinal['sUrl'] = array();

        foreach ($aList as $sFileAbs)
        {
            $sFile = str_replace($this->sPostDir, '', $sFileAbs);

            // get dates
            $sDate = mb_substr($sFile, 1, 10);
            $iYear = mb_substr($sFile, 1, 4);
            $iMonth = mb_substr($sFile, 6, 2);
            $iDay = mb_substr($sFile, 9, 2);

            $sName = basename(mb_substr($sFile, 12, mb_strlen($sFile)), '.md');
            $sUrl = $aCurrent['path'] . 'post/' . $iYear . '/' . $iMonth . '/' . $iDay . '/' . $this->seoname($sName) . '/';

            $aTmp = array();
            $aTmp['sName'] = $sName;
            $aTmp['sUrl'] = $sUrl;
            $aTmp['sFilePath'] = $sFileAbs;
            $aTmp['sCreateStamp'] = $iYear . '-' . $iMonth . '-' . $iDay;
            $aTmp['sChangeStamp'] = date("Y-m-d H:i:s", filemtime($sFileAbs));

            $aFinal['sUrl'][$sUrl] = $aTmp;
            $aFinal['sCreateStamp'][$iYear][$iMonth][$iDay][] = array(
                'sName' => $aFinal['sUrl'][$sUrl]['sName'],
                'sUrl' => $aFinal['sUrl'][$sUrl]['sUrl']
            );
        }

        return $aFinal;
    }

    /**
     * checks which tags exist in posts
     * 
     * @access public
     * @return array $aFinalTag tags listed
     */
    public function getTags()
    {
        // get file list
        $sCmd = \MVC\Registry::get('BLOG_BIN_GREP') . ' -or "<tag>.*</tag>" ' . $this->sDataDir;
        $sList = shell_exec($sCmd);
        $aList = preg_split("@\n@", $sList, NULL, PREG_SPLIT_NO_EMPTY);

        $aFinalTag = array();

        foreach ($aList as $sLine)
        {
            $aTmp = explode('<tag>', $sLine);
            $sFile = mb_substr($aTmp[0], 0, (mb_strlen($aTmp[0]) - 1));
            $sFile = str_replace($this->sDataDir, '', $sFile);

            $sTags = strip_tags($aTmp[1]);
            $aTag = preg_split("@,@", $sTags, NULL, PREG_SPLIT_NO_EMPTY);

            $sName = basename($sFile, '.md');
            $sNameSeo = $this->seoname($sName);
            $sFile = str_replace($sName, $sNameSeo, $sFile);
            $sFile = mb_substr($sFile, 1, (mb_strlen($sFile) - 4));

            if ('post' === mb_substr($sFile, 0, 4))
            {
                // posts have a leading date
                $sDateOrig = mb_substr($sFile, 5, 11);
                $sDate = str_replace('-', '#|#', $sDateOrig);
                $sFile = str_replace($sDateOrig, $sDate, $sFile);
            }

            $sCacheFile = $this->toCacheName($this->aRoutingCurrent['path'] . $sFile) . '#|#.json';

            foreach ($aTag as $sTag)
            {
                $aFinalTag[trim($sTag)][] = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/' . $sCacheFile;
            }
        }

        return $aFinalTag;
    }

    /**
     * checks main path + sets current routing to registry
     * 
     * @access public
     * @return array
     */
    public function findMainPath()
    {
        $aRouting = \MVC\Registry::get('MVC_ROUTING');

        foreach ($aRouting as $sKey => $aRoute)
        {
            if (array_key_exists('Blogimus', $aRoute) && isset($aRoute['Blogimus']))
            {
                $aTmp = $aRouting[$sKey];
                parse_str(
                    $aTmp['query'],
                    $aParseString
                );
                
                $aTmp['path'] = $sKey;
                $aTmp['class'] = ucfirst($aParseString['module']) . "\\Controller\\" . ucfirst($aParseString['c']);
                $aTmp['method'] = $aParseString['m'];

                \MVC\Registry::set('MVC_ROUTING_CURRENT', $aTmp);

                return $aTmp;
            }
        }

        return array();
    }

    /**
     * loads a (post|page) file from cache, reads its content and returns it
     * 
     * @access public
     * @return array $aSet
     */
    public function getConcreteFile()
    {
        $sCacheFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/' . \Blogimus\Model\Index::toCacheName(strtok($_SERVER['REQUEST_URI'], '?')) . '.json';

        if (!file_exists($sCacheFile))
        {
            return '';
        }

        $aSet = json_decode(
            file_get_contents($sCacheFile), true
        );

        if (!file_exists($aSet['sFilePath']))
        {
            return array();
        }

        // get content
        $sContent = file_get_contents($aSet['sFilePath']);

        // Parse
        $Parsedown = new \Parsedown();
        $aSet['sContent'] = $Parsedown->text($sContent);

        return $aSet;
    }

    /**
     * get all posts
     * 
     * @access public
     * @return array posts
     */
    public function getPostsOverview()
    {
        $sCacheFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/aPostUrl.json';

        if (!file_exists($sCacheFile))
        {
            return '';
        }

        return json_decode(
            file_get_contents($sCacheFile), true
        );
    }

    /**
     * gets tag array from a string
     * 
     * @param string $sString
     * @param string $sTag
     * @return array
     */
    public function getTagArrayFromString($sString = '', $sTag = 'tag')
    {
        $aTag = array();

        preg_match_all(
            '#<tag>(.*?)</tag>#', $sString, $aMatch
        );

        if (isset($aMatch[1]))
        {
            foreach ($aMatch[1] as $sLine)
            {
                $aTag = array_merge(
                    $aTag, preg_split(
                        '~,~', strip_tags($sLine), null, PREG_SPLIT_NO_EMPTY
                ));
            }
        }

        return $aTag;
    }

    /**
     * get meta keyword string list out of tag array
     * 
     * @param array $aTagFromString
     * @return string
     */
    public function getMetaKeywords($aTagFromString = array())
    {
        $sMetaKeywords = '';

        foreach ($aTagFromString as $sTag)
        {
            $sMetaKeywords.= $sTag . ',';
        }

        $sMetaKeywords = mb_substr($sMetaKeywords, 0, -1);
        $sMetaKeywords = str_replace('"', '`', $sMetaKeywords);
        $sMetaKeywords = str_replace("'", '`', $sMetaKeywords);
        return $sMetaKeywords;
    }

    /**
     * builds a meta description out of content
     * @param string $sString
     * @return string
     */
    public function getMetaDescription($sString = '')
    {
        $sString = preg_replace(
            '~\<tag\>([^{]*)\<\/tag\>~i', '', $sString
        );
        $sString = trim($sString);
        $sString = strip_tags($sString);
        $sString = preg_replace('/[\r\t\n]/', ' ', $sString);
        $sString = preg_replace('/\s+/', ' ', $sString);
        $sString = mb_substr($sString, 0, 150) . '[..]';
        $sString = html_entity_decode($sString);

        $sString = str_replace('"', '`', $sString);
        $sString = str_replace("'", '`', $sString);
        return $sString;
    }

    /**
     * set meta tags
     * 
     * @param \Blogimus\View\Index $oBlogimusViewIndex
     * @param string $sContent
     */
    public function setMeta(\Blogimus\View\Index $oBlogimusViewIndex, $sContent = '')
    {
        $aVar = $oBlogimusViewIndex->getTemplateVars();

        (isset($aVar['aSet']['sContent'])) ? $sContent = $aVar['aSet']['sContent'] : $sContent = $aVar['sTitle'] . '<tag>' . $aVar['sTitle'] . '</tag>';
        (isset($aVar['sPageType']) && 'date' === $aVar['sPageType']) ? $sContent = $aVar['sTitle'] . ', ' . $aVar['sBlogName'] . '<tag>' . $aVar['sTitle'] . '</tag>' : false;
        (isset($aVar['sPageType']) && 'tag/' === $aVar['sPageType']) ? $sContent = $aVar['sTitle'] . ', ' . $aVar['sBlogName'] . '<tag>' . $aVar['sTitle'] . '</tag>' : false;

        $oBlogimusViewIndex->assign(
            'sMetaKeywords', $this->getMetaKeywords(
                $this->getTagArrayFromString($sContent)
            )
        );

        $oBlogimusViewIndex->assign(
            'sMetaDescription', $this->getMetaDescription($sContent)
        );
    }

    /**
     * converts a string seo-friendly
     * 
     * @access public
     * @param string $sString
     * @return string $sString seo-friendly
     */
    public static function seoname($sString = '')
    {
        $sSeoName = preg_replace('~[^\\pL0-9_]+~u', '-', $sString);
        $sSeoName = trim($sSeoName, "-");
        $sSeoName = iconv("utf-8", "us-ascii//TRANSLIT", $sSeoName);
        $sSeoName = strtolower($sSeoName);
        $sString = preg_replace('~[^-a-z0-9_]+~', '', $sSeoName);

        return $sString;
    }

    /**
     * searches for email adresses inside angle brackets like <fo@example.com>. 
     * Thanks to unicode parsing it can detect umlauts also. e.g.: <föö@exämple.com>
     * 
     * @access public
     * @param type $sString
     * @return type
     */
    public static function getEmailArrayFromString($sString = '')
    {
        $sPattern = '/<[\._\p{L}\p{M}\p{N}-]+@[\._\p{L}\p{M}\p{N}-]+>/u';

        preg_match_all(
            $sPattern, $sString, $aMatch
        );

        $aMatch = array_keys(array_flip(current($aMatch)));

        return $aMatch;
    }

    /**
     * delegate helper
     * 
     * @access public
     * @param type $sToken
     * @return boolean success
     */
    public function checkRequestOnToken($sToken = '')
    {
        if ('' === $sToken)
        {
            return false;
        }

        $sExtractType = mb_substr(
            strtok($_SERVER['REQUEST_URI'], '?'), 0, (
            (mb_strlen($this->aRoutingCurrent['path']) + mb_strlen($sToken))
            )
        );

        if ($this->aRoutingCurrent['path'] . $sToken === $sExtractType)
        {
            return true;
        }

        return false;
    }

    /**
     * Destructor
     * 
     * @access public
     * @access public
     * @return void
     */
    public function __destruct()
    {
        ;
    }
}
