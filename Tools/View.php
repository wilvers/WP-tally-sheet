<?php

namespace TallySheet\Tools;

/**
 *
 * Enter description here ...
 * @author phuysmans
 *
 */
class View {

    protected $_file;
    protected $_map;

    public function setFile($file) {
        $this->_file = $file;
        return $this;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $controller
     * @param unknown_type $action
     * @param unknown_type $view
     * @param unknown_type $params
     */
    public function partial($controller = null, $action = null, $view = null, $params = null) {
        if (null !== $controller) {

        }
    }

    /**
     *
     * Enter description here ...
     * TODO path translation ?
     * @param unknown_type $file
     */
    public function inc($file) {
        if (file_exists($file)) {
            include $file;
        } else {
            var_dump('warn', sprintf('%s: cant find include file %s', __METHOD__, $file));
        }
    }

    /**
     *
     * Catch anything that we havent defined
     * @param unknown_type $name
     * @param unknown_type $args
     */
    public function __call($name, $args) {
        var_dump('warn', sprintf('%s: nonexisting method called %s (%s)', __METHOD__, $name, var_export($args, true)));
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $key
     * @param unknown_type $name
     */
    public function __set($key, $name) {
        var_dump('warn', sprintf('%s: setting $key not allowed, use assign', __METHOD__, $key));
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $key
     */
    public function __get($key) {
        if (is_array($this->_map) && array_key_exists($key, $this->_map)) {
            return $this->_map[$key];
        }
        /// file_put_contents(__DIR__ . '/../../../tmp/log.txt', date('H:i:s') . ' ' . sprintf('view key not found %s ', $key) . PHP_EOL, FILE_APPEND);
//        var_dump('warn', sprintf('%s: getting non existing $key', __METHOD__, $key));
        return null;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $name
     * @param unknown_type $value
     */
    public function assign($name, $value = null) {
        if (is_string($name)) {
            $this->_map[$name] = $value;
        } elseif (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->assign($key, $value);
            }
        }
        return $this;
    }

    public function clear() {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if ('_' !== substr($key, 0, 1)) {
                unset($this->{$key});
            }
        }
        return $this;
    }

    /**
     *
     * renders a template
     * @param string $name
     */
    public function render($name) {
        $this->setFile($name);
        if (file_exists($this->_file)) {
            ob_start();
            include($this->_file);
            return ob_get_clean();
        } else {
            throw new \Exception("View file does not exist $this->_file");
        }
    }

}
