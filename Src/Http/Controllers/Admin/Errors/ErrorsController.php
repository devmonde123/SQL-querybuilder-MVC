<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 27.09.2019
 * Time: 01:25
 */

namespace App\Http\Controllers\Admin\Errors;

use App\Http\Controllers\BaseController;

class ErrorsController extends BaseController
{
    static $action = "errors";

    public function __construct()
    {

    }

    public static function Action404()
    {
        parent::render(self::$action, self::getViewName(__FUNCTION__));
        exit();
    }
}