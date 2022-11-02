<?php

namespace App\Console\Commands;

use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       /* SitemapGenerator::create(env('APP_URL'))
            ->maxTagsPerSitemap(20000)
            ->writeToFile(public_path('sitemap.xml'));*/
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setLastModificationDate(Carbon::now())->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS))
            ->add(Url::create('/login')->setLastModificationDate(Carbon::now())->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER))
            ->add(Url::create('/register')->setLastModificationDate(Carbon::now())->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER))
            ->add(Url::create('/oglasi-nekretninu-za-izdavanje')->setLastModificationDate(Carbon::now())->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/nekretnine')->setLastModificationDate(Carbon::now())->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS))
            ->add(Listing::active()->get())
            ->add(Url::create('/sitemap.xml'));

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
