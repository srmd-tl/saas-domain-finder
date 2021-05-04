<?php

namespace App\Imports;

use App\Domain;
use App\DomainEmail;
use App\DomainPhone;
use App\Helpers\Helper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Matrix\Exception;

class DomainPhoneImport implements ToCollection, WithStartRow, WithChunkReading
{
  /**
   * @param Collection $rows
   */
  public function collection(Collection $rows)
  {
    $util = new \App\Utils\Util();
    foreach ($rows as $row) {
      $domain = Domain::whereName($row[1])->first();
      $domainEmail = DomainPhone::where(["name" => $row[1]])->first();
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
          DomainPhone::create(
            [
              'is_present' => $isPresent,
              'name' => $row[1],
              'phone_number' => $row[18],
              'email'=>$row[17],
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
        $domain->update(["phone_number" => $row[18]]);

      }
    }
  }
  private function scrapeWebsiteData($body, bool &$isPresent): array
  {
    $title = null;
    $metaDescription = [];
    if ($body) {
      $crawler = new \Symfony\Component\DomCrawler\Crawler($body);
      $metaDescription = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));
      if ($metaDescription && preg_match("/available for sale/", $metaDescription[0])) {
        $isPresent = false;
        \Illuminate\Support\Facades\Log::alert("domain is for sale");
      }

      if ($isPresent) {
        try {
          try {


            $title = $crawler->filterXPath('//title')->text();
          } catch (\InvalidArgumentException $e) {
            $title = null;
          }

        } catch (Exception $exception) {
          dd($exception);
        }

      }

    }
    return ["title" => $title ?? null, "description" => $metaDescription[0] ?? null];


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
