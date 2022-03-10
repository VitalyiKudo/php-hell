<?php
namespace App;

use Illuminate\Support\Str;
use Spatie\Crawler\CrawlProfile;
use Psr\Http\Message\UriInterface;

class CustomCrawlProfile extends CrawlProfile
{
    /**
     * @param UriInterface $url
     *
     * @return bool
     */

    public function shouldCrawl(UriInterface $url): bool
    {
        if (Str::contains($url->getHost(), ['facebook', 'instagram', 'twitter', 'pinterest', 'tumblr'])) {

            return false;
        }

        return true;
    }
}
