<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\CommandBus;

use Illuminate\Container\Container;
use TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions\ContainerException;
use TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions\NotFoundException;
use TheRestartProject\RepairDirectory\Application\CommandBus\LaravelContainerAdapter;

/**
 * Test class for the LaravelContainerAdaptor class
 *
 * This set of tests ensures that the behaviour of this adaptor matches the behaviour
 * expected by the ContainerInterface
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\CommandBus
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class LaravelContainerAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that the adaptor can be constructed
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_constructed()
    {
        $adaptor = new LaravelContainerAdapter(new Container());

        self::assertInstanceOf(LaravelContainerAdapter::class, $adaptor);
    }

    /**
     * Tests that it can check if a service exists
     *
     * @test
     *
     * @return void
     */
    public function it_can_check_if_a_service_exists_in_the_container()
    {
        $container = new Container();
        $container->singleton(
            'existingService', function () {
                return new \stdClass();
            }
        );
        $adaptor = new LaravelContainerAdapter($container);

        self::assertFalse($adaptor->has('missingService'));
        self::assertTrue($adaptor->has('existingService'));
    }

    /**
     * Tests that it can fetch an existing service out of the container
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_a_service_out_of_the_container()
    {
        $container = new Container();
        $container->singleton(
            'service', function () {
                $service = new \stdClass();
                $service->foo = 'bar';
                return $service;
            }
        );
        $adaptor = new LaravelContainerAdapter($container);

        $service = $adaptor->get('service');

        self::assertInstanceOf('stdClass', $service);
        self::assertEquals('bar', $service->foo);
    }

    /**
     * Tests that it throws an exception if the service fetched does not exist
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_the_service_cannot_be_found()
    {
        $this->expectException(NotFoundException::class);

        $container = new Container();
        $adaptor = new LaravelContainerAdapter($container);

        $adaptor->get('missingService');
    }

    /**
     * Tests that it throws an exception if the container doesn't work
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_the_container_cannot_produce_the_service_even_though_it_exists()
    {
        $this->expectException(ContainerException::class);

        $container = new Container();
        $container->singleton(
            'existingService', function () {
                throw new \RuntimeException('Something went wrong');
            }
        );

        $adaptor = new LaravelContainerAdapter($container);

        $adaptor->get('existingService');
    }
}
