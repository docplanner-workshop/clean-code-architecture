<?php
declare(strict_types=1);

namespace App\Tests;

final class DoctorSlotsUseCaseTest extends E2ETestCase
{
    private CONST EXPECTED_CREATE_RESPONSE = '{"id":1}';
    private CONST EXPECTED_GET_RESPONSE = '{"id":1,"firstName":"John","lastName":"Doe","specialization":"fish"}';
    private CONST EXPECTED_GET_SLOTS_RESPONSE = '[{"id":1,"day":"2025-11-11","from_hour":"10.00","duration":15}]';

    public function test(): void
    {
        $this->get_doctor_when_not_exist();
        $this->create_new_doctor();
        $this->get_doctor_when_exist();

        $this->get_doctor_slots_when_no_slots();
        $this->create_doctor_slot();
        $this->get_doctor_slots();
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

    private function get_doctor_slots_when_no_slots(): void
    {
        $this->requestDoctor1Slots();

        $response = $this->client->getResponse();
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('[]', $response->getContent());
    }

    private function get_doctor_slots(): void
    {
        $this->requestDoctor1Slots();

        $response = $this->client->getResponse();
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals(self::EXPECTED_GET_SLOTS_RESPONSE, $response->getContent());
    }

    private function create_doctor_slot(): void
    {
        $uri = '/slots/1';
        $body = [
            'day' => '2025-11-11',
            'duration' => '15',
            'from_hour' => '10.00',
        ];

        $this->postRequest($uri, $body);

        $response = $this->client->getResponse();
        $this->assertEquals('200', $response->getStatusCode());
    }


    private function requestDoctorId1(): void
    {
        $this->client->request('GET', '/doctor?id=1');
    }

    private function requestDoctor1Slots(): void
    {
        $this->client->request('GET', '/slots/1');
    }
}
