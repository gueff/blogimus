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
 * @name $BlogixxModel
 */


namespace Blogixx\Model;


/**
 * Ajax
 */
class Ajax
{

	public $sPageDir;
	public $sPostDir;
	private $_sCheckSum;

	/**
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct ()
	{
		$this->sBlogData = realpath (__DIR__ . '/../') . '/data';
	}

	public function grep($sString = '')
	{
		$aFallback = array(
			'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc}]+/u"
			, 'length' => 10
		);		
		
		$aFilter = (\MVC\Registry::isRegistered('BLOG_AJAX_FILTER')) ? \MVC\Registry::get('BLOG_AJAX_FILTER') : $aFallback;
		(!isset($aFilter['regex'])) ? $aFilter['regex'] = $aFallback['regex'] : false;
		(!isset($aFilter['length'])) ? $aFilter['length'] = $aFallback['length'] : false;
		
		// filter
		$sString = preg_replace($aFilter['regex'], '', $sString);		
		
		$sCmd = '/bin/grep -ril "' . $sString . '" ' . $this->sBlogData . ' | /usr/bin/head -' . $aFilter['length'];
		\MVC\Log::WRITE($sCmd, 'ajax.log');
		$sResult = shell_exec($sCmd);
		
		return $sResult;
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
