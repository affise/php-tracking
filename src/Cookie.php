<?php

namespace Affise\Tracking;

class Cookie
{
    private const QUERY_PARAM = ["click_id", "clickid", "afclick"];
    private const COOKIE_NAME = "afclick";

    /**
     * @return void
     * @throws CookieInvalidParamException
     * @throws CookieUnsetException
     */
    public static function set()
    {
        $val = "";
        foreach ([$_GET, $_POST] as $src) {
            foreach (self::QUERY_PARAM as $key) {
                if (isset($src[$key])) {
                    $val = $src[$key];
                    break 2;
                }
            }
        }

        if ($val === "") {
            throw new CookieInvalidParamException();
        }

        $r = setcookie(self::COOKIE_NAME, $val, time()+3600*24*365, "/", $_SERVER['HTTP_HOST'], true, false);
        if (!$r) {
            throw new CookieUnsetException();
        }
    }
}
