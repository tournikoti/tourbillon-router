<?php

namespace Tourbillon\Router;

class Route {

    private $name;
    private $url;
    private $controller;
    private $action;
    private $matches;
    private $params;

    public function __construct($name, $aInfo) {
        $this->name = $name;
        $this->url = $aInfo['url'];
        $this->controller = $this->parseController($aInfo['controller']);
        $this->action = $this->parseAction($aInfo['action']);
        $this->matches = isset($aInfo['params']) ? $aInfo['params'] : array();
        $this->params = array();
    }

    public function getName() {
        return $this->name;
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getController() {
        return $this->controller;
    }
    
    public function getAction() {
        return $this->action;
    }
    
    public function getMatch() {
        return $this->matches;
    }
    
    public function getParam() {
        return $this->params;
    }
    
    public function setParam($name, $mValue) {
        $this->params[$name] = $mValue;
    }
    
    public function generate($params = array()) {
        $url = $this->url;
        foreach ($params as $key => $value) {
            $url = str_replace("(:$key)", $value, $url);
        }
        return $url;
    }
    
    private function parseController($name) {
        return str_replace("/", "\\", $name);
    }
    
    private function parseAction($name) {
        return $name;
    }
}
