<?php

namespace App\Imports;

use App\Domain;
use App\DomainEmail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DomainEmailImport implements ToCollection, WithStartRow, WithChunkReading
{
  /**
   * @param Collection $rows
   */
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      $domain = Domain::whereName($row[1])->first();
      $domainEmail =DomainEmail::where(["name" => $row[1]])->first();
      if(!$domainEmail)
      {
        DomainEmail::create(["name" => $row[1], "email" => $row[17]]);
      }
      if ($domain) {
        $domain->update(["email" => $row[17]]);

      }
    }
  }

  /**
   * @return int
   */
  public function startRow(): int
  {
    return 2;
  }

  public function chunkSize(): int
  {
    return 50;
  }
}
