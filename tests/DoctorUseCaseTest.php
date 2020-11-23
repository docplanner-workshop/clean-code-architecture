<?php
declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DoctorUseCaseTest extends WebTestCase
{
    public function test() {
        $client = static::createClient();

        $client->request('GET', '/doctor?id=999');

        $this->assertEquals('404', $client->getResponse()->getStatusCode());
    }
}
