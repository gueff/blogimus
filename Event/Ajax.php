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
 * @name $BlogixxEvent
 */
namespace Blogixx\Event;

/**
 * Ajax
 */
class Ajax
{
	/**
	 * Blogixx\Event\Ajax
	 * 
	 * @var Blogixx\Event\Ajax
	 * @access private
	 * @static
	 */
	private static $_oInstance = NULL;
	
	/**
	 * Constructor
	 * 
	 * @access protected
	 * @return void
	 */
	protected function __construct()
	{
		// this is not bonded to an event, instead it is executed directly
		\MVC\Helper::ENSURECORRECTPROTOCOL();

		\MVC\Event::BIND('mvc.ids.impact', function($mPackage) {
			\MVC\Log::WRITE($mPackage, 'ids.log');
		});
	}

	/**
	 * Singleton instance
	 *
	 * @access public
	 * @static
	 * @return Blogixx\Event\Ajax
	 */
	public static function getInstance ()
	{
		if (null === self::$_oInstance)
		{
			self::$_oInstance = new self ();
		}

		return self::$_oInstance;
	}	
	
	/**
	 * prevent any cloning
	 * 
	 * @access private
	 * @return void
	 */
	private function __clone ()
	{
		;
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
 
