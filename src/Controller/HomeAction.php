<?php

declare(strict_types=1);

namespace App\Controller;

use App\Render\QuoteHtml;
use App\Repository\QuoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'home')]
final readonly class HomeAction
{
    public function __construct(private QuoteRepository $quoteRepository) {}

    public function __invoke(Request $request): Response
    {
        $session = $request->getSession();

        /** @var list<\App\Entity\Quote> $quotes */
        $quotes = $session->get('quotes') ?? $this->quoteRepository->getInRandomOrder();
        if ([] === $quotes) {
            return new Response(QuoteHtml::empty());
        }

        $quote = array_shift($quotes);

        [] === $quotes
            ? $session->remove('quotes')
            : $session->set('quotes', $quotes);

        return new Response(QuoteHtml::render($quote));
    }
}