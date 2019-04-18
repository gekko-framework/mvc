<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\MVC\Controller;

use \Gekko\Http\IHttpRequest;
use \Gekko\Http\Routing\Route;
use \Gekko\MVC\Common\MvcRoute;
use \Gekko\MVC\View\ViewFactory;
use \Gekko\Http\Routing\IHttpController;
use \Gekko\DependencyInjection\IDependencyInjector;

abstract class MvcController implements IHttpController
{
    /**
     * @var \Gekko\DependencyInjection\IDependencyInjector
     */
    protected $injector;

    /**
     * @var \Gekko\MVC\View\ViewFactory
     */
    protected $viewFactory;

    /**
     * @var \Gekko\Http\IHttpRequest
     */
    protected $request;

    public function __construct(IDependencyInjector $injector)
    {
        $this->injector = $injector;
        $this->viewFactory = $injector->make(ViewFactory::class);
        $this->request = $injector->make(IHttpRequest::class);
    }

    abstract protected function viewPath() : string;
    abstract protected function layoutName() : string;

    protected function view($viewName)
    {
        return $this->viewFactory->create(new MvcRoute($this->request, $this->injector->make(Route::class)), $this->viewPath(), $this->layoutName(), $viewName);
    }
}
