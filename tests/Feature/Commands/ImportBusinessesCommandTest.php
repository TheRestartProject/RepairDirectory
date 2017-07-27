<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Commands;

use Illuminate\Support\Facades\Artisan;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Tests\Feature\FeatureTestCase;

/**
 * Class ImportBusinessCommandTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Commands
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ImportBusinessesCommandTest extends FeatureTestCase
{
    /**
     * Test that the businesses have been created
     *
     * @test
     *
     * @return void
     */
    public function itCreatesBusinesses()
    {
        Artisan::call(
            'restart:import:businesses', [
                'file' => base_path('data/test.csv')
            ]
        );

        $this->assertDatabaseHas(
            'businesses', [
                'name' => 'iRepair Centre Bath',
                'address' => '12 Westgate St, Bath',
                'postcode' => 'BA1 1EQ'
            ]
        );
    }
}
