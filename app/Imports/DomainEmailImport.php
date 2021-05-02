<?php

namespace App\Imports;

use App\Domain;
use App\DomainEmail;
use App\Helpers\Helper;
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
    $util = new \App\Utils\Util();
    foreach ($rows as $row) {
      $domain = Domain::whereName($row[1])->first();
      $domainEmail = DomainEmail::where(["name" => $row[1]])->first();
      if (!$domainEmail) {
        $isPresent = true;
        $websiteScrapedData = [];
        try {
          $body = $util->sitePresenceCheck($row[1]);
        } catch (\Exception $exception) {
          $isPresent = false;
        }
        if ($isPresent) {
          $websiteScrapedData = (self::scrapeWebsiteData($body, $isPresent));
          if ($isPresent) {
            //Call to api to fetch social links,emails,phones,postal address
            $data = \App\Helpers\Helper::getDomainInfo($row[1]);
          }

        }
        if (($websiteScrapedData["title"] ?? false) && !Helper::detectChineseUTF8($websiteScrapedData["title"])) {
          DomainEmail::create(
            [
              'is_present' => $isPresent,
              'name' => $row[1],
              'email' => $row[17],
              'register_date' => $row[2],
              'server' => $row[7],
              'owner_name' => $row[10],
              'other_name' => $row[11],
              'address' => $row[12],
              'city' => $row[13],
              'state' => $row[14],
              'zip' => $row[15],
              'country' => $row[16],
              'title' => $websiteScrapedData["title"] ?? null,
              'description' => $websiteScrapedData["description"] ?? null,
            ]
          );
        }


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
