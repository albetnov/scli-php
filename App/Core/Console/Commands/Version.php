<?php

namespace App\Core\Console\Commands;

use App\Core\Console\Contracts\BadgeColor;
use App\Core\Console\Command;
use App\Core\Console\FluentCommandBuilder;

class Version extends Command
{
    protected function setup(FluentCommandBuilder $builder): FluentCommandBuilder
    {
        return $builder
            ->setName('version')
            ->setAliases('ver')
            ->setDesc('Show framework version');
    }

    public function handler($input, $output): int
    {
        $ver = env("APP_VERSION");
        $name = env("APP_NAME");
        $this->info("$name Version $ver");
        return Command::SUCCESS;
    }
}
