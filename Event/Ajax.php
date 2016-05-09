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
		\MVC\Request::ENSURECORRECTPROTOCOL();

		/*
		 * What to do if IDS detects an impact
		 */
		\MVC\Event::BIND ('mvc.ids.impact.warn', function($oIdsReport) {

			\MVC\Log::WRITE("WARN\t" . \MVC\IDS::getReport ($oIdsReport), 'ids.log');
			
			// dispose infected Variables mentioned in report
			\MVC\IDS::dispose($oIdsReport);
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
 
