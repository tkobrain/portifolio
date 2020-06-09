<?php

namespace App\Tests;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SprintsWebTest extends WebTestCase
{
    public function testGaranteQueRequisicaoFalhaSemAutenticacao()
    {
        $client = static::createClient();
        $client->request('GET', '/sprints');

        self::assertEquals(
            401,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGaranteQueSprintsSaoListadas()
    {
        $client = static::createClient();
        $token = $this->login($client);
        $client->request('GET', '/sprints', [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ]);

        $resposta = json_decode($client->getResponse()->getContent());
        self::assertTrue($resposta->success);
    }

    public function testInsereSprints()
    {
        $client = static::createClient();
        $token = $this->login($client);
        $client->request('POST', '/sprint', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ], json_encode([
            'Id' => "29-2020",
            'DataInicioSprint' => "20200608 00:00:00",
            'DataFimSprint' => "20200612 23:59:59",	
            'DataImportacao' => null            
        ]));

        self::assertEquals(201, $client->getResponse()->getStatusCode());
    }

    private function login(KernelBrowser $client): string
    {
        $client->request(
            'POST',
            '/login',
            [],
            [],
            [
            'CONTENT_TYPE' => 'application/json'
            ],
            json_encode([
                'username' => 'anderson@alphatorres.com.br',
                'password' => 'ptPa55@S0usa'
            ])
        );

        return json_decode($client->getResponse()->getContent())
            ->access_token;
    }

    public function testHtmlSprints()
    {
        $client = self::createClient();
        $client->request('GET', '/sprints_html');

        $this->assertSelectorTextContains('h1', 'Sprints');
        $this->assertSelectorExists('.sprint');
    }    
}
