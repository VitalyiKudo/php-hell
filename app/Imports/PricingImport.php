<?php

namespace App\Imports;

use App\Models\Pricing;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PricingImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use RemembersRowNumber;
    
    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();
        
        return new Pricing([
            'source_id' => $currentRowNumber,
            'departure' => (string)$row[1],
            'arrival' => (string)$row[2],
            'time' => (string)$row[3],
            'price_turbo' => (int)$row[4],
            'price_light' => (int)$row[5],
            'price_medium' => (int)$row[6],
            'price_heavy' => (int)$row[7],
        ]);
    }
    
    public function startRow(): int
    {
        return 3;
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
