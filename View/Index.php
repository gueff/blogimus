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
 * @name $BlogimusView
 */
namespace Blogimus\View;

/**
 * Index
 * 
 * @extends \MVC\View
 */
class Index extends \MVC\View
{
	/**
	 * Constructor
     * @throws \ReflectionException
     */
	public function __construct ()
	{
		parent::__construct ();

		$this->sendSecurityHeader();

		// Standard Template
		$this->sTemplate = $this->sTemplateDir . '/layout/index.tpl';

		// Standard Variable in Standard Template
		$this->sContentVar = 'sContent';
	}

	/**
	 * sends a json header
	 * 
	 * @access public
	 * @return void
	 */
	public function sendJsonHeader ()
	{
		header ('Cache-Control: no-cache, must-revalidate');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header ('Content-type: application/json; charset=UTF-8');
	}

	/**
	 * sends a 404 header
	 * 
	 * @access public
	 * @return void
	 */
	public function sendHeader404 ()
	{
		header ("HTTP/1.0 404 Not Found");
	}

    /**
     * set HTTP Security Header
     * @throws \ReflectionException
     */
    public function sendSecurityHeader()
    {
        header("Content-Security-Policy: " . trim(\MVC\Registry::get('CONTENT_SECURITY_POLICY')['Content-Security-Policy']));   // Default
        header("X-Content-Security-Policy: " . \MVC\Registry::get('CONTENT_SECURITY_POLICY')['Content-Security-Policy']);       // IE
        header("X-Webkit-CSP: " . \MVC\Registry::get('CONTENT_SECURITY_POLICY')['Content-Security-Policy']);                    // Chrome und Safari
        header("X-Frame-Options: allow-from " . \MVC\Registry::get('CONTENT_SECURITY_POLICY')['X-Frame-Options']);
        header("X-XSS-Protection: " . \MVC\Registry::get('CONTENT_SECURITY_POLICY')['X-XSS-Protection']);
        header("Strict-Transport-Security: " . \MVC\Registry::get('CONTENT_SECURITY_POLICY')['Strict-Transport-Security']);
    }
}
