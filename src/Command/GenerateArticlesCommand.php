<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ArticleGenerator;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
// php bin/console app:generate-articles
#[AsCommand(
    name: 'app:generate-articles',
    description: 'Generate articles from RSS',
    hidden: false,
    aliases: ['app:generate-articles']
)]
class GenerateArticlesCommand extends Command
{
    private ArticleGenerator $articleGenerator;

    public function __construct(ArticleGenerator $articleGenerator)
    {
        $this->articleGenerator = $articleGenerator;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->articleGenerator->generateArticleFromRss();

        $output->writeln('Articles generated');

        return Command::SUCCESS;
    }
}
