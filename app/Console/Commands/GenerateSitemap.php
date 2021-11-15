<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
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
     * @return mixed
     */
    public function handle()
    {
        // modify this to your own needs
        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->add(Url::create('/')->setPriority(0.9))
            ->add(Url::create('/services')->setPriority(0.9))
            ->add(Url::create('/aircraft')->setPriority(0.8))
            ->add(Url::create('/about')->setPriority(0.5))
            ->add(Url::create('/support')->setPriority(0.2))
            ->add(Url::create('/register')->setPriority(0.5))
            ->add(Url::create('/login')->setPriority(0.9))
            ->add(Url::create('/aircraft')->setPriority(0.8))
            ->add(Url::create('/JetOnset')->setPriority(0.1))
            ->add(Url::create('/terms-conditions')->setPriority(0.2))
            ->add(Url::create('/password/reset')->setPriority(0.2))
            ->writeToFile(public_path('sitemap.xml'));

        return 'Sitemap generated';
    }
}
