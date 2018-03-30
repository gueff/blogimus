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
 * @name $BlogixxEvent
 */
namespace Blogixx\Event;

/**
 * Index
 */
class Index
{
    /**
     * Blogixx\Event\Index
     * 
     * @var Blogixx\Event\Index
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
        \MVC\Event::BIND('mvc.invalidRequest', function() {
            \MVC\Request::REDIRECT('/');
        });
        
		/*
		 * switch on the debug toolbar in develop environment
		 * immediatly after the target class/method was called
		 */
		if ('develop' === \MVC\Registry::get('MVC_ENV'))
		{
			\MVC\Event::BIND ('mvc.reflect.targetObject.after', function ($oObject)
			{
				// switch on ToolBar
				new \InfoTool\Model\Index ($oObject->oView);
			});
		}        

        /*
         * We want to log the end of the request
         */
        \MVC\Event::BIND('mvc.application.destruct', function () {

            \MVC\Log::WRITE(str_repeat('*', 25) . "\t" . 'End of Request' . str_repeat("\n", 6));
        });
    }

    /**
     * Singleton instance
     *
     * @access public
     * @static
     * @return Blogixx\Event\Index
     */
    public static function getInstance()
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
    private function __clone()
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
