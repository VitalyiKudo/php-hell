<?php

namespace App\Imports;

use App\Models\Airline;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AirlineImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
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
        
        return new Airline([
            'source_id' => $currentRowNumber,
            'type' => (string)$row[1],
            'reg_number' => (string)$row[2],
            'category' => (string)$row[3],
            'homebase' => (string)$row[4],
            'max_pax' => (int)$row[5],
            'yom' => (int)$row[6],
            'operator' => (string)$row[7],
        ]);
    }
    
    public function startRow(): int
    {
        return 2;
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
