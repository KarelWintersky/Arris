<?php

namespace Arris;

use Adbar\Dot;

/**
 * Class AppConfig
 * @package Arris
 */
class AppConfig implements AppConfigInterface
{
    protected static $instance = null;

    /**
     *
     * @param Dot $instance
     * @return Dot
     */
    public static function init(Dot &$instance)
    {
        self::$instance = $instance;
        return $instance;
    }

    /**
     *
     * @return Dot
     */
    public static function get(): Dot
    {
        return self::$instance;
    }

    /**
     *
     * @param Dot $instance
     */
    public static function set(Dot &$instance)
    {
        self::$instance = $instance;
    }

    public static function importPHPFile($set)
    {

    }

    public static function importJSONFile($file)
    {

    }

}