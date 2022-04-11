<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\Crawler;
use Illuminate\Support\Str;

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
        $generator = SitemapGenerator::create(config('app.url'))
            #->maxTagsPerSitemap(10000)
            ->configureCrawler(function (Crawler $crawler) {
                $crawler
                    ->setUserAgent(config('app.name').'/'.app()->version())
                    ->setDelayBetweenRequests(150)
                    ->setParseableMimeTypes(['text/html'])
                    ->ignoreRobots();
            })

            ->hasCrawled(function (Url $url) {

                // Set priority
                #$url->setPriority(0.9);
                if (empty($url->segment(1))) { $url->setPriority(1); }
                if (Str::contains($url->segment(1), ['services', 'login'])) { $url->setPriority(0.9); }
                if (Str::contains($url->segment(1), 'aircraft')) { $url->setPriority(0.8); }
                if (Str::contains($url->segment(1), ['about', 'register'])) { $url->setPriority(0.5); }
                if (Str::contains($url->segment(1), ['terms-conditions', 'password', 'support'])) { $url->setPriority(0.2); }
                if (Str::contains($url->segment(1), 'privacy-policy')) { $url->setPriority(0.1); }

                // Fix urls with trailing slash
                if (Str::endsWith($url->url, '/')) {
                    $url->url = rtrim($url->url, '/');
                    return $url;
                }

                return $url;
            });

        $generator->writeToFile(public_path('sitemap.xml'));

        return 'Sitemap generated';
    }
}
