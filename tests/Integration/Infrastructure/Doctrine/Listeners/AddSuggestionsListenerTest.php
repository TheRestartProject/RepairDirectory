<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Listeners;

use Doctrine\ORM\EntityManager;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * AddSuggestionsListener Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Listeners
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class AddSuggestionsListenerTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * Store a reference to the entity manager so that it can
     * be used to create and update entities and persist
     * the changes.
     *
     * @var EntityManager 
     */
    private $entityManager;

    /**
     * Set up the test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->entityManager = $this->app->make(EntityManager::class);
    }

    /**
     * Asserts that persisting and flushing a business creates suggestions
     *
     * @return void
     *
     * @test
     */
    public function it_adds_suggestions_when_businesses_are_created()
    {
        $business = new Business();
        $business->setName('Repair Ltd');
        $business->setDescription('Repair your devices');
        $business->setPostcode('BA2 6PA');
        $business->setAddress('34 Bristol Road');
        $business->setProductsRepaired(['NewTestPhone', 'NewTestPhoneX']);
        $business->setAuthorisedBrands(['Outlandish', 'Unit4']);
        $this->entityManager->persist($business);
        $this->entityManager->flush();

        $this->assertTestSuggestions();
    }

    /**
     * Asserts that updating and flushing a business creates suggestions
     *
     * @test
     *
     * @return void
     */
    public function it_adds_suggestions_when_businesses_are_updated()
    {
        entity(Business::class)->create();
        $business = $this->entityManager->getRepository(Business::class)->find(1);
        $business->setProductsRepaired(['NewTestPhone', 'NewTestPhoneX']);
        $business->setAuthorisedBrands(['Outlandish', 'Unit4']);
        $this->entityManager->flush();

        $this->assertTestSuggestions();
    }

    /**
     * Assert that the test suggestions exist
     *
     * @return void
     */
    private function assertTestSuggestions()
    {
        $this->assertDatabaseHas(
            'suggestions',
            [
                'field' => 'productsRepaired',
                'value' => 'NewTestPhone'
            ]
        );
        $this->assertDatabaseHas(
            'suggestions',
            [
                'field' => 'productsRepaired',
                'value' => 'NewTestPhoneX'
            ]
        );
        $this->assertDatabaseHas(
            'suggestions',
            [
                'field' => 'authorisedBrands',
                'value' => 'Outlandish'
            ]
        );
        $this->assertDatabaseHas(
            'suggestions',
            [
                'field' => 'authorisedBrands',
                'value' => 'Unit4'
            ]
        );
    }

}
