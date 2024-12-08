<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function Zenstruck\Foundry\Persistence\proxy_factory;
use function Zenstruck\Foundry\Persistence\repository;

class HomeActionTest extends WebTestCase
{
    public function testDisplaysQuote(): void
    {
        $client = static::createClient();

        proxy_factory(Quote::class)->create([
            'quote' => 'Cyber-security is not an IT issue; it\'s a people issue.',
            'author' => 'CyberSecurity Expert'
        ]);

        self::assertSame(1, repository(Quote::class)->count());

        $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('p.quote-text', '"Cyber-security is not an IT issue; it\'s a people issue."');
        self::assertSelectorTextContains('p.quote-author', 'CyberSecurity Expert');
    }

    public function testDisplaysFallbackMessageWhenNoQuotesExists(): void
    {
        $client = static::createClient();

        self::assertSame(0, repository(Quote::class)->count());

        $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('p.quote-text', 'No quotes');
        self::assertSelectorTextContains('p.quote-author', ':C');
    }
}