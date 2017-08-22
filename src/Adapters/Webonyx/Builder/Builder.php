<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Adapters\Webonyx\Builder;

use Railt\Routing\Router;
use Railt\Support\Dispatcher;
use Railt\Adapters\Webonyx\Loader;
use Railt\Adapters\Webonyx\BuilderInterface;
use Railt\Reflection\Abstraction\Type\TypeInterface;
use Railt\Reflection\Abstraction\DefinitionInterface;

/**
 * Class Builder
 * @package Railt\Adapters\Webonyx
 */
abstract class Builder implements BuilderInterface
{
    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var DefinitionInterface|TypeInterface
     */
    protected $type;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Builder constructor.
     * @param Dispatcher $events
     * @param Router $router
     * @param Loader $loader
     * @param DefinitionInterface|TypeInterface $target
     */
    public function __construct(Dispatcher $events, Router $router, Loader $loader, $target)
    {
        $this->type = $target;
        $this->loader = $loader;
        $this->events = $events;
        $this->router = $router;
    }

    /**
     * @param string $event
     * @param array ...$args
     * @return $this
     */
    protected function fire(string $event, ...$args)
    {
        $this->events->dispatch($event, $args);

        return $this;
    }

    /**
     * @return Loader
     */
    public function getLoader(): Loader
    {
        return $this->loader;
    }

    /**
     * @return DefinitionInterface|TypeInterface
     */
    public function getTarget()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return mixed
     * @throws \LogicException
     * @throws \Railt\Exceptions\UnexpectedTokenException
     * @throws \Railt\Exceptions\UnrecognizedTokenException
     */
    protected function resolve(string $type)
    {
        return $this->loader->resolve($type);
    }

    /**
     * @param DefinitionInterface|TypeInterface $definition
     * @param string $class
     * @return mixed
     * @throws \LogicException
     */
    protected function make($definition, string $class)
    {
        return $this->loader->make($definition, $class);
    }
}
