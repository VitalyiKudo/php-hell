<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()

    {

        #$tag = Tag::approvedPosts()->orderBy('updated_at', 'desc')->first();

        return response()->view('sitemap.index', [

            /*'tag' => $tag,*/

        ])->header('Content-Type', 'text/xml');

    }
}
