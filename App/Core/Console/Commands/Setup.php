<?php

namespace App\Core\Console\Commands;

use App\Core\Console\Command;
use App\Core\Console\Contracts\PromptableValue;
use App\Core\Console\FluentCommandBuilder;
use App\Core\Console\FluentOptionalParamBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Setup extends Command
{
    protected function setup(FluentCommandBuilder $builder): FluentCommandBuilder
    {
        return $builder->setName("setup")
            ->setDesc("Setting up your cli project's environment in matter of seconds.")
            ->addOptionalParam(fn (FluentOptionalParamBuilder $opb) => $opb->setName('ignore')
                ->setDesc('Ignore env file checking')
                ->setInputTypeNone()
                ->setShortcut('ig'));
    }

    public function handler(InputInterface $inputInterface, OutputInterface $outputInterface): int
    {
        if (file_exists(base_path(".env")) && !$inputInterface->getOption('ignore')) {
            $this->error(".env File already exist. Aborting.");
            return Command::FAILURE;
        }

        $lookForCli = env("APP_NAME", "scli");

        $wantSetup = $this->prompt("Would you like to setting up SCli PHP? ");

        if (!($wantSetup instanceof PromptableValue)) {
            return Command::FAILURE;
        }

        if ($wantSetup === PromptableValue::NO) {
            $this->info("Aborting...");
            return Command::INVALID;
        }

        $appName = $this->ask("What is your app name?", ["scli"], "scli");
        $appVer = $this->ask("What is your current app version", ["1.0-dev"], "1.0-dev");

        $data = <<<data
        APP_NAME=$appName
        APP_VERSION=$appVer
        data;

        file_put_contents(base_path('.env'), $data);

        rename(base_path($lookForCli), base_path(strtolower(trim($appName))));

        $this->success(".env Generated.");

        return Command::SUCCESS;
    }
}
