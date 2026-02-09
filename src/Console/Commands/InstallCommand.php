<?php

namespace KishorRajbanshi\LaravelAuth\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install of the Laravel Auth resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // delete default auth.php config and publish from the package
        // 
    }
}
