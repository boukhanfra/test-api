<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 28/11/17
 */

namespace Test\Http;

/**
 * Class Request
 * @package Test\Http
 */
class Request
{

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_DELETE = 'DELETE';
    const HTTP_PUT = 'PUT';

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $splitUri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private static $methods = array('GET', 'POST', 'PUT', 'DELETE');


    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->params = array();
        $this->params = array_merge($this->params, $_GET);
        $this->params = array_merge($this->params, $_POST);
        $this->params = array_merge($this->params, $_FILES);
        $this->params = array_merge($this->params, $_COOKIE);
        $this->content = file_get_contents('php://input');
        $tab = explode('?', $_SERVER['REQUEST_URI']);
        $this->splitUri = explode('/', $tab[0]);
        $this->splitUri = array_splice($this->splitUri, 2);
        $this->uri = '/';
        foreach ($this->splitUri as $u) {
            $this->uri .= $u.'/';
        }
        $this->uri = substr($this->uri, 0, -1);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return mixed
     */
    public function getParam($name)
    {
        if (isset($this->params, $name)) {
            return $this->params[$name];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getSplitUri()
    {
        return $this->splitUri;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public static function createRequest()
    {
        if (!in_array($_SERVER['REQUEST_METHOD'], static::$methods)) {
            throw new \Exception('La méthode Http n\'est pas supportée!');
        }

        return new Request();
    }
}