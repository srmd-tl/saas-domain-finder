<?php

namespace App\Imports;

use App\Domain;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DomainImport implements ToModel, WithStartRow
{

  protected $country;

  public function __construct(string $country)
  {
    $this->country = $country;
  }

  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    $util = new \App\Utils\Util();
    $isPresent = true;
    $websiteScrapedData = [];
    try {
      $body = $util->sitePresenceCheck($row[1]);
    } catch (\Exception $exception) {
      $isPresent = false;
    }
    if ($isPresent) {
      $websiteScrapedData = (self::scrapeWebsiteData($body, $isPresent));

    }


    return new Domain([
      'name' => $row[1],
      'region' => $this->country,
      'create_date' => $row[3],
      'expiry_date' => $row[5],
      'name_servers' => $row[50] ?? "NA",
      'is_present' => $isPresent,
      'title' => $websiteScrapedData["title"] ?? null,
      'description' => $websiteScrapedData["description"] ?? null

    ]);
  }


  /**
   * @return int
   */
  public function startRow(): int
  {
    return 2;
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
        $title = $crawler->filterXPath('//title')->text();
      }

    }

    return ["title" => $title ?? null, "description" => $metaDescription[0] ?? null];


  }


}


