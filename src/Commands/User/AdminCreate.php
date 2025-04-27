<?php

namespace Siarko\Admin\Commands\User;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Siarko\Admin\Model\Management\AdminUser\Management\Proxy as Management;

class AdminCreate extends Command
{

    private const OPTION_USERNAME = 'username';
    private const OPTION_PASSWORD = 'password';
    private const OPTION_EMAIL = 'email';

    /**
     * @param Management $management
     */
    public function __construct(
        private readonly Management $management
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('user:admin:create')
            ->setDescription("Create new admin user")
            ->addOption(self::OPTION_USERNAME, 'u', InputOption::VALUE_REQUIRED, 'Username')
            ->addOption(self::OPTION_PASSWORD, 'p', InputOption::VALUE_REQUIRED, 'Password')
            ->addOption(self::OPTION_EMAIL, 'e', InputOption::VALUE_REQUIRED, 'Email');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userData = $this->getUserData($input, $output);
        $this->management->create(
            $userData[self::OPTION_USERNAME],
            $userData[self::OPTION_EMAIL],
            $userData[self::OPTION_PASSWORD]
        );
        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     */
    private function getUserData(InputInterface $input, OutputInterface $output): array
    {
        if(($username = $input->getOption(self::OPTION_USERNAME)) === null){
            $username = $this->ask(self::OPTION_USERNAME, $input, $output);
        }
        if(($password = $input->getOption(self::OPTION_PASSWORD)) === null){
            $password = $this->ask(self::OPTION_PASSWORD, $input, $output);
        }
        if(($email = $input->getOption(self::OPTION_EMAIL)) === null){
            $email = $this->ask(self::OPTION_EMAIL, $input, $output);
        }
        return [
            self::OPTION_USERNAME => $username,
            self::OPTION_PASSWORD => $password,
            self::OPTION_EMAIL => $email
        ];
    }

    /**
     * @param string $fieldName
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    private function ask(string $fieldName, InputInterface $input, OutputInterface $output): string
    {
        $helper = $this->getHelper('question');
        $question = new Question("Enter $fieldName: ");
        return $helper->ask($input, $output, $question);
    }
}