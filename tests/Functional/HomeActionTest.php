<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Quote;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\Persistence\proxy_factory;
use function Zenstruck\Foundry\Persistence\repository;

class HomeActionTest extends WebTestCase
{
    use Factories;

    public function testDisplaysQuote(): void
    {
        $client = static::createClient();

        proxy_factory(Quote::class)->create([
            'quote' => $quote = 'Роль кібербезпеки трохи перебільшена',
            'author' => $author = 'Михайло Федоров, Міністр цифрової трансформації України',
        ]);

        self::assertSame(1, repository(Quote::class)->count());

        $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('p.quote-text', $quote);
        self::assertSelectorTextContains('p.quote-author', $author);
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
