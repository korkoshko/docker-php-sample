<?php

declare(strict_types=1);

namespace App\Render;

use App\Entity\Quote;

final class QuoteHtml
{
    public static function render(Quote $quote): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Docker Sample</title>
                <style>
                    body {
                        font-family: 'Georgia', serif;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        background: linear-gradient(135deg, #74ebd5, #ACB6E5);
                        color: #333;
                    }
            
                    .quote-container {
                        width: 400px;
                        height: 250px;
                        background: white;
                        border-radius: 10px;
                        padding: 20px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }
            
                    .quote-text {
                        font-size: 1.4rem;
                        font-style: italic;
                        margin-bottom: 10px;
                    }
            
                    .quote-author {
                        font-size: 1.1rem;
                        font-weight: bold;
                        color: #555;
                    }
            
                    .button-primary {
                        padding: 10px 20px;
                        background-color: #4CAF50;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        font-size: 1rem;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                        align-self: center;
                    }
            
                    .button-primary:hover {
                        background-color: #45a049;
                    }
                </style>
            </head>
            <body>
                <div class="quote-container">
                    <div>
                        <p class="quote-text">"$quote->quote"</p>
                        <p class="quote-author">- $quote->author</p>
                    </div>
                    <button class="button-primary"" onclick="location.reload()">Next</button>
                </div>
            </body>
            </html>
            HTML;
    }

    public static function empty(): string
    {
        return self::render(new Quote('No quotes', ':C'));
    }
}