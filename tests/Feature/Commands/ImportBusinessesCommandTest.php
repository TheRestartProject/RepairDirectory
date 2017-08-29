<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Class ImportBusinessCommandTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Commands
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ImportBusinessesCommandTest extends IntegrationTestCase
{
    use DatabaseMigrations;
    /**
     * Test that the businesses have been created
     *
     * @test
     *
     * @return void
     */
    public function it_persists_businesses()
    {
        Artisan::call(
            'restart:import:businesses', [
                'file' => base_path('data/test.csv')
            ]
        );

        $this->assertDatabaseHas(
            'businesses', [
                'name' => 'iRepair Centre Bath',
                'address' => '12 Westgate St',
                'city' => 'Bath',
                'postcode' => 'BA1 1EQ'
            ]
        );
    }
}
