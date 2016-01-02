<?php

namespace TallySheet\Tools;

/**
 * Description of Request
 *
 * @author pwilvers
 */
class Request {

    protected $_values;

    public function __construct() {
        $this->setValues(array_merge($_GET, $_POST));
    }

    public function getValues() {
        return $this->_values;
    }

    public function setValues($values) {
        $this->_values = $values;
        return $this;
    }

    public function get($key, $default = false, $clear = array()) {
        if (isset($this->_values[$key])) {
            return $this->clear($this->_values[$key], $clear);
        } else {
            file_put_contents(__DIR__ . '/../../../../tmp/log.txt', date('H:i:s') . ' ' . $key . ' Request not Found' . PHP_EOL, FILE_APPEND);
            return $default;
        }
    }

    public function isKeySet($key) {
        return isset($this->_values[$key]);
    }

    public function isKeyEmpty($key) {
        if ($this->isKeySet($key))
            return empty($this->_values[$key]);
        else
            return false;
    }

    protected function clear($param, $clear = array()) {
        foreach ($clear as $key => $value) {
            switch ($value) {
                case 'strTag':
                    $param = strip_tags($param);
                    break;
                case 'replace':
                    $param = preg_replace("/[^a-zA-Z0-9\.\[\]_| -]/", '', $param);
                    break;
                case 'bool':
                    $param = $param == "1" ? true : false;
                    break;
            }
        }
        return $param;
    }

}
