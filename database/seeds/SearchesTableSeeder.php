<?php

use App\Models\Search;
use App\Models\SearchResult;
use App\Models\SearchResultSegment;
use Illuminate\Database\Seeder;

class SearchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Search::class, 50)->create();
    }
}
