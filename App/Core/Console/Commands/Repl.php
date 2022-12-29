<?php

namespace App\Core\Console\Commands;

use App\Core\Console\Command;
use App\Core\Console\ExecDisabledException;
use App\Core\Console\FluentCommandBuilder;
use Psy\Configuration;
use Psy\Shell;

class Repl extends Command
{
    protected function setup(FluentCommandBuilder $builder): FluentCommandBuilder
    {
        return $builder
            ->setName('repl')
            ->setDesc('Enable the ASMVC REPL.');
    }

    public function handler($input, $output): int
    {
        if (!function_exists('exec')) {
            throw new ExecDisabledException();
        }

        $this->badgeInfo("Starting Repl...");
        $config = new Configuration;
        $config->loadConfigFile(__DIR__ . "/../repl.php");
        (new Shell($config))->run();

        return Command::SUCCESS;
    }
}
