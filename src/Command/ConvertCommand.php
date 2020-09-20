<?php

namespace App\Command;

use App\Service\FileConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ConvertCommand extends Command
{
    protected static $defaultName = 'trivago:convert';

    private $fileConverter;

    function __construct(FileConverter $fileConverter) {
        $this->fileConverter = $fileConverter;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('filename', InputArgument::REQUIRED, 'Filename to convert.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->fileConverter->convert($input->getArgument('filename'));
        $output->writeln($response ? "File converted successfully: $response" : "Unknown error occured");
        return Command::SUCCESS;
    }
}
