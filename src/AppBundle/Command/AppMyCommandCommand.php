<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppMyCommandCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:my-command')
            ->setDescription('...')
            ->addArgument('argumento1', InputArgument::REQUIRED, 'Descripción del argumento 1')
            ->addArgument('argumento2', InputArgument::OPTIONAL, 'Descripción del argumento 2')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Descripción de la opción')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Salida multilínea (introduce un \n al final de cada línea)
        $output->writeln([
            'Mi comando personalizado',
            '========================',
            '',
        ]);

        // Salida de una línea seguida de "\n"
        $output->writeln('¡Genial!');

        // Salida SIN introducir \n
        $output->write('Estás ejecutando ');
        $output->write('un comando personalizado.');
        $output->writeln('');
        
        $argumento1 = $input->getArgument('argumento1');
        
        $output->writeln('El argumento 1 es: '.$argumento1);
        
        $opcion = $input->getOption('option');
        
        $output->writeln('El valor de --option es: '.$opcion);
    }

}
