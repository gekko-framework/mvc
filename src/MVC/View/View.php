<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\MVC\View;

class View implements IView
{
    /**
     * @var \Gekko\MVC\Common\MvcRoute
     */
    protected $route;

    /**
     * @var string
     */
    protected $viewDir;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $binds;

    /**
     * @var array
     */
    private static $reservedVars = ['route'];

    public function __construct(\Gekko\MVC\Common\MvcRoute $route, string $viewDir, string $filename, array $binds = [])
    {
        $this->route = $route;
        $this->viewDir = $viewDir;
        $this->filename = $filename;
        $this->binds = $binds;
    }

    public function bind($varname, $value) : self
    {
        if (in_array($varname, self::$reservedVars)) {
            throw new \Exception("{$varname} is a reserverd variable. Please choose a different name");
        }
        $this->binds[$varname] = $value;

        return $this;
    }

    protected function uri(?string $file = null) : string
    {
        return str_replace(DIRECTORY_SEPARATOR, "/", $this->route->rootUri() . $this->viewDir . "/" . ($file != null ? $file : ""));
    }

    protected function fullpath(?string $file = null) : string
    {
        return $this->route->toLocalPath($this->viewDir . DIRECTORY_SEPARATOR . ($file ?? ""));
    }

    public function render() : string
    {
        foreach ($this->binds as $varname => $value) {
            $$varname = $value;
        }
        $route = $this->route;
        ob_start();
        include $this->fullpath($this->filename . ".php");
        $content = ob_get_clean();
        return $content;
    }
}
