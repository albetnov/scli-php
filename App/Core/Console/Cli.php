<?php

namespace App\Core\Console;

use App\Core\Containers\Container;
use Symfony\Component\Console\Application;

class Cli
{
    private Application $app;

    public function __construct()
    {
        $this->app = new Application(env("APP_NAME"), env("APP_VERSION"));
    }

    private function internalLoader(): array
    {
        return array_filter(array_diff_key(scandir(__DIR__ . "/Commands/"), ['.', '..']), fn ($item): bool => str_ends_with($item, ".php"));
    }

    private function userLoader(): array
    {
        return array_filter(array_diff_key(scandir(__DIR__ . "/../../Commands/"), ['.', '..']), fn ($item): bool => str_ends_with($item, ".php"));
    }

    public function register(): self
    {
        $internalLoader = array_map(fn ($item): string => 'App\\Core\\Console\\Commands\\' . explode('.', $item)[0], $this->internalLoader());
        // Register the internal cores command
        foreach ($internalLoader as $internalCommand) {
            $this->app->add(Container::fulfill($internalCommand)->parse());
        }

        $userLoader = array_map(fn ($item): string => 'App\\Commands\\' . explode('.', $item)[0], $this->userLoader());
        // Register user defined command
        foreach ($userLoader as $userCommand) {
            $this->app->add(Container::fulfill($userCommand)->parse());
        }

        return $this;
    }

    public function load(): int
    {
        return $this->app->run();
    }
}
