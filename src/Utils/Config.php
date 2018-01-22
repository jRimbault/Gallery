<?php

//namespace App\Utils;


class Config
{
    private $conf;

    public function __construct($filename)
    {
        $this->conf = parse_ini_file($filename, true);
        $this->setLinks();
        ini_set('error_log', Constant::LOG . 'php_error.log');
    }

    private function setLinks()
    {
        $links = [];
        for ($i = 0; $i < count($this->conf['LINK']['url']); $i += 1) {
            $links[$i]['url'] = $this->conf['LINK']['url'][$i];
            $links[$i]['text'] = $this->conf['LINK']['text'][$i] ?? $this->conf['LINK']['url'][$i];
        }
        unset($this->conf['LINK']);
        $this->conf['LINK'] = $links;
    }

    private function search($needle, $array, $params = -1)
    {
        if (!is_array($array)) return false;
        $array = array_change_key_case($array, CASE_LOWER);
        if (isset($array[$needle])) return $array[$needle];
        foreach ($array as $item) {
            $ret = $this->search($needle, $item, $params);
            if ($ret) return $ret;
        }
        return false;
    }

    public function __call($method, $params = [])
    {
        $arg = $params[0] ?? -1;
        $var = strtolower(substr($method, 3));
        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->search($var, $this->conf, $arg);
        }
    }
}
