<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table= 'doctors';
        DB::table($table)->truncate();
        $this->info('Table cleared successfully');
    }
}
