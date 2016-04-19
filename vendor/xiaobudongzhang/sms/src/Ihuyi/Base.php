<?php
namespace Byz\Sms\Ihuyi;

class Base
{
    public $config = array(
        'user_name' => '',
        'password' => '',
        'scheme' => 'http',
        'host' => '',
        'method' => '',
    );
    public function __construct( $host, $method, $user_name, $password,$scheme='http')
    {
        $this->config['scheme'] = $scheme;
        $this->config['host'] = $host;
        $this->config['method'] = $method;
        $this->config['user_name'] = $user_name;
        $this->config['password'] = $password;
    }
    /**
     *send sms
     * @param  array   $mobile
     * @param  string  $content
     * @return array
     */
    public function send($mobile, $content)
    {
        $target = $this->config['scheme'] . '://' . $this->config['host'] . '/' . $this->config['method'];
        $url = $target . "&account=" . $this->config['user_name'] . "&password=" . $this->config['password'] . "&mobile=" . $mobile . "&content=" . rawurlencode($content);
        $response = file_get_contents($url);
        $xml = simplexml_load_string($response);
        return $xml;
    }

}
