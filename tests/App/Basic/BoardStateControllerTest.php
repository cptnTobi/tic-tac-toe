<?php

namespace App\Tests\Basic;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardStateControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrlsSuccess($method, $url, $expected, $note): void
    {
        $client = static::createClient();
        $client->request($method, $url);

        $this->assertResponseStatusCodeSame($expected);
    }

    public function urlProvider(): array
    {
        return [
            ['GET', '/', 200, 'Start page'],
            ['GET', '/api/v1/possible-moves', 200, 'Possible moves'],
            ['GET', '/api/v1/board/1/state', 503, 'Board state'],
            ['GET', '/api/v1/game/1/status', 503, 'Board status'],
        ];
    }
}
