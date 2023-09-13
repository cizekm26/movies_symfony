<?php

namespace App\Command;

use App\Repository\MyListRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:talk-to-me',
    description: 'Short description for a command',
)]
class TalkToMeCommand extends Command
{
    public function __construct(
        private MyListRepository $moviesRepository
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Your name')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'Shell I yell?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name') ?: 'whoever you are';
        $shouldYell = $input->getOption('yell');
        $message = sprintf('Hey %s!', $name);
        if ($shouldYell) {
            $message = strtoupper($message);
        }

        $io->success($message);
        if($io->confirm("Do you want a recommendation?")){
            $movies = $this->moviesRepository->findAll();
            $movies = $movies[array_rand($movies)];
            $io->note('I recommend the mix: ' . $movies['title']);
        }
        return Command::SUCCESS;
    }
}
