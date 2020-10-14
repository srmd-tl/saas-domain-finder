<?php

namespace App\Imports;

use App\Domain;
use Maatwebsite\Excel\Concerns\ToModel;

class DomainImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Domain([
            'name'     => $row[0],
            'region'    => $row[1],
            'create_date' => Hash::make($row[2]),
            'expiry_date' => Hash::make($row[3]),
            'is_present' => Hash::make($row[4]),
            'name_servers' => Hash::make($row[5]),

        ]);
    }
}
