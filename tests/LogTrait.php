<?php

namespace App\Tests;

trait LogTrait
{
    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $this->client->submit($form, ['_username' => 'User1', '_password' => 'test']);
    }

    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $this->client->submit($form, ['_username' => 'Admin', '_password' => 'root']);
    }
}