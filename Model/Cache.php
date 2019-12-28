<?php

/**
 * Cache.php
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


use Blogimus\DataType\DTCachefile;
use MVC\Helper;
use MVC\Registry;

class Cache
{

    public function __construct()
    {
        ;
    }
    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getCachedPagePostFiles()
    {
        $sFolder = Registry::get('MVC_CACHE_DIR') . '/Blogimus/';

        $sCmd = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BIN_FIND'] . ' '
            . $sFolder
            . ' -name "#|#*#|#.json" -type f -print'
        ;
        $sList = shell_exec($sCmd);

        $aList = array_map(
            function($sValue) {
                global $sFolder;
                return mb_substr($sValue, mb_strlen($sFolder));
            }, array_map(
                'trim',
                preg_split(
                    "@\n@",
                    $sList,
                    NULL,
                    PREG_SPLIT_NO_EMPTY
                )
            )
        );

        return $aList;
    }

    /**
     * @throws \ReflectionException
     */
    public static function autoCleanUpCachedFiles()
    {
        $aList = self::getCachedPagePostFiles();
        $sFolder = Registry::get('MVC_CACHE_DIR') . '/Blogimus/';

        foreach ($aList as $sCachefile)
        {
            $sCmd = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['BLOG_BIN_GREP']
                . ' -r "' . str_replace($sFolder, '', $sCachefile) . '" ' . $sFolder . 'a*.json';
            $bCacheFileIsActive = (boolean) trim(shell_exec($sCmd));

            if (false === $bCacheFileIsActive && true === file_exists($sCachefile))
            {
                unlink($sCachefile);
            }
        }
    }

    /**
     * @param string $sFilenameAbsolute
     * @param string $sType
     * @return string
     * @throws \ReflectionException
     */
    public static function fromFilenameAbsToCacheFilename($sFilenameAbsolute = '', $sType = '')
    {
        if ('' === $sFilenameAbsolute || '' === $sType)
        {
            return DTCachefile::create();
        }

        $sBasename = basename($sFilenameAbsolute);
        $sType = strtolower(trim($sType));
        $sDate = '';

        if ('page' === $sType)
        {
            $sRest = '#|#' . Index::seoname(str_replace('.md', '', $sBasename));
        }
        elseif ('post' === $sType)
        {
            $sRest = '#|#' . Index::seoname(str_replace('.md', '', mb_substr($sBasename, mb_strlen(strtok($sBasename, '.')))));
            $sDate = '#|#' . str_replace('-', '#|#', strtok($sBasename, '.'));
        }
        else
        {
            return DTCachefile::create();
        }

        $sFolder = \MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus';
        $sFilename = '#|#' . $sType . $sDate . $sRest . '#|#.json';
        $sFilenameAbsolute = $sFolder . '/' . $sFilename;

        $oCachefile = DTCachefile::create()
            ->set_sType($sType)
            ->set_sFolder(\MVC\Registry::get('MVC_CACHE_DIR') . '/Blogimus')
            ->set_sFilename($sFilename)
            ->set_sFilenameAbsolute($sFilenameAbsolute)
            ->set_bFileExists(file_exists($sFilenameAbsolute))
            ;

        return $oCachefile;
    }

}