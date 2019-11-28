<?php

//Controllers
$router->map('GET', 'users/index', 'App\Http\Controllers\Admin\Users\UsersController#ActionIndex');
$router->map('POST', 'users/delete', 'App\Http\Controllers\Admin\Users\UsersController#ActionDelete');
$router->map('GET', 'users/show/[i:id]?', 'App\Http\Controllers\Admin\Users\UsersController#ActionShow');
$router->map('GET', 'users/update/[i:id]?', 'App\Http\Controllers\Admin\Users\UsersController#ActionUpdate');
$router->map('POST', 'users/create', 'App\Http\Controllers\Admin\Users\UsersController#ActionCreate');
$router->map('GET', 'users/add', 'App\Http\Controllers\Admin\Users\UsersController#ActionAdd');

$router->map('GET', '404', 'App\Http\Controllers\Admin\Errors\ErrorsController#Action404');