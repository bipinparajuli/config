<?php

namespace Utopia\Config;

use Exception;

class Config
{
    /**
     * @var array
     */
    static $params = [];

    /**
     * Load config file
     */
    static public function load(string $key, string $path)
    {
        if(!is_readable($path)) {
            throw new Exception('Failed to load configuration file: '.$path);
        }
        
        self::$params[$key] = include $path;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    static public function setParam($key, $value)
    {
        self::$params[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    static public function getParam(string $key, $default = null)
    {
        $key = explode('.', $key);
        $value = $default;
        $node = self::$params;

        while(!empty($key)) {
            $path = array_shift($key);
            $value = (isset($node[$path])) ? $node[$path] : $default;

            if(is_array($value)) {
                $node = $node[$path];
            }
        }

        return $value;
    }
}
