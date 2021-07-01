<?php

namespace App\Tests;

trait LogTrait
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    private function loginUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $this->client->submit($form, ['_username' => 'admin', '_password' => 'root']);
    }
}
