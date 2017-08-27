<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Commands\Business\ImportFromHttpRequest;

use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Tests\TestCase;

class ImportFromHttpRequestCommandTest extends TestCase
{
    /**
     * It can be constructed with data and no id
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_constructed_with_data_and_no_id()
    {
        $command = new ImportFromHttpRequestCommand([], null);

        self::assertInstanceOf(ImportFromHttpRequestCommand::class, $command);
    }

    /**
     * It can be constructed with data and an id
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_constructed_with_data_and_an_id()
    {
        $command = new ImportFromHttpRequestCommand([], 1);

        self::assertInstanceOf(ImportFromHttpRequestCommand::class, $command);
    }

    /**
     * It can be get the data
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_the_data()
    {
        $data = [
            'name' => 'Name'
        ];

        $command = new ImportFromHttpRequestCommand($data, 1);

        self::assertEquals($data, $command->getData());
    }

    /**
     * It can be get the data
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_the_id()
    {
        $id = 1;

        $command = new ImportFromHttpRequestCommand([], $id);

        self::assertEquals($id, $command->getBusinessUid());
    }
}
