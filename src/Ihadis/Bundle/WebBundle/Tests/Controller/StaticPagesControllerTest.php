<?php

namespace Ihadis\Bundle\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaticPagesControllerTest extends WebTestCase
{
    public function testAboutus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/aboutUs');
    }

    public function testDisclaimer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disclaimer');
    }

    public function testJointeam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/joinTeam');
    }

    public function testFeedback()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/feedback');
    }

}
