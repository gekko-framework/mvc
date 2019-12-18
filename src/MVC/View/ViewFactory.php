<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\MVC\View;

class ViewFactory
{
    /**
     * @var \Gekko\DependencyInjection\IDependencyInjector
     */
    private $injector;

    /**
     * @var \Gekko\Http\IHttpRequest
     */
    protected $request;

    public function __construct(\Gekko\DependencyInjection\IDependencyInjector $injector)
    {
        $this->injector = $injector;
        $this->request = $this->injector->make(\Gekko\Http\IHttpRequest::class);
    }

    public function create(\Gekko\MVC\Common\MvcRoute $route, string $viewDir, ?string $layout, string $view) : View
    {
        if (!empty($layout)) {
            return (new \Gekko\MVC\View\Layout($route, $viewDir, $layout, $view));
        }
        return (new \Gekko\MVC\View\View($route, $viewDir, $view));
    }
}
