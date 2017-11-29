<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 2017-11-28
 */

include_once 'vendor/autoload.php';

use Test\Http\Request;

$routes = array (
    '/user' => 'Test\Controller\UserController',
    '/task' => 'Test\Controller\TaskController'
);

try {
    $request = Request::createRequest();
    $prefix = '/'.$request->getSplitUri()[0];
    if (!key_exists($prefix, $routes)) {
        return new \Test\Http\Response(array('message' => 'La route n\'existe pas!'), 404,
            array('content-type' => 'application/json')
        );
    }

    /**
     * @var \Test\Controller\Controller $controller
     */
    $controller = new $routes[$prefix]();

    $controller->exec($request);


} catch (\Exception $e) {
    return new \Test\Http\Response($e->getMessage(), $e->getCode(),
        array('content-type' => 'application/json')
    );
}

