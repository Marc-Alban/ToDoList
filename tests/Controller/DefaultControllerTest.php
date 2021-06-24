<?php

namespace App\Tests\Controller;

use App\Tests\logTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    use logTrait;

    public function testIndexAction(): void
    {
        $this->loginUser();

        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
