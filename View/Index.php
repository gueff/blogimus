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
	 * 
	 * @access public
	 * @return void
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
     */
	public function sendSecurityHeader()
    {
        header("Content-Security-Policy: " . \MVC\Registry::get('BLOG_CONTENT_SECURITY_POLICY'));      // Default
        header("X-Content-Security-Policy: " . \MVC\Registry::get('BLOG_CONTENT_SECURITY_POLICY'));    // IE
        header("X-Webkit-CSP: " . \MVC\Registry::get('BLOG_CONTENT_SECURITY_POLICY'));                 // Chrome und Safari
        header("X-XSS-Protection: " . \MVC\Registry::get('BLOG_X_XSS_Protection'));
        header("X-Frame-Options: allow-from " . \MVC\Registry::get('BLOG_CONTENT_SECURITY_FRAME_PARENTS'));
        header("Strict-Transport-Security: " . \MVC\Registry::get('BLOG_STRICT_TRANSPORT_SECURITY'));
    }
}
