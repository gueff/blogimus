<?php

/**
 * Ajax.php
 *
 * @package myMVC
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusController
 */
namespace Blogimus\Controller;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Ajax implements \MVC\MVCInterface\Controller
{
    /**
     * View Object
     * @access public
     */
    public $oView;

    /**
     * routing array for current page
     * @var array
     * @access protected
     */
    protected $_aRoutingCurrent = array();

    /**
     * @access public
     * @static
     */
    public static function __preconstruct()
    {
        // start event listener
        \Blogimus\Event\Ajax::getInstance();
    }

    /**
     * Constructor
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $sView = \MVC\Registry::get('BLOG_CLASS_VIEW_INDEX');
        $this->oView = new $sView(); 
        $this->_aRoutingCurrent = \MVC\Registry::get('MVC_ROUTING_CURRENT');
    }

    /**
     * echos out results to requested string as JSON array
     * @access public
     * @return void 
     */
    public function index($sString = '')
    {        
        $aFinal = array();

        $this->oView->sendJsonHeader();
        $sModelAjax = \MVC\Registry::get('BLOG_CLASS_MODEL_AJAX');
        $oModel = new $sModelAjax();
        $sResult = $oModel->grep($sString);

        $aResult = preg_split("@\n@", $sResult, NULL, PREG_SPLIT_NO_EMPTY);
        $sPath = \MVC\Registry::get('BLOG_DATA_DIR');

        foreach ($aResult as $iKey => $sValue)
        {
            $aResult[$iKey] = str_replace($sPath, '', $sValue);
            $sBasename = basename($aResult[$iKey], '.md');
            
            $sModelIndex = \MVC\Registry::get('BLOG_CLASS_MODEL_INDEX');
            $sBasenameSeo = $sModelIndex::seoname($sBasename);
            
            $aResult[$iKey] = str_replace($sBasename, $sBasenameSeo, $aResult[$iKey]);

            $sDateOrig = mb_substr($aResult[$iKey], 6, 11);

            // filename has leading date
            if ((int) $sDateOrig > 0)
            {
                $sDate = str_replace('-', '#|#', $sDateOrig);
                $aResult[$iKey] = str_replace($sDateOrig, $sDate, $aResult[$iKey]);
            }

            $aResult[$iKey] = str_replace('/', '#|#', $aResult[$iKey]);
            $aResult[$iKey] = mb_substr($aResult[$iKey], 0, (strlen($aResult[$iKey]) - 3)) . '#|#.json';

            $sCacheFile = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus/' . $aResult[$iKey];

            if (file_exists($sCacheFile))
            {
                $aSet = json_decode(
                    file_get_contents($sCacheFile), true
                );

                $aFinal[] = array($aSet['sName'], $aSet['sUrl']);
            }
        }

        echo json_encode($aFinal);
    }

    /**
     * echos out the taglist as JSON array
     * @access public
     * @return void 
     */
    public function taglist()
    {
        $this->oView->sendJsonHeader();
        
        $sModelIndex = \MVC\Registry::get('BLOG_CLASS_MODEL_INDEX');
        $oModelIndex = new $sModelIndex();
        
        $aTag = $oModelIndex->getTags();
        ksort($aTag, SORT_STRING | SORT_FLAG_CASE);
        echo json_encode(
            array_keys(
                $aTag
            )
        );
    }

    /**
     * Destructor
     * 
     * @access public
     * @return void
     */
    public function __destruct()
    {
        ;
    }
}
