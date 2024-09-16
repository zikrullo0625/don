<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'News parsing and logging';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Задача parse:news выполнена успешно.');
        $this->info('Задача parse:news выполнена и запись добавлена в лог.');
    }
}
