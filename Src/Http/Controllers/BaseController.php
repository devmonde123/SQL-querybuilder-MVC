<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 01.09.2019
 * Time: 19:25
 */

namespace App\Http\Controllers;

class BaseController
{
    protected static $template = 'default.php';
    protected static $action;
    protected static $view;

    public function __construct($action, $view)
    {
        $this->action = $action;
        $this->view = $view;
    }

    protected static function render($action, $view, $param = [])
    {
        self::$action = $action;
        self::$view = $view;
        extract($param);
        ob_start();
        require dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . self::$action . DIRECTORY_SEPARATOR . self::$view . 'View.php';
        $content = ob_get_clean();
        require dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . self::$template;
    }

    protected static function getViewName($view)
    {
        return strtolower(str_replace('Action', '', $view));
    }

    protected static function ActionIndex1($instanceManager, $limit, $offset)
    {
        $data = $instanceManager->all($limit, $offset);

        return array('data' => $data);
    }

    protected static function ActionDelete1($instanceManager)
    {
        $instanceManager->delete((int)$_POST['id']);
    }

    protected static function ActionShow1($instanceManager, $param)
    {
        return $instanceManager->findBy(array('id' => $param['id']));
    }

    protected static function ActionCount1($instanceManager): int
    {
        $count = $instanceManager->count();
        return $count;
    }

}