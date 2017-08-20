<?php

namespace TheRestartProject\RepairDirectory\Testing;

use Illuminate\Contracts\Console\Kernel;

trait ClearFileSession
{

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runFileSessionClearance()
    {
        //todo: delete all sessions in the storage/framework/sessions folder
//        exec('git clean -fxd ' . storage_path());
    }
}