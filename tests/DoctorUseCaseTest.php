<?php
declare(strict_types=1);

namespace App\Tests;

final class DoctorUseCaseTest extends E2ETestCase
{
    private CONST EXPECTED_CREATE_RESPONSE = '{"id":1}';
    private CONST EXPECTED_GET_RESPONSE = '{"id":1,"firstName":"John","lastName":"Doe","specialization":"fish"}';

    public function test(): void
    {
        $this->get_doctor_when_not_exist();
        $this->create_new_doctor();
        $this->get_doctor_when_exist();
    }

    private function get_doctor_when_not_exist(): void
    {
        $this->requestDoctorId1();

        $this->assertEquals('404', $this->client->getResponse()->getStatusCode());
    }

    private function get_doctor_when_exist(): void
    {
        $this->requestDoctorId1();

        $response = $this->client->getResponse();

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals(self::EXPECTED_GET_RESPONSE, $response->getContent());
    }

    private function create_new_doctor(): void
    {
        $uri = '/doctor';
        $body = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'specialization' => 'fish'
        ];

        $this->postRequest($uri, $body);

        $response = $this->client->getResponse();

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals(self::EXPECTED_CREATE_RESPONSE, $response->getContent());
    }

    private function requestDoctorId1(): void
    {
        $this->client->request('GET', '/doctor?id=1');
    }
}
