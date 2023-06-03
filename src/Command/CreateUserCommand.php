<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create a user...')
            // configure an argument
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
        ;
    }

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Creates a new user';

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // outputs a message without adding a "\n" at the end of the line
        $output->writeln('You are about to create a user');

        // retrieve the argument value using getArgument()
        $output->writeln('Username: '.$input->getArgument('username'));

        $user = new User();
        $username = $input->getArgument('username');
        $plaintextPassword = $username;
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setUsername($username)->setPassword($hashedPassword)->setEmail('test@test.com')->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    protected function someMethod(): bool
    {
        return true;
    }
}