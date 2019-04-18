<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\MVC\View;

class Layout extends View
{
    /**
     * @var string
     */
    private $view;

    public function __construct(\Gekko\MVC\Common\MvcRoute $route, string $viewDir, string $filename, ?string $view, array $binds = [])
    {
        parent::__construct($route, $viewDir, $filename, $binds);
        $this->view = $view;
    }

    public function layout($layoutName): string
    {
        $layout = new Layout($this->route, $this->viewDir, $layoutName, $this->view, $this->binds);
        $content = $layout->render();
        return $content;
    }

    public function content(): string
    {
        foreach ($this->binds as $varname => $value) {
            $$varname = $value;
        }
        $route = $this->route;
        ob_start();
        include $this->fullpath($this->view . ".php");
        $content = ob_get_clean();
        return $content;
    }
}
