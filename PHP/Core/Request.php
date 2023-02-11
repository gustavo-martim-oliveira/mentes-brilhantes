<?php

namespace Core;

class Request {
    private static $params;

    public static function get($param = null) {
        if (!self::$params) {
            self::$params = json_decode(json_encode($_REQUEST));
        }
        if (!$param) {
            return self::$params;
        }
        if (isset(self::$params->$param)) {
            return self::$params->$param;
        }
        return null;
    }

    public static function has($param) {
        if (!self::$params) {
            self::$params = json_decode(json_encode($_REQUEST));
        }
        return property_exists(self::$params, $param);
    }

    public static function all(){
        self::$params = json_decode(json_encode($_REQUEST));
        return self::$params;
    }
}
