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
 * @name $BlogixxController
 */
namespace Blogixx\Controller;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Ajax implements \MVC\MVCInterface\Controller
{
	/**
	 * View Object
	 * 
	 * @var Blogixx\View\Index
	 * @access public
	 */
	public $oBlogixxViewIndex;
	
	/**
	 * routing array for current page
	 * 
	 * @var array
	 * @access protected
	 */
	protected $_aRoutingCurrent = array();

	/**
	 * @access public
	 * @static
	 */
	public static function __preconstruct ()
	{
		// start event listener
		\Blogixx\Event\Ajax::getInstance ();
	}
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct ()
	{
		$this->oBlogixxViewIndex = new \Blogixx\View\Index();
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
		
		$this->oBlogixxViewIndex->sendJsonHeader();
		$oModel = new \Blogixx\Model\Ajax();
		$sResult = $oModel->grep($sString);
			
		$aResult = preg_split("@\n@", $sResult, NULL, PREG_SPLIT_NO_EMPTY);
		$sPath = realpath(__DIR__ . '/../') . '/data/';
		
		foreach ($aResult as $iKey => $sValue)
		{
			$aResult[$iKey] = str_replace($sPath, '', $sValue);
			$sBasename = basename($aResult[$iKey], '.md');
			$sBasenameSeo = \Blogixx\Model\Index::seoname($sBasename);
			$aResult[$iKey] = str_replace($sBasename, $sBasenameSeo, $aResult[$iKey]);
			
			$sDateOrig = mb_substr($aResult[$iKey], 5, 11);
			
			// filename has leading date
			if ((int) $sDateOrig > 0)
			{
				$sDate = str_replace('-', '#|#', $sDateOrig);
				$aResult[$iKey] = str_replace($sDateOrig, $sDate, $aResult[$iKey]);			
            }			
			
			$aResult[$iKey] = str_replace('/', '#|#', '/' . $aResult[$iKey]);
			$aResult[$iKey] = mb_substr($aResult[$iKey], 0, (strlen($aResult[$iKey]) - 3) ) . '#|#.json';
			
			$sCacheFile = \MVC\Registry::get ('MVC_CACHE_DIR') . '/Blogixx/' . $aResult[$iKey];
			
			if (file_exists ($sCacheFile))
			{
				$aSet = json_decode(
					file_get_contents($sCacheFile), 
					true
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
        $this->oBlogixxViewIndex->sendJsonHeader();
        $oModelIndex = new \Blogixx\Model\Index();        
        echo json_encode(
            array_keys(
                $oModelIndex->getTags()
            )
        );
    }

    /**
	 * Destructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct ()
	{
		;
	}	
}
