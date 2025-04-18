<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }


        Storage::deleteDirectory('public/images/products');
        Storage::deleteDirectory('public/images/brands');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        $this->call('cache:clear');

        return self::SUCCESS;
    }
}
