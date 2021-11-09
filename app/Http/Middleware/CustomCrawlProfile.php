<?php

namespace App\Http\Middleware;

use Spatie\Crawler\CrawlProfile;
use Psr\Http\Message\UriInterface;

class CustomCrawlProfile extends CrawlProfile
{
    public function shouldCrawl(UriInterface $url): bool
    {
        if ($url->getHost() !== 'localhost') {

            return 'https://jetonset.com/';
        }

        #return $url->getPath() === '/';
        return $url->getPath();
    }
}
