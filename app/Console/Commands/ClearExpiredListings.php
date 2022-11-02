<?php

namespace App\Console\Commands;

use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearExpiredListings extends Command
{
    protected $days = 30;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Listings older then 30 days to rented';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = Listing::query()
            ->whereStatus('published')
            ->where('status_updated_at', '<', Carbon::now()->subDays($this->days));

        $queryCount = $query->count();

        if ($queryCount === 0) {
            $this->warn('There are no expired listings!');

            return false;
        }

        $this->info('Updating Listings...');
        $this->newLine();
        $bar = $this->output->createProgressBar($queryCount);
        $bar->start();

        $query->chunkById(50, function ($listings) use ($bar) {
          //  $listings->each->rent();
            foreach ($listings as $listing) {
                $listing->rent('Listing expired');

                $bar->advance();
           }
        });

        $bar->finish();

        $this->newLine(2);
        $this->info("$queryCount Listings has been set to expired!");

        return true;
    }
}
