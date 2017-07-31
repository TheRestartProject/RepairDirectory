<?php

namespace TheRestartProject\RepairDirectory\Application\Tactician;

use Illuminate\Contracts\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Allows the Laravel Container to be used as an InteropContainer
 *
 * @category Adapter
 * @package  TheRestartProject\RepairDirectory\Application\Tactician
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class LaravelContainerAdapter implements ContainerInterface
{
    /**
     * An instance of the Laravel Container
     *
     * @var Container
     */
    private $container;

    /**
     * Constructs the Adapter with the Laravel Container
     *
     * @param Container $container The Laravel Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        return $this->container->make($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->container->bound($id);
    }
}
