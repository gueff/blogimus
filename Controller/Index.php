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
 * @name $BlogixxController
 */
namespace Blogixx\Controller;


/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Index implements \MVC\MVCInterface\Controller
{
	/**
	 * routing array for current page
	 * 
	 * @var array
	 * @access protected
	 */
	protected $_aRoutingCurrent = array ();

	/**
	 * Event Object
	 * 
	 * @var \Blogixx\Event\Index
	 * @access protected
	 */
	protected $_oBlogixxEventIndex;

	/**
	 * View Object
	 * 
	 * @var \Blogixx\View\Index
	 * @access public
	 */
	public $oBlogixxViewIndex;

	/**
	 * Model Object
	 * 
	 * @var \Blogixx\Model\Index 
	 * @access protected
	 */
	protected $_oBlogixxModelIndex;


	/**
	 * this method is autom. called by MVC_Application->runTargetClassBeforeMethod()
	 * in very early stage
	 * 
	 * @access public
	 * @static
	 */
	public static function __preconstruct ()
	{
		// start event listener
		\Blogixx\Event\Index::getInstance ();
	}

	/**
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct ()
	{
		$this->_aRoutingCurrent = \MVC\Registry::get ('MVC_ROUTING_CURRENT');

		$this->oBlogixxViewIndex = new \Blogixx\View\Index();
		$this->_oBlogixxModelIndex = new \Blogixx\Model\Index ();
		
		if (empty ($this->_aRoutingCurrent))
		{
			$this->_aRoutingCurrent = $this->_oBlogixxModelIndex->findMainPath ();
			$this->_oBlogixxModelIndex->aRoutingCurrent = $this->_aRoutingCurrent;
		}

		$this->_oBlogixxModelIndex->init ();
		$this->oBlogixxViewIndex->assign ('sTitle', \MVC\Registry::get ('BLOG_NAME'));
		$this->oBlogixxViewIndex->assign ('sBlogName', \MVC\Registry::get ('BLOG_NAME'));
	}

	/**
	 * index
	 * 
	 * @access public
	 * @return void
	 */
	public function index ()
	{		
		/**
		 * @todo full page cache
		 */
        
		ASSIGNMENTS: {
			
			// All Dates
			// load Post dates
			$aPostDate = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aPostDate.json'), true);

			// All Tags
			// Sort multidimensional array by number of (value) items @see http://stackoverflow.com/a/7433611/2487859
			$aTag = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aTag.json'), true);
			array_multisort (array_map ('count', $aTag), SORT_DESC, $aTag);
			
			// All Pages
			$aPage = json_decode (file_get_contents (\MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/aPage.json'), true);
			
			$this->oBlogixxViewIndex->assign ('aPostDate', $aPostDate);
			$this->oBlogixxViewIndex->assign ('aTag', $aTag);
			$this->oBlogixxViewIndex->assign ('aPage', $aPage);
		}
		
		DELEGATE: {
			
			// Backend
            $sRequest = mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), 1, mb_strlen(strtok($_SERVER['REQUEST_URI'], '?')));
            $oControllerBackend = new \Blogixx\Controller\Backend($this);
            $this->oBlogixxViewIndex->assign ('sPageType', mb_substr($sRequest, 0, 4));
            $this->oBlogixxViewIndex->assign ('sRequest', '/' . $sRequest);
            $this->oBlogixxViewIndex->assign ('sLoginToken', mb_substr($sRequest, 0, 1));
			if ('@' === mb_substr($sRequest, 0, 1))
			{
                $oControllerBackend->backend($sRequest);
				return true;
			}
			
			\MVC\Event::RUN('blogixx.delegate.before');
            
			// PAGE
			if (true === $this->_oBlogixxModelIndex->checkRequestOnToken ('page/'))
			{
				\MVC\Event::RUN('blogixx.delegate.page.before');
				$this->concretePage();
				\MVC\Event::RUN('blogixx.delegate.page.after');
			}
			// POST
			elseif (true === $this->_oBlogixxModelIndex->checkRequestOnToken ('post/'))
			{
				\MVC\Event::RUN('blogixx.delegate.post.before');
				$this->concretePost();
				\MVC\Event::RUN('blogixx.delegate.post.after');
			}
			// DATE
			elseif (true === $this->_oBlogixxModelIndex->checkRequestOnToken ('date/'))
			{
				\MVC\Event::RUN('blogixx.delegate.date.before');
				$this->concreteDate($aPostDate);
				\MVC\Event::RUN('blogixx.delegate.date.after');
			}
			// TAG
			elseif (true === $this->_oBlogixxModelIndex->checkRequestOnToken ('tag/'))
			{
				\MVC\Event::RUN('blogixx.delegate.tag.before');
				$this->concreteTag($aTag);
				\MVC\Event::RUN('blogixx.delegate.tag.after');
			}
			// BLOG OVERVIEW
			elseif ($this->_aRoutingCurrent['path'] === strtok ($_SERVER['REQUEST_URI'], '?'))
			{
				\MVC\Event::RUN('blogixx.delegate.overview.before');
				$this->postOverview();
				\MVC\Event::RUN('blogixx.delegate.overview.after');
			}           
			// invalid Request
			else
			{
				\MVC\Event::RUN('blogixx.delegate.notfound.before');
				$this->notFound();		
				\MVC\Event::RUN('blogixx.delegate.notfound.after');
			}
			
			\MVC\Event::RUN('blogixx.delegate.after');
		}
		
		$this->_oBlogixxModelIndex->setMeta ($this->oBlogixxViewIndex);
		\MVC\Event::RUN('blogixx.delegate.meta.after');
		
		// Set Value in sContent Var
		$this->oBlogixxViewIndex->assign (
			'sContent', 
			$this->oBlogixxViewIndex->loadTemplateAsString ('index/index.tpl')
		);
	}

	/**
	 * a concrete page
	 * 
	 * @access public
	 * @return void
	 */
	public function concretePage ()
	{
		$aSet = $this->_oBlogixxModelIndex->getConcreteFile ();
		
		if (empty ($aSet))
		{
			$this->notFound();
		}
		else
		{			
			$this->oBlogixxViewIndex->assign ('sTitle', $aSet['sName']);
			$this->oBlogixxViewIndex->assign ('aSet', $aSet);
			$this->oBlogixxViewIndex->assign ('sPage', $aSet['sContent']);
		}		
	}
	
	/**
	 * a concrete post
	 * @return void
	 */
	public function concretePost()
	{
		$aSet = $this->_oBlogixxModelIndex->getConcreteFile ();
		
		if (empty ($aSet))
		{
			$this->notFound();
		}
		else
		{
			$this->oBlogixxViewIndex->assign ('sTitle', $aSet['sName']);
			$this->oBlogixxViewIndex->assign ('aSet', $aSet);
			$this->oBlogixxViewIndex->assign ('sPost', $aSet['sContent']);
		}		
	}
	
	/**
	 * results to a concrete date
	 * 
	 * @access public
	 * @param array $aPostDate
	 * @return void
	 */
	public function concreteDate(array $aPostDate = array())
	{
		$sDateRequested = mb_substr (strtok ($_SERVER['REQUEST_URI'], '?'), (mb_strlen ($this->_aRoutingCurrent['path']) + (mb_strlen ('date/'))), (mb_strlen (mb_substr (strtok ($_SERVER['REQUEST_URI'], '?'), (mb_strlen ($this->_aRoutingCurrent['path']) + (mb_strlen ('date/'))))) - 1));
		$aDateRequested = explode ('/', $sDateRequested);

		$iYear = (isset ($aDateRequested[0])) ? $aDateRequested[0] : false;
		$iMonth = (isset ($aDateRequested[1])) ? $aDateRequested[1] : false;
		$iDay = (isset ($aDateRequested[2])) ? $aDateRequested[2] : false;

		// handle invalid requests
		if (
			(false !== $iYear && !isset ($aPostDate[$iYear])) || (false !== $iMonth && !isset ($aPostDate[$iYear][$iMonth])) || (false !== $iDay && !isset ($aPostDate[$iYear][$iMonth][$iDay]))
		)
		{
			$this->notFound();
		}
		else
		{
			if (false !== $iYear && isset ($aPostDate[$iYear]))
			{
				$aDate['aYear'] = $aPostDate[$iYear];

				if (false !== $iMonth && isset ($aPostDate[$iYear][$iMonth]))
				{
					$aDate['aMonth'] = $aDate['aYear'][$iMonth];

					if (false !== $iDay && isset ($aPostDate[$iYear][$iMonth][$iDay]))
					{
						$aDate['aDay'] = $aDate['aMonth'][$iDay];
					}
				}
			}

			$this->oBlogixxViewIndex->assign ('sTitle', implode ('-', $aDateRequested));
			$this->oBlogixxViewIndex->assign ('aDate', $aDate);
			$this->oBlogixxViewIndex->assign ('sDateRequested', implode ('-', $aDateRequested));
		}		
	}

	/**
	 * results to a concrete tag
	 * 
	 * @access public
	 * @param array $aTag
	 * @return void
	 */
	public function concreteTag(array $aTag = array())
	{
		$sTagRequested = urldecode(mb_substr (strtok ($_SERVER['REQUEST_URI'], '?'), (mb_strlen ($this->_aRoutingCurrent['path']) + (mb_strlen ('tag/'))), (mb_strlen (mb_substr (strtok ($_SERVER['REQUEST_URI'], '?'), (mb_strlen ($this->_aRoutingCurrent['path']) + (mb_strlen ('tag/'))))) - 1)));

		if (isset ($aTag[$sTagRequested]))
		{
			$aTagInterest = array ();
			foreach ($aTag[$sTagRequested] as $sCacheFile)
			{				
				$aTmp = json_decode (file_get_contents ($sCacheFile), true);
				$aTagInterest[] = array (
					'sName' => $aTmp['sName'],
					'sUrl' => $aTmp['sUrl']
				);
			}

			$this->oBlogixxViewIndex->assign ('sTitle', $sTagRequested);
			$this->oBlogixxViewIndex->assign ('sTagInterest', $sTagRequested);
			$this->oBlogixxViewIndex->assign ('aTagInterest', $aTagInterest);
		}
		else
		{
			$this->notFound();
		}		
	}

	/**
	 * posts for overview
	 * 
	 * @access public
	 * @return void
	 */
	public function postOverview()
	{
		// get all posts
		$aPost = $this->_oBlogixxModelIndex->getPostsOverview ();
		$aFinal = array ();
		$aTmp = array();

		$iBlogMaxPostOnPage = \MVC\Registry::get ('BLOG_MAX_POST_ON_PAGE');

		// a param
		$aQuery = \MVC\Request::getInstance ()->getQueryArray ();
		$iGetA = 0;
		
		if (isset ($aQuery['GET']['a']))
		{
			$aGetA = json_decode ($aQuery['GET']['a'], true);

			if (is_array($aGetA) && array_key_exists('start', $aGetA) && isset($aGetA['start']))
			{
				$iGetA = $aGetA['start'];
			}
		}	

		// iPaginationToGo
		$iPaginationToGo = round( count ($aPost) / $iBlogMaxPostOnPage );
		$aPaginationToGo = array ();

		// pagination correction
		($iGetA < 0) ? $iGetA = 0 : false;
		($iGetA > (($iPaginationToGo - 1) * $iBlogMaxPostOnPage)) ? $iGetA = (($iPaginationToGo - 1) * $iBlogMaxPostOnPage) : false;

		// load contents
		$iCnt = 0;
		$oParsedown = new \Parsedown();

		foreach ($aPost as $sUrl => $aValue)
		{
			$iEnd = ($iGetA + $iBlogMaxPostOnPage);

			if ($iCnt >= $iGetA && $iCnt < $iEnd)
			{
				$sContent = file_get_contents ($aValue['sFilePath']);

				// cut off
				$sContent = mb_substr (
					$sContent, 
					0, 
					\MVC\Registry::get ('BLOG_TEASER_SIZE_IN_OVERVIEW')
				) . ' […]';		

				// convert markdown to html
				$sContent = $oParsedown->text ($sContent);
				
				$sContent = str_replace('<tag>', '###TAG###', $sContent);
				$sContent = str_replace('</tag>', '###/TAG###', $sContent);
				
				// auto-repair html
				$sContent = \HTMLPurifier::getInstance()->purify($sContent);
				
				$sContent = str_replace('###TAG###', '<tag>', $sContent);
				$sContent = str_replace('###/TAG###', '</tag>', $sContent);
				
				$aPost[$sUrl]['sContent'] = $sContent;
				$aFinal[$sUrl] = $aPost[$sUrl];
			}

			$iCnt++;
		}

		for ($i = 1; $i <= $iPaginationToGo; $i++)
		{
			$aTmp = array ();
			$aTmp['iNr'] = $i;
			$aTmp['sUrl'] = '?a={"start":' . (($iBlogMaxPostOnPage * $i) - $iBlogMaxPostOnPage) . '}';
			$aTmp['iA'] = (($iBlogMaxPostOnPage * $i) - $iBlogMaxPostOnPage);
			$aPaginationToGo[] = $aTmp;
		}

		$iMinus = ((isset ($iGetA)) ? ($iGetA - $iBlogMaxPostOnPage) : 0);
		$iPlus = ((isset ($iGetA)) ? ($iGetA + $iBlogMaxPostOnPage) : 0);
		($iMinus < 0) ? $iMinus = 0 : false;
		(array_key_exists('iA', $aTmp) && $iPlus > $aTmp['iA']) ? $iPlus = $aTmp['iA'] : false;

		$this->oBlogixxViewIndex->assign ('aPaginationToGo', $aPaginationToGo);
		$this->oBlogixxViewIndex->assign ('iMinus', $iMinus);
		$this->oBlogixxViewIndex->assign ('aParam', ((isset ($aQuery['GET']['a'])) ? json_decode ($aQuery['GET']['a'], true) : 0));
		$this->oBlogixxViewIndex->assign ('iPlus', $iPlus);
		$this->oBlogixxViewIndex->assign ('aPost', $aFinal);	
		
        CALC_PAGINATION_SHRINK: {
            
            $iPaginationRange = round(\MVC\Registry::get('BLOG_MAX_AMOUNT_PAGINATION_STEPS') -1);
            $iArrayIndexStart = null;
            $iArrayIndexEnd = null;

            // falls es mehr paginationsSeiten gibt als für range (plus vor/zurück) vorgesehen
            if (count($aPaginationToGo) > ($iPaginationRange + 2))
            {
                $iTargetPaginationArrayIndex = ($iGetA / $iBlogMaxPostOnPage);

                $iArrayIndexStart = ($iTargetPaginationArrayIndex - ($iPaginationRange / 2)); 
                $iArrayIndexEnd = ($iTargetPaginationArrayIndex + ($iPaginationRange / 2)); 

                ($iArrayIndexStart < 0) ? $iArrayIndexStart = 0: false;
                ($iArrayIndexEnd < 0) ? $iArrayIndexEnd = 0: false;

                ($iArrayIndexStart > ($iPaginationToGo - 1)) ? $iArrayIndexStart = ($iPaginationToGo - 1): false;
                ($iArrayIndexEnd > ($iPaginationToGo - 1)) ? $iArrayIndexEnd = ($iPaginationToGo - 1): false;

                // corrections
                if ($iArrayIndexStart == 0)
                {
                    $iPaginationRange++;
                    $iDiff = ($iArrayIndexEnd - $iArrayIndexStart);
                    $iDiffMissing = ($iPaginationRange - $iDiff);

                    if ($iDiffMissing > 0)
                    {
                        $iArrayIndexEnd = ($iArrayIndexEnd + $iDiffMissing);
                    }
                }

                if ($iArrayIndexEnd == ($iPaginationToGo - 1))
                {
                    $iPaginationRange++;
                    $iDiff = ($iArrayIndexEnd - $iArrayIndexStart);
                    $iDiffMissing = ($iPaginationRange - $iDiff);

                    if ($iDiffMissing > 0)
                    {
                        $iArrayIndexStart = ($iArrayIndexStart - $iDiffMissing);
                    }
                }
            }
        
            $this->oBlogixxViewIndex->assign('iArrayIndexStart', $iArrayIndexStart);
            $this->oBlogixxViewIndex->assign('iArrayIndexEnd', $iArrayIndexEnd);
        }
        
        $this->oBlogixxViewIndex->assign('iPaginationToGo', $iPaginationToGo);		
	}

    /**
	 * not found
	 * 
	 * @access public
	 * @return void
	 */
	public function notFound()
	{
		$this->oBlogixxViewIndex->sendHeader404 ();		
		$this->oBlogixxViewIndex->assign ('sTitle', '404');
		$this->oBlogixxViewIndex->assign ('sPage', file_get_contents(\MVC\Registry::get ('MVC_MODULES') . '/Standard/templates/index/404.tpl'));			
	}

	/**
	 * Destructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct ()
	{
		$this->oBlogixxViewIndex->render ();
	}
}