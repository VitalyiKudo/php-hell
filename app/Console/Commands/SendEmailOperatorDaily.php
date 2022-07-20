<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Operator;
use App\Jobs\SendEmailOperatorDailyJobs;
use Carbon;

class SendEmailOperatorDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendEmailOperatorDaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command SendEmailOperatorDaily';

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
     * @param Operator $operator
     *
     * @return bool
     */
    public function handle(Operator $operator)
    {
        $oldRecord = $operator->latest('sending_date')->first()->id;#->take(2)->get();
        $operators = $operator->orderBy('id')->get()->slice($oldRecord, 20)->keyBy('id');
        if (count($operators) < 20) {
            $operators = $operators->merge($operator->orderBy('id')->get()->slice(0, 20 - count($operators))->keyBy('id'));
        }

        dispatch(new SendEmailOperatorDailyJobs($operators));

        $operator->whereIn('id', $operators->keyBy('id')->keys())->update(['sending_date' => Carbon::today()]);

        return true;
    }
}
