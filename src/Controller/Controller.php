<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 28/11/17
 */

namespace Test\Controller;

use Test\Http\Request;
use Test\Http\Response;

/**
 * Class Controller
 * @package Test\Controller
 */
abstract class Controller
{
    /**
     * @var array
     */
    protected $routes = array();

    protected $prefix = '';

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function exec(Request $request)
    {
        $this->configurePrefix();
        $this->configureRoutes();
        $found = false;
        $response = null;
        if(1 == count($request->getSplitUri())) {
            foreach ($this->routes as $route) {
                if (false !== strpos($route['format'], '#')) {
                    if ($request->getMethod() == $route['method'] && false === $route['param']) {
                        $found = true;
                        $response = $this->{$route['action']}($request);
                    }
                }
            }
        } else {
            foreach ($this->routes as $route) {
                if (preg_match('#^('.$this->prefix.'/'.$route['format'].')$#', $request->getUri())) {
                    if ($request->getMethod() == $route['method']) {
                        $found = true;
                        $response = $this->{$route['action']}($request);
                    }
                }
            }
        }

        if (false === $found) {
            return new Response('La route est introuvable!', 404);
        }

        return $response;
    }

    public abstract function configureRoutes();


    public abstract function configurePrefix();
}