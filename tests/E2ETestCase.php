<?php
declare(strict_types=1);

namespace App\Tests;

use App\Controller\DoctorEntity;
use App\Controller\SlotEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class E2ETestCase extends WebTestCase
{

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = $this->createClient();
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

}
