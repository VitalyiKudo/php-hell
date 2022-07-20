<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\EmptyLeg;
use Config;

class DeactivateEmptyLegsOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DeactivateEmptyLegsOld';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command DeactivateEmptyLegsOld';

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
     * @param EmptyLeg $emptyLeg
     *
     * @return bool|int
     */
    public function handle(EmptyLeg $emptyLeg)
    {
        return $emptyLeg->DeactivateEmptyLegsOld()->update(['active' => Config::get("constants.active.Deleted")]);
    }
}
