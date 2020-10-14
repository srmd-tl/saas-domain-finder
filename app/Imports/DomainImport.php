<?php

namespace App\Imports;

use App\Domain;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DomainImport implements ToModel, WithStartRow
{

  protected  $country;
  public function  __construct(string $country)
  {
    $this->country= $country;
  }
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new Domain([
      'name' => $row[1],
      'region' =>$this->country,
      'create_date' => $row[3],
      'expiry_date' => $row[5],
      'name_servers' => $row[50]??"NA",
      'is_present' => 0,

    ]);
  }


  /**
   * @return int
   */
  public function startRow(): int
  {
    return 2;
  }
}
