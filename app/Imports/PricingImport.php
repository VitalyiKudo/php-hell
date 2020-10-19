<?php

namespace App\Imports;

use App\Models\Pricing;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
            //'departure' => (string)str_replace('-', ' ', $row[1]),
            //'arrival' => (string)str_replace('-', ' ', $row[2]),
            'departure' => (string)$row[1],
            'arrival' => (string)$row[2],
            'time_turbo' => $row[3]?Date::excelToDateTimeObject($row[3])->format('h:i'):'',
            'price_turbo' => (int)$row[4],
            'time_light' => $row[5]?Date::excelToDateTimeObject($row[5])->format('h:i'):'',
            'price_light' => (int)$row[6],
            'time_medium' => $row[7]?Date::excelToDateTimeObject($row[7])->format('h:i'):'',
            'price_medium' => (int)$row[8],
            'time_heavy' => $row[9]?Date::excelToDateTimeObject($row[9])->format('h:i'):'',
            'price_heavy' => (int)$row[10],
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
