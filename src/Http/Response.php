<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 28/11/17
 */

namespace Test\Http;

/**
 * Class Response
 * @package Test\Http
 */
class Response
{
    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $headers;


    /**
     * Response constructor.
     * @param array $content
     * @param int $code
     * @param array $headers
     */
    public function __construct($content = array(), $code = 200, $headers = array())
    {
        $this->content = json_encode(array('message' => $content));
        $this->code = $code;
        $this->headers = array_merge($headers, array('content-type' => 'application/json'));
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
        header('HTTP/1.1 '.$this->code.' '.$this->content);
        echo $this->content;
    }
}
