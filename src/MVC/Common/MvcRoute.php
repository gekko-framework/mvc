<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\MVC\Common;

use \Gekko\Helpers\Utils;

class MvcRoute
{
    /**
     * @var \Gekko\Http\IHttpRequest
     */
    protected $request;

    /**
     * @var \Gekko\Http\Routing\Route
     */
    protected $route;

    public function __construct(\Gekko\Http\IHttpRequest $request, \Gekko\Http\Routing\Route $route)
    {
        $this->request = $request;
        $this->route = $route;
    }

    public function rootUri() : string
    {
        return $this->request->getRootUri();
    }

    public function rootDir() : string
    {
        return $this->request->getRootDir();
    }

    public function hostname() : string
    {
        return $this->request->hostname();
    }

    public function link($uri): string
    {
        return $this->request->getRootUri($uri);
    }

    public function rellink($uri) : string
    {
        $routeBaseUrl = $this->route->getRoutingMap()->getBaseUrl();
        if ($routeBaseUrl[strlen($routeBaseUrl)-1] != '/' && $uri[0] != '/') {
            $routeBaseUrl .= "/";
        }
        return $this->request->getRootUri("{$routeBaseUrl}{$uri}");
    }

    public function isRootUri(): bool
    {
        $currentPath = Utils::uriToArray($this->request->getURI()->getPath());
        $appBaseUrl = Utils::uriToArray($this->request->getRootUri());

        return $currentPath === $appBaseUrl;
    }

    public function isBaseUri() : bool
    {
        $currentPath = Utils::uriToArray($this->request->getURI()->getPath());
        $routeBaseUrl = Utils::uriToArray($this->route->getRoutingMap()->getBaseUrl());

        return $currentPath === $routeBaseUrl;
    }
}
