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
	 * Construcor
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
		$sCmd = '/bin/grep -ril "' . $sString . '" ' . $this->sBlogData . ' | /usr/bin/head -10';
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
