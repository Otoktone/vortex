<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\FeedArticle;
use App\Repository\FeedArticleRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
// php bin/console app:clean-articles
#[AsCommand(
    name: 'app:clean-articles',
    description: 'Clean old articles',
    hidden: false,
    aliases: ['app:remove-articles']
)]
class CleanArticles extends Command
{
    private EntityManagerInterface $entityManager;
    private FeedArticleRepository $feedArticleRepository;

    public function __construct(EntityManagerInterface $entityManager, FeedArticleRepository $feedArticleRepository)
    {
        $this->entityManager = $entityManager;
        $this->feedArticleRepository = $feedArticleRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to clean old articles...')
            // configure an argument
            // ->addArgument('period', InputArgument::REQUIRED, 'Clean articles older than period ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Clean old articles from DB',
            '============',
            '',
        ]);

        // outputs a message without adding a "\n" at the end of the line
        $output->writeln('You are about to clean old articles from database');

        // retrieve the argument value using getArgument()
        // $period = $input->getArgument('period');

        $threeMonthsAgo = new \DateTime('-3 months');
        $date = $threeMonthsAgo->format('Y-m-d');

        // $articles = $this->feedArticleRepository->findAllArticleWithoutUserByDateSQL($date);

        $articles = $this->feedArticleRepository->findAllArticleWithoutUserByDateDQL($date);

        // check article date of creation
        $removedArticles = 0;
        foreach ($articles as $article) {
            $this->feedArticleRepository->remove($article, true);
            $removedArticles++;
        }

        $this->entityManager->flush();

        $output->writeln('You have removed ' . $removedArticles . 'articles');

        return Command::SUCCESS;
    }
}
