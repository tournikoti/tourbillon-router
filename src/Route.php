<?php

namespace Tourbillon\Router;

class Route {

    private $sName;
    private $sUrl;
    private $sController;
    private $sAction;
    private $aMatch;
    private $aParam;

    public function __construct($sName, $aInfo) {
        $this->sName = $sName;
        $this->sUrl = $aInfo['url'];
        $this->sController = self::getControllerName($aInfo['controller']);
        $this->sAction = self::getActionName($aInfo['action']);
        $this->aMatch = isset($aInfo['params']) ? $aInfo['params'] : array();
        $this->aParam = array();
    }

    public function getName() {
        return $this->sName;
    }
    
    public function getUrl() {
        return $this->sUrl;
    }
    
    public function getController() {
        return $this->sController;
    }
    
    public function getAction() {
        return $this->sAction;
    }
    
    public function getMatch() {
        return $this->aMatch;
    }
    
    public function getParam() {
        return $this->aParam;
    }
    
    public function setParam($sName, $mValue) {
        $this->aParam[$sName] = $mValue;
    }
    
    public function generate($aParam = array()) {
        $sUrl = $this->sUrl;
        foreach ($aParam as $key => $value) {
            $sUrl = str_replace("(:$key)", $value, $sUrl);
        }
        return $sUrl;
    }
    
    public static function getControllerName($name) {
        return 'app\\Controller\\' . str_replace("/", "\\", $name) . "Controller";
    }
    
    public static function getActionName($name) {
        return $name . "Action";
    }
}
