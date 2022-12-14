<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'on_hold' => 'On hold',
            'in_process' => 'In Process',
            'awaiting_payment' => 'Awaiting for payment',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'paid' => 'Paid',
        ];

        foreach ($data as $code => $name) {
            $status = OrderStatus::firstOrNew([
                'code' => $code,
            ]);

            $status->name = $name;

            $status->save();
        }
    }
}
