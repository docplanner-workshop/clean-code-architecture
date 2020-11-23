<?php
declare(strict_types=1);

namespace App\Tests;

final class DoctorUseCaseTest extends E2ETestCase
{
    public function test() {
        $this->client->request('GET', '/doctor?id=999');

        $this->assertEquals('404', $this->client->getResponse()->getStatusCode());
    }
}
