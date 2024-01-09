<?php

namespace App\Command;

use App\Consumer\OmdbApiConsumer;
use App\Enum\SearchTypeEnum;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fetch-movie',
    description: 'Add a short description for your command',
)]
class FetchMovieCommand extends Command
{
    public function __construct(
        private OmdbApiConsumer $consumer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('identifier', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $identifier = $input->getArgument('identifier');

        if ($identifier) {
            $title = implode(' ', $identifier);

            $output->writeln("====== Fetching movie ======");
            $response = $this->consumer->fetch(SearchTypeEnum::Title, $title);

            $io->writeln('----------------------------------------------');
            $io->writeln('Title  : ' . $response['Title']);
            $io->writeln('Year   : ' . $response['Year']);
            $io->writeln('Rating : ' . $response['Rated']);
            $io->writeln('----------------------------------------------');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
