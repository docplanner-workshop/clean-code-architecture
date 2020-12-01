<?php
declare(strict_types=1);

namespace App\Tests;

use App\Model\Doctor;
use App\Model\Slot;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class E2ETestCase extends WebTestCase
{
    protected array $entitiesToTruncate = [
        Doctor::class,
        Slot::class
    ];

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = $this->createClient();
        $this->truncateEntities(
            $this->entitiesToTruncate
        );
    }

    protected function postRequest(string $uri, array $body): void
    {
        $this->client->request(
            'POST',
            $uri,
            $body,
            [],
            ['CONTENT_TYPE' => 'application/x-www-form-urlencoded'],
        );

    }

    protected function serviceFromContainer(string $serviceId)
    {
        return static::$kernel->getContainer()->get($serviceId);
    }

    private function truncateEntities(array $entities)
    {
        $connection = $this->entityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->entityManager()->getClassMetadata($entity)->getTableName()
            );
            $connection->executeStatement($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');
        }
    }
    private function entityManager(): EntityManager
    {
        return $this->serviceFromContainer('doctrine')->getManager();
    }
}
