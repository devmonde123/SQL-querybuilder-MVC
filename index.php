<?php
require_once 'vendor/autoload.php';

use App\Managers\UsersManager;

$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('config.php');
$container = $builder->build();
$router = new AltoRouter();
require_once 'routes/routing.php';
$router->setBasePath('/');
$match = $router->match();
if($match) {
    list( $controller, $action ) = explode( '#', $match["target"] );
    if ( is_callable(array($controller, $action)) ) {

        call_user_func_array(array($controller,$action), array($match['params']));
    }
}else {
    header("HTTP/1.0 404 Not Found");
    header('Location: /404');
}
exit;