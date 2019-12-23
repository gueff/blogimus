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
 * @name $BlogimusModel
 */


namespace Blogimus\Model;

use MVC\Registry;

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
		;
	}

	/**
	 * greps in contents for the requested string 
     * @param string $sString
     * @return string|null
     * @throws \ReflectionException
     */
	public function grep($sString = '')
	{
		$aFallback = array(
			'regex' => "/[^\\p{L}\\p{M}\\p{Z}\\p{S}\\p{N}\\p{Pd}\\p{Pc}]+/u"
			, 'length' => 10
		);		
		
		$aFilter = (isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_AJAX_FILTER'])) ? Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_AJAX_FILTER'] : $aFallback;
		(!isset($aFilter['regex'])) ? $aFilter['regex'] = $aFallback['regex'] : false;
		(!isset($aFilter['length'])) ? $aFilter['length'] = $aFallback['length'] : false;
		
		// filter
		$sString = preg_replace($aFilter['regex'], '', $sString);		
		$sCmd = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BIN_GREP'] . ' -ril "' . $sString . '" ' . Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_DATA_DIR'] . ' | ' . Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BIN_HEAD'] . ' -' . $aFilter['length'];

		// logs the Requests if enabled in config
		(isset(Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_AJAX_LOG_REQUESTS']) && true === Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_AJAX_LOG_REQUESTS']) ? \MVC\Log::WRITE($sCmd, 'ajax.log') : false;

		// execute
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
