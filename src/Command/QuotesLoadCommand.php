<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:quotes:load',
    description: 'Load quotes from json file',
)]
class QuotesLoadCommand extends Command
{
    public function __construct(
        #[Autowire('%kernel.project_dir%' . DIRECTORY_SEPARATOR . 'quotes.json')]
        private readonly string $filePath,
        private readonly Connection $connection,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! file_exists($this->filePath)) {
            $output->writeln(\sprintf('<error>File "%s" not found!</error>', $this->filePath));

            return Command::FAILURE;
        }

        /** @var list<object{quote: string, author: string}> $quotes */
        $quotes = json_decode(\file_get_contents($this->filePath), flags: JSON_THROW_ON_ERROR);

        $progressBar = new ProgressBar($output, count($quotes));
        $progressBar->start();

        foreach ($quotes as $idx => $quote) {
            $this->connection
                ->executeStatement(
                    'insert into quotes (id, quote, author) values (:id, :quote, :author) on conflict(id) do nothing',
                    [
                        'id' => $idx + 1,
                        'quote' => $quote->quote,
                        'author' => $quote->author,
                    ],
                );

            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
