<?php
declare(strict_types=1);

namespace App\Tests;

final class DoctorSlotsUseCaseTest extends E2ETestCase
{

    public function test(): void
    {
        $this->index();
    }

    private function index(): void
    {
        $expectedContent = '"ReallyDirty API v1.0"';
        $this->client->request('GET', '/');

        $response = $this->client->getResponse();
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals($expectedContent, $response->getContent());
    }

}
