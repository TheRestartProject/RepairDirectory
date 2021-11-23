<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Middleware;

use LaravelDoctrine\ORM\IlluminateRegistry;
use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;
use Throwable;

/**
 * Provides multi-connection support doctrine orm
 *
 * This middleware sits in the CommandBus and ensures that every command takes place
 * within its own transaction.
 *
 * @category Middleware
 * @package  TheRestartProject\RepairDirectory\Application\CommandBus\Middleware
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class TransactionMiddleware implements Middleware
{
    /**
     * The manager registry from the Doctrine ORM
     *
     * @var IlluminateRegistry
     */
    private $IlluminateRegistry;

    /**
     * Constructs the middleware
     *
     * @param IlluminateRegistry $IlluminateRegistry Used to run the transactions
     */
    public function __construct(IlluminateRegistry $IlluminateRegistry)
    {
        $this->IlluminateRegistry = $IlluminateRegistry;
    }

    /**
     * Executes the given command and optionally returns a value
     *
     * @param mixed    $command The the command to be handled
     * @param callable $next    The next callback
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
            $this->IlluminateRegistry->getDefaultManagerName();

        /**
         * The entity manager for a given connection name
         *
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = $this->IlluminateRegistry->getManager($connectionName);

        $entityManager->beginTransaction();

        try {
            $returnValue = $next($command);

            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $e) {
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
     * @param EntityManagerInterface $entityManager The entity manager that will rollback the transaction
     *
     * @return void
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
