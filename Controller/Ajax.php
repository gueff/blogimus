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

use Blogimus\DataType\Post;
use MVC\Helper;
use MVC\Log;
use MVC\Registry;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Ajax implements \MVC\MVCInterface\Controller
{

    /**
     * @var \Blogimus\Model\Backend
     */
    public $oModelBackend;

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
        ;
    }

    /**
     * Ajax constructor.
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $sView = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_VIEW_INDEX'];
        $this->oView = new $sView();
        $this->oModelBackend = new \Blogimus\Model\Backend();
        $this->_aRoutingCurrent = Registry::get('MVC_ROUTING_CURRENT');
    }

    /**
     * echos out results to requested string as JSON array
     * @param string $sString
     * @throws \ReflectionException
     */
    public function index($sString = '')
    {
        $aFinal = array();

        $sModelAjax = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_AJAX'];
        $oModel = new $sModelAjax();
        $sResult = $oModel->grep($sString);

        $aResult = preg_split("@\n@", $sResult, NULL, PREG_SPLIT_NO_EMPTY);
        $sPath = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'];

        foreach ($aResult as $iKey => $sValue)
        {
            $aResult[$iKey] = str_replace($sPath, '', $sValue);
            $sBasename = basename($aResult[$iKey], '.md');
            
            $sModelIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_INDEX'];
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

            $sCacheFile = Registry::get('MVC_CACHE_DIR') . '/' . Registry::get('MODULE_FOLDERNAME') . '/' . $aResult[$iKey];

            if (file_exists($sCacheFile))
            {
                $aSet = json_decode(
                    file_get_contents($sCacheFile), true
                );

                $aFinal[] = array($aSet['sName'], $aSet['sUrl']);
            }
        }

        $this->oView->sendJsonHeader();
        echo json_encode($aFinal);
    }

    /**
     * echos out the taglist as JSON array
     * @throws \ReflectionException
     */
    public function taglist()
    {
        $sModelIndex = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_CLASS_MODEL_INDEX'];
        $oModelIndex = new $sModelIndex();
        
        $aTag = $oModelIndex->getTags();
        ksort($aTag, SORT_STRING | SORT_FLAG_CASE);

        $this->oView->sendJsonHeader();
        echo json_encode(
            array_keys(
                $aTag
            )
        );
    }

    /**
     * @todo für diese Methode Session aktivieren !
     * @throws \ReflectionException
     */
    public function update()
    {
        $oPost = Post::create($_POST);
        $oResponse = $this->oModelBackend->save($oPost);

        $this->oView->sendJsonHeader();
        echo json_encode($oResponse->getPropertyArray());
    }

    /**
     * Destructor
     * @access public
     */
    public function __destruct()
    {
        ;
    }
}
