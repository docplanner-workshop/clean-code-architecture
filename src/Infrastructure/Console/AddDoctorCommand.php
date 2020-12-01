<?php
declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Action\AddDoctor;
use App\Action\Input\AddDoctorDTO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddDoctorCommand extends Command
{
    private const ARG_FIRST_NAME = 'firstName';
    private const ARG_LAST_NAME = 'lastName';
    private const ARG_SPECIALIZATION = 'specialization';

    protected static $defaultName = 'doctor:create';

    private AddDoctor $addDoctor;

    public function __construct(AddDoctor $addDoctor)
    {
        parent::__construct();
        $this->addDoctor = $addDoctor;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates new doctor')
            ->addArgument(self::ARG_FIRST_NAME, InputArgument::REQUIRED, 'Doctor first name')
            ->addArgument(self::ARG_LAST_NAME, InputArgument::REQUIRED, 'Doctor last name')
            ->addArgument(self::ARG_SPECIALIZATION, InputArgument::REQUIRED, 'Doctor specialization');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dto = new AddDoctorDTO(
            $input->getArgument(self::ARG_FIRST_NAME),
            $input->getArgument(self::ARG_LAST_NAME),
            $input->getArgument(self::ARG_SPECIALIZATION)
        );

        $response = $this->addDoctor->__invoke($dto);

        $output->writeln(sprintf('Doctor has been successfully created. His id is %s', $response->getId()));

        return Command::SUCCESS;
    }
}
