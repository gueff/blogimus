<?php

/**
 * Index.php
 *
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusController
 */
namespace Blogimus\Controller;

    
use MVC\DataType\DTArrayObject;
use MVC\DataType\DTKeyValue;
use MVC\Registry;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Index implements \MVC\MVCInterface\Controller
{
    /**
     * routing array for current page
     * @var array
     * @access protected
     */
    protected $_aRoutingCurrent = array();

    /**
     * Event Object
     * @var \Blogimus\Event\Index
     * @access protected
     */
    protected $_oBlogimusEventIndex;

    /**
     * View Object
     * @access public
     */
    public $oView;

    /**
     * Model Object
     * @access protected
     */
    protected $_oModel;

    /**
     * ControllerBackend Object
     * @access protected
     */
    protected $_oControllerBackend;
    
    /**
     * this method is autom. called by MVC_Application->runTargetClassBeforeMethod()
     * in very early stage
     * @access public
     * @static
     */
    public static function __preconstruct()
    {
        // start event listener
        \Blogimus\Event\Index::getInstance();
    }

    /**
     * Index constructor.
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $sViewIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_VIEW_INDEX'];
        $sModelIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_INDEX'];
        $this->oView = new $sViewIndex();
        $this->_oModel = new $sModelIndex();
        $this->_aRoutingCurrent = Registry::get('MVC_ROUTING_CURRENT');
        
        if (empty($this->_aRoutingCurrent))
        {
            $this->_aRoutingCurrent = $this->_oModel->findMainPath();
            $this->_oModel->aRoutingCurrent = $this->_aRoutingCurrent;
        }

        $this->_oModel->init();
        $this->oView->assign('sTitle', Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_NAME']);
        $this->oView->assign('sBlogName', Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_NAME']);
        $this->oView->assign('sBlogDescription', Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DESCRIPTION']);
        $this->oView->assign('aCurrentRequest', \MVC\Request::GETCURRENTREQUEST());
        $this->oView->assign('aBlogConfig', Registry::getInstance()->getStorageArray());
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function index()
    {
        ASSIGNMENTS: {

            // All Dates
            // load Post dates
            $aPostDate = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPostDate.json'), true);

            // All Tags
            // Sort multidimensional array by number of (value) items @see http://stackoverflow.com/a/7433611/2487859
            $aTag = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aTag.json'), true);
            array_multisort(array_map('count', $aTag), SORT_DESC, $aTag);

            // All Pages
            $aPage = json_decode(file_get_contents(Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/aPage.json'), true);

            $this->oView->assign('aPostDate', $aPostDate);
            $this->oView->assign('aTag', $aTag);
            $this->oView->assign('aPage', $aPage);
        }

        DELEGATE: {

            // Backend
            $sRequest = mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), 1, mb_strlen(strtok($_SERVER['REQUEST_URI'], '?')));
            
            $sControllerBackend = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_CONTROLLER_BACKEND'];
            $oControllerBackend = new $sControllerBackend($this);
            
            $this->oView->assign('sPageType', mb_substr($sRequest, 0, 4));
            $this->oView->assign('sRequest', '/' . $sRequest);
            $this->oView->assign('sLoginToken', mb_substr($sRequest, 0, 1));

            if ('@' === mb_substr($sRequest, 0, 1))
            {
                $oControllerBackend->backend($sRequest);
                return true;
            }

            \MVC\Event::RUN('blogimus.controller.index.delegate.before', DTArrayObject::create()->add_aKeyValue(
                DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
            ));

            // PAGE
            if (true === $this->_oModel->checkRequestOnToken('page/'))
            {
                \MVC\Event::RUN('blogimus.controller.index.delegate.page.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
                ));
                $aSet = $this->concretePage();
                \MVC\Event::RUN('blogimus.controller.index.delegate.page.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aSet')->set_sValue($aSet)
                ));
            }
            // POST
            elseif (true === $this->_oModel->checkRequestOnToken('post/'))
            {
                // Url was date-hacked, redirect to proper date presentation
                $aSplit = preg_split('@/@', $_SERVER['REQUEST_URI'], NULL, PREG_SPLIT_NO_EMPTY);

                // concrete page is missing, we have date infos in path only if array is < 5
                if (count($aSplit) < 5)
                {
                    // new target is date
                    $aSplit[0] = 'date';
                    $sPath = '/' . implode('/', $aSplit) . '/';
                    \MVC\Request::REDIRECT($sPath);
                }

                \MVC\Event::RUN('blogimus.controller.index.delegate.post.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
                ));
                $aSet = $this->concretePost();
                \MVC\Event::RUN('blogimus.controller.index.delegate.post.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aSet')->set_sValue($aSet)
                ));
            }
            // DATE
            elseif (true === $this->_oModel->checkRequestOnToken('date/'))
            {
                \MVC\Event::RUN('blogimus.controller.index.delegate.date.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aPostDate')->set_sValue($aPostDate)
                ));
                $aDate = $this->concreteDate($aPostDate);
                \MVC\Event::RUN('blogimus.controller.index.delegate.date.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aDate')->set_sValue($aDate)
                ));
            }
            // TAG
            elseif (true === $this->_oModel->checkRequestOnToken('tag/'))
            {
                \MVC\Event::RUN('blogimus.controller.index.delegate.tag.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aTag')->set_sValue($aTag)
                ));
                $aTagInterest = $this->concreteTag($aTag);
                \MVC\Event::RUN('blogimus.controller.index.delegate.tag.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aTagInterest')->set_sValue($aTagInterest)
                ));
            }
            // BLOG OVERVIEW
            elseif ($this->_aRoutingCurrent['path'] === strtok($_SERVER['REQUEST_URI'], '?'))
            {
                \MVC\Event::RUN('blogimus.controller.index.delegate.overview.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
                ));
                $aPostOverview = $this->postOverview();
                \MVC\Event::RUN('blogimus.controller.index.delegate.overview.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('aPostOverview')->set_sValue($aPostOverview)
                ));
            }
            // invalid Request
            else
            {
                \MVC\Event::RUN('blogimus.controller.index.delegate.notfound.before', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
                ));
                $this->notFound();
                \MVC\Event::RUN('blogimus.controller.index.delegate.notfound.after', DTArrayObject::create()->add_aKeyValue(
                    DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
                ));
            }

            \MVC\Event::RUN('blogimus.controller.index.delegate.after', DTArrayObject::create()->add_aKeyValue(
                DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
            ));
        }

        $this->_oModel->setMeta($this->oView);
        \MVC\Event::RUN('blogimus.controller.index.delegate.meta.after', DTArrayObject::create()->add_aKeyValue(
            DTKeyValue::create()->set_sKey('sRequest')->set_sValue($sRequest)
        ));

        // Set Value in sContent Var
        $this->oView->assign(
            'sContent', $this->oView->loadTemplateAsString('index/index.tpl')
        );
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function concretePage()
    {
        $aSet = $this->_oModel->getConcreteFile();

        if (empty($aSet))
        {
            $this->notFound();
        }
        else
        {
            $this->oView->assign('sTitle', $aSet['sName']);
            $this->oView->assign('aSet', $aSet);
            $this->oView->assign('sPage', $aSet['sContent']);
        }
        
        return $aSet;
    }

    /**
     * a concrete post
     * @return mixed
     * @throws \ReflectionException
     */
    public function concretePost()
    {
        $aSet = $this->_oModel->getConcreteFile();

        if (empty($aSet))
        {
            $this->notFound();
        }
        else
        {
            $this->oView->assign('sTitle', $aSet['sName']);
            $this->oView->assign('aSet', $aSet);
            $this->oView->assign('sPost', $aSet['sContent']);
        }
        
        return $aSet;
    }

    /**
     * results on a concrete date
     * @param array $aPostDate
     * @return array
     * @throws \ReflectionException
     */
    public function concreteDate(array $aPostDate = array())
    {
        $sDateRequested = mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), (mb_strlen($this->_aRoutingCurrent['path']) + (mb_strlen('date/'))), (mb_strlen(mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), (mb_strlen($this->_aRoutingCurrent['path']) + (mb_strlen('date/'))))) - 1));
        $aDateRequested = explode('/', $sDateRequested);

        $aDate = array();
        $iYear = (isset($aDateRequested[0])) ? $aDateRequested[0] : false;
        $iMonth = (isset($aDateRequested[1])) ? $aDateRequested[1] : false;
        $iDay = (isset($aDateRequested[2])) ? $aDateRequested[2] : false;

        // handle invalid requests
        if (
            (false !== $iYear && !isset($aPostDate[$iYear])) || (false !== $iMonth && !isset($aPostDate[$iYear][$iMonth])) || (false !== $iDay && !isset($aPostDate[$iYear][$iMonth][$iDay]))
        )
        {
            $this->notFound();
        }
        else
        {
            if (false !== $iYear && isset($aPostDate[$iYear]))
            {
                $aDate['aYear'] = $aPostDate[$iYear];

                if (false !== $iMonth && isset($aPostDate[$iYear][$iMonth]))
                {
                    $aDate['aMonth'] = $aDate['aYear'][$iMonth];

                    if (false !== $iDay && isset($aPostDate[$iYear][$iMonth][$iDay]))
                    {
                        $aDate['aDay'] = $aDate['aMonth'][$iDay];
                    }
                }
            }

            $this->oView->assign('sTitle', implode('-', $aDateRequested));
            $this->oView->assign('aDate', $aDate);
            $this->oView->assign('sDateRequested', implode('-', $aDateRequested));
        }
        
        return $aDate;
    }

    /**
     * results to a concrete tag
     * @param array $aTag
     * @return array
     * @throws \ReflectionException
     */
    public function concreteTag(array $aTag = array())
    {
        $sTagRequested = urldecode(mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), (mb_strlen($this->_aRoutingCurrent['path']) + (mb_strlen('tag/'))), (mb_strlen(mb_substr(strtok($_SERVER['REQUEST_URI'], '?'), (mb_strlen($this->_aRoutingCurrent['path']) + (mb_strlen('tag/'))))) - 1)));
        $aTagInterest = array();

        if (isset($aTag[$sTagRequested]))
        {
            foreach ($aTag[$sTagRequested] as $sCacheFile)
            {
                $aTmp = json_decode(file_get_contents($sCacheFile), true);
                $aTagInterest[] = array(
                    'sName' => $aTmp['sName'],
                    'sUrl' => $aTmp['sUrl']
                );
            }

            $this->oView->assign('sTitle', $sTagRequested);
            $this->oView->assign('sTagInterest', $sTagRequested);
            $this->oView->assign('aTagInterest', $aTagInterest);
        }
        else
        {
            $this->notFound();
        }
        
        return $aTagInterest;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function postOverview()
    {
        // get all posts
        $aPost = $this->_oModel->getPostsOverview();
        $aFinal = array();
        $aTmp = array();

        $iBlogMaxPostOnPage = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_MAX_POST_ON_PAGE'];

        // a param
        $aQuery = \MVC\Request::getInstance()->getQueryArray();
        $iGetA = 0;

        if (isset($aQuery['GET']['a']))
        {
            $aGetA = json_decode($aQuery['GET']['a'], true);

            if (is_array($aGetA) && array_key_exists('start', $aGetA) && isset($aGetA['start']))
            {
                $iGetA = $aGetA['start'];
            }
        }

        // iPaginationToGo
        $iPaginationToGo = round(count($aPost) / $iBlogMaxPostOnPage);
        $aPaginationToGo = array();

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
                $sContent = file_get_contents($aValue['sFilePath']);

                // cut off
                $sContent = mb_substr(
                        $sContent, 0, Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_TEASER_SIZE_IN_OVERVIEW']
                    ) . ' […]';

                // convert markdown to html
                $sContent = $oParsedown->text($sContent);

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
            $aTmp = array();
            $aTmp['iNr'] = $i;
            $aTmp['sUrl'] = '?a={"start":' . (($iBlogMaxPostOnPage * $i) - $iBlogMaxPostOnPage) . '}';
            $aTmp['iA'] = (($iBlogMaxPostOnPage * $i) - $iBlogMaxPostOnPage);
            $aPaginationToGo[] = $aTmp;
        }

        $iMinus = ((isset($iGetA)) ? ($iGetA - $iBlogMaxPostOnPage) : 0);
        $iPlus = ((isset($iGetA)) ? ($iGetA + $iBlogMaxPostOnPage) : 0);
        ($iMinus < 0) ? $iMinus = 0 : false;
        (array_key_exists('iA', $aTmp) && $iPlus > $aTmp['iA']) ? $iPlus = $aTmp['iA'] : false;

        $this->oView->assign('aPaginationToGo', $aPaginationToGo);
        $this->oView->assign('iMinus', $iMinus);
        $this->oView->assign('aParam', ((isset($aQuery['GET']['a'])) ? json_decode($aQuery['GET']['a'], true) : 0));
        $this->oView->assign('iPlus', $iPlus);
        $this->oView->assign('aPost', $aFinal);

        CALC_PAGINATION_SHRINK: {

            $iPaginationRange = round(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_MAX_AMOUNT_PAGINATION_STEPS'] - 1);
            $iArrayIndexStart = null;
            $iArrayIndexEnd = null;

            // if there are more pages as expected in range setting
            if (count($aPaginationToGo) > ($iPaginationRange + 2))
            {
                $iTargetPaginationArrayIndex = ($iGetA / $iBlogMaxPostOnPage);

                $iArrayIndexStart = ($iTargetPaginationArrayIndex - ($iPaginationRange / 2));
                $iArrayIndexEnd = ($iTargetPaginationArrayIndex + ($iPaginationRange / 2));

                ($iArrayIndexStart < 0) ? $iArrayIndexStart = 0 : false;
                ($iArrayIndexEnd < 0) ? $iArrayIndexEnd = 0 : false;

                ($iArrayIndexStart > ($iPaginationToGo - 1)) ? $iArrayIndexStart = ($iPaginationToGo - 1) : false;
                ($iArrayIndexEnd > ($iPaginationToGo - 1)) ? $iArrayIndexEnd = ($iPaginationToGo - 1) : false;

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

            $this->oView->assign('iArrayIndexStart', $iArrayIndexStart);
            $this->oView->assign('iArrayIndexEnd', $iArrayIndexEnd);
            $this->oView->assign('iPaginationPageCurrent', (($iGetA / $iBlogMaxPostOnPage) + 1));
            $this->oView->assign('iPaginationPageMax', count($aPaginationToGo));
            $this->oView->assign('iPaginationToGo', $iPaginationToGo);
        }
        
        return $aFinal;
    }

    /**
     * @throws \ReflectionException
     */
    public function notFound()
    {
        $this->oView->sendHeader404();
        $this->oView->assign('sTitle', '404');
        $this->oView->assign('aSet', array());
        $this->oView->assign('sPage', trim($this->oView->loadTemplateAsString ('index/404.tpl')));
    }

    /**
     * start rendering
     * @access public
     */
    public function __destruct()
    {
        $this->oView->render();
    }
}
