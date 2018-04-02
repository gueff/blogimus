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
 * @name $BlogimusEvent
 */
namespace Blogimus\Event;

/**
 * Ajax
 */
class Ajax
{
    /**
     * Blogimus\Event\Ajax
     * 
     * @var Blogimus\Event\Ajax
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
//        \MVC\Request::ENSURECORRECTPROTOCOL();
    }

    /**
     * Singleton instance
     *
     * @access public
     * @static
     * @return Blogimus\Event\Ajax
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
