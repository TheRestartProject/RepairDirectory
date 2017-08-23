<?php

namespace TheRestartProject\RepairDirectory\Testing;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Connectors\ConnectionFactory;
use LaravelDoctrine\ORM\Configuration\Connections\Connection;
use LaravelDoctrine\ORM\Configuration\Connections\ConnectionManager;
use League\Flysystem\File;

/**
 * A helpful trait that performs database migrations after every test
 *
 * @category Trait
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
trait FixometerDatabaseMigrations
{

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runFixometerDatabaseMigrations()
    {
        /**
         * @var ConnectionFactory $factory
         */
        $factory = $this->app->make(ConnectionFactory::class);

        $factory->

        $this->beforeApplicationDestroyed(
            function () use ($manager) {
                $statement = $manager->getConnection()->query('drop table IF EXISTS sessions; drop table IF EXISTS users;');
                $statement->execute();
            }
        );
    }

    protected function getQuery()
    {
        return "drop table IF EXISTS sessions;
            drop table IF EXISTS users;
            
            create table sessions
            (
              idsessions int auto_increment
                primary key,
              session varchar(255) not null,
              user int not null,
              created_at timestamp null,
              modified_at timestamp default CURRENT_TIMESTAMP not null,
              constraint session_UNIQUE
              unique (session)
            )
            ;
            
            create index idxSessionsUsers
              on sessions (user)
            ;
            
            create table users
            (
              idusers int auto_increment
                primary key,
              email varchar(255) not null,
              password varchar(60) not null,
              name varchar(255) not null,
              role int default '3' not null,
              recovery varchar(45) null,
              recovery_expires timestamp null,
              created_at timestamp null,
              modified_at timestamp default CURRENT_TIMESTAMP not null,
              constraint email_UNIQUE
              unique (email)
            )
            ;
          ";
    }
}