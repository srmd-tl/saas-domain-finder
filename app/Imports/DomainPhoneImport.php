<?php

namespace App\Imports;

use App\Domain;
use App\DomainPhone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DomainPhoneImport implements ToCollection, WithStartRow, WithChunkReading
{
  /**
   * @param Collection $rows
   */
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      $domain = Domain::whereName($row[1])->first();
      $domainPhone =DomainPhone::where(["name" => $row[1]])->first();
      if(!$domainPhone)
      {
        DomainPhone::create(["name" => $row[1], "phone" => $row[15]]);
      }
      if ($domain) {
        $domain->update(["phone_number" => $row[17]]);
      }
    }
  }

  public function chunkSize(): int
  {
    return 50;
  }

  public function startRow(): int
  {
    return 2;
  }
}
