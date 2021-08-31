<?php

namespace Bazar\Console\Commands;

use Bazar\BazarServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Publish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bazar:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the Bazar assets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return $this->call('vendor:publish', array_merge(
            ['--provider' => BazarServiceProvider::class],
            $this->option('force') ? ['--force' => true] : [],
            ['--tag' => $this->option('tag') ?: ['bazar-assets', 'bazar-config']]
        ));
    }
}
