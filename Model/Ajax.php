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
	 * 
	 * @param string $sString requested
	 * @return string $sResult
	 */
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
		$sCmd = \MVC\Registry::get('BLOG_BIN_GREP') . ' -ril "' . $sString . '" ' . \MVC\Registry::get('BLOG_DATA_DIR') . ' | ' . \MVC\Registry::get('BLOG_BIN_HEAD') . ' -' . $aFilter['length'];

		// logs the Requests if enabled in config
		(\MVC\Registry::isRegistered('BLOG_AJAX_LOG_REQUESTS') && true === \MVC\Registry::get('BLOG_AJAX_LOG_REQUESTS')) ? \MVC\Log::WRITE($sCmd, 'ajax.log') : false;

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
