<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Listeners;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;

/**
 * AddSuggestionsListener Class
 *
 * Creates suggestions from the productsRepaired and authorisedBrands fields of a Business,
 * whenever it is created or updated.
 *
 * @category Doctrine\Listener
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Infrastructure\Doctrine\Listeners
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class AddSuggestionsListener
{

    /**
     * Hook on to the prePersist Doctrine event, creating new
     * suggestions when new Businesses are created.
     *
     * @param LifecycleEventArgs $args Arguments from Doctrine
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Business) {
            $this->createSuggestionsFromBusiness($entity, $args->getEntityManager());
        }
    }

    /**
     * Hook on to the onFlush Doctrine event in order to create new suggestions
     * when a Business has changed. More complex than prePersist, as the
     * creation of a new suggestion needs to be added to the current
     * "unit of work".
     *
     * See https://stackoverflow.com/questions/30734814/persisting-other-entities-inside-preupdate-of-doctrine-entity-listener
     *
     * @param OnFlushEventArgs $args Arguments from Doctrine
     *
     * @return void
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $unitOFWork = $entityManager->getUnitOfWork();
        foreach ($unitOFWork->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Business) {
                $suggestions = $this->createSuggestionsFromBusiness($entity, $args->getEntityManager());
                $classMetadata = $entityManager->getClassMetadata(Suggestion::class);
                foreach ($suggestions as $suggestion) {
                    $unitOFWork->computeChangeSet($classMetadata, $suggestion);
                }
            }
        }
    }

    /**
     * Create Suggestions from a Business instance.
     * Currently creates Suggestions for the productsRepaired and authorisedBrands fields.
     *
     * @param Business      $business      The Business to create Suggestions from
     * @param EntityManager $entityManager The Doctrine Entity Manager
     *
     * @return Suggestion[]
     */
    private function createSuggestionsFromBusiness(Business $business, EntityManager $entityManager)
    {
        $newSuggestions = [];
        foreach ($business->getProductsRepaired() as $productRepaired) {
            $suggestion = new Suggestion();
            $suggestion->setField('productsRepaired');
            $suggestion->setValue($productRepaired);
            $this->addSuggestion($suggestion, $entityManager, $newSuggestions);
        }

        foreach ($business->getAuthorisedBrands() as $authorisedBrand) {
            $suggestion = new Suggestion();
            $suggestion->setField('authorisedBrands');
            $suggestion->setValue($authorisedBrand);
            $this->addSuggestion($suggestion, $entityManager, $newSuggestions);
        }
        return $newSuggestions;
    }

    /**
     * Add a Suggestion to the Suggestion repository, but only when it doesn't already exist.
     * If the suggestion is added to the repository, it is also added to
     * the $newSuggestions array that is passed in by reference
     *
     * @param Suggestion    $suggestion     The suggestion to
     * @param EntityManager $entityManager  The Doctrine Entity Manager
     * @param Suggestion[]  $newSuggestions The array to add newly persisted suggestions to
     *
     * @return void
     */
    private function addSuggestion($suggestion, $entityManager, &$newSuggestions)
    {
        $repository = $entityManager->getRepository(Suggestion::class);
        $existing = $repository->findBy([ 'field' => $suggestion->getField(), 'value' => $suggestion->getValue() ]);
        if (empty($existing)) {
            $entityManager->persist($suggestion);
            $newSuggestions[] = $suggestion;
        }
    }

}