<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

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
        $this->info('Starting data import...');

        $this->call('db:seed', ['--class' => 'LanguageSeeder']);
        $this->call('db:seed', ['--class' => 'MenuSeeder']);

        $this->info('Data import completed successfully!');
    }
}
