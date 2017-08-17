<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Listeners;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;

/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 17/08/2017
 * Time: 17:30
 */
class AddSuggestionsListener
{

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Business) {
            $this->handle($entity, $args->getEntityManager());
        }
    }

    /**
     * See https://stackoverflow.com/questions/30734814/persisting-other-entities-inside-preupdate-of-doctrine-entity-listener
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $unitOFWork = $em->getUnitOfWork();
        foreach ($unitOFWork->getScheduledEntityUpdates() as $keyEntity => $entity) {
            if ($entity instanceof Business) {
                $suggestions = $this->handle($entity, $args->getEntityManager());
                $classMetadata = $em->getClassMetadata(Suggestion::class);
                foreach ($suggestions as $suggestion) {
                    $unitOFWork->computeChangeSet($classMetadata, $suggestion);
                }
            }
        }
    }

    /**
     * @param Business $business
     * @param $entityManager
     *
     * @return Suggestion[]
     */
    private function handle(Business $business, $entityManager)
    {
        $newSuggestions = [];
        foreach ($business->getProductsRepaired() as $productRepaired) {
            $suggestion = new Suggestion();
            $suggestion->setField('productsRepaired');
            $suggestion->setValue($productRepaired);
            $this->addSuggestion($suggestion, $newSuggestions, $entityManager);
        }

        foreach ($business->getAuthorisedBrands() as $authorisedBrand) {
            $suggestion = new Suggestion();
            $suggestion->setField('authorisedBrands');
            $suggestion->setValue($authorisedBrand);
            $this->addSuggestion($suggestion, $newSuggestions, $entityManager);
        }
        return $newSuggestions;
    }

    /**
     * @param Suggestion    $suggestion
     * @param Suggestion[]  $newSuggestions
     * @param ObjectManager $entityManager
     */
    private function addSuggestion($suggestion, &$newSuggestions, $entityManager)
    {
        $repository = $entityManager->getRepository(Suggestion::class);
        $existing = $repository->findBy([ 'field' => $suggestion->getField(), 'value' => $suggestion->getValue() ]);
        if (empty($existing)) {
            $entityManager->persist($suggestion);
            $newSuggestions[] = $suggestion;
        }
    }

}