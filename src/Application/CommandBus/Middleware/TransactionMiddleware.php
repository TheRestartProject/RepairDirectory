<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Middleware;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;
use Throwable;


/**
 * Wraps command execution inside a Doctrine ORM transaction
 */
class TransactionMiddleware implements Middleware
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Executes the given command and optionally returns a value
     *
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     *
     * @throws Throwable
     * @throws \Exception
     */
    public function execute($command, callable $next)
    {
        $connectionName = method_exists($command, 'getConnectionName') ?
            $command->getConnectionName() :
            $this->managerRegistry->getDefaultManagerName();

        $entityManager = $this->managerRegistry->getManager($connectionName);

        $entityManager->beginTransaction();

        try {
            $returnValue = $next($command);

            $entityManager->flush();
            $entityManager->commit();
        } catch (Exception $e) {
            $this->rollbackTransaction($entityManager);

            throw $e;
        } catch (Throwable $e) {
            $this->rollbackTransaction($entityManager);

            throw $e;
        }

        return $returnValue;
    }

    /**
     * Rollback the current transaction and close the entity manager when possible.
     *
     * @param EntityManagerInterface $entityManager
     */
    protected function rollbackTransaction(EntityManagerInterface $entityManager)
    {
        $entityManager->rollback();

        $connection = $entityManager->getConnection();
        if (!$connection->isTransactionActive() || $connection->isRollbackOnly()) {
            $entityManager->close();
        }
    }
}
