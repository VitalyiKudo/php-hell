<?php

namespace App\Imports;

use App\Models\Operator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class OperatorImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
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
        
        return new Operator([
            'source_id' => $currentRowNumber,
            'name' => (string)$row[1],
            'web_site' => (string)$row[2],
            'email' => (string)$row[3],
            'phone' => (string)$row[4],
            'mobile' => (string)$row[5],
            'fax' => (string)$row[6],
            'address' => (string)$row[7],
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
