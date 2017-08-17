<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Listeners;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;

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
        $this->handle($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->handle($args);
    }

    private function handle(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $suggestionRepository = $entityManager->getRepository(Suggestion::class);

        if ($entity instanceof Business) {
            $suggestions = $suggestionRepository->findAll();

            foreach ($entity->getProductsRepaired() as $productRepaired) {
                $suggestion = new Suggestion();
                $suggestion->setField('productsRepaired');
                $suggestion->setValue($productRepaired);
                $this->addSuggestion($suggestion, $suggestions, $entityManager);
            }

            foreach ($entity->getAuthorisedBrands() as $authorisedBrand) {
                $suggestion = new Suggestion();
                $suggestion->setField('authorisedBrands');
                $suggestion->setValue($authorisedBrand);
                $this->addSuggestion($suggestion, $suggestions, $entityManager);
            }
        }
    }

    /**
     * @param Suggestion    $suggestion
     * @param Suggestion[]  $existingSuggestions
     * @param ObjectManager $entityManager
     */
    private function addSuggestion($suggestion, $existingSuggestions, $entityManager)
    {
        $found = array_filter($existingSuggestions, function (Suggestion $existingSuggestion) use ($suggestion) {
            return $existingSuggestion->getField() === $suggestion->getField() &&
            strtolower($existingSuggestion->getValue()) === strtolower($suggestion->getValue());
        });
        if (empty($found)) {
            $entityManager->persist($suggestion);
        }
    }

}