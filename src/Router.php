<?php

namespace Tourbillon\Router;

use RuntimeException;
use Tourbillon\Request\HttpRequest;
use Tourbillon\Router\Route;

class Router {
    
    private $request;
    
    private $routes;

    public function __construct(HttpRequest $request) {
        $this->request = $request;
        $this->routes = array();
    }

    public function addRoutes(array $routes)
    {
        foreach ($routes as $name => $infos) {
            $this->routes[] = new Route($name, $infos);
        }
    }

    /**
     * Retourne la route en fonction du HttpRequest
     * @return Route
     */
    public function getByRequest() {
        return $this->getByUrl($this->request->getUrl());
    }

    /**
     * Retourne la route correspondant a l'URL
     * @param string $sUrl
     * @return Route
     */
    public function getByUrl($sUrl) {
        foreach ($this->routes as $oRoute) {
            if ($this->match($sUrl, $oRoute)) {
                return $oRoute;
            }
        }
        return null;
    }
    
    /**
     * Retourne la route correspondant au nom
     * @param string $sName
     * @return Route
     */
    public function getByName($sName) {
        foreach ($this->routes as $oRoute) {
            if ($sName === $oRoute->getName()) {
                return $oRoute;
            }
        }
        throw new RuntimeException("No route exist with this name '$sName'");
    }
    
    /**
     * Permet de savoir si une url correspond a une route
     * @param string $sUrl
     * @param \Tourbillon\Routage\Route $oRoute
     * @return boolean
     */
    private function match($sUrl, Route $oRoute) {
        $sRouteUrl = trim($this->request->getBaseUrl() . $oRoute->getUrl(), '/');
                
        foreach ($oRoute->getMatch() as $name => $match) {
            $sRouteUrl = str_replace("(:$name)", "(?<".$name.">$match)", $sRouteUrl);
        }

        if (preg_match_all("#^$sRouteUrl$#", $sUrl, $aMatch, PREG_SET_ORDER)) {
            foreach ($oRoute->getMatch() as $name => $match) {
                $oRoute->setParam($name, $aMatch[0][$name]);
            }
            return true;
        }
        return false;
    }
}
