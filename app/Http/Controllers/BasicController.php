<?php

namespace App\Http\Controllers;

class BasicController extends Controller
{
    public static $list = [];

    /*
    // if you uncomment these lines the list is reset every request
    function __construct() {
        self::$list = [];
    }
    */

    public function addItem()
    {
        self::$list[] = random_int(1, 6);

        return self::$list;
    }
}
