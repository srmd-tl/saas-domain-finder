<?php

namespace App\Imports;

use App\Domain;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Matrix\Exception;

class DomainImport implements ToCollection, WithStartRow, WithChunkReading
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
  public function collection(Collection $rows)
  {
    $data=[
      "facebook"=>"",
      "twitter"=>"",
      "instagram"=>"",
      "linkedin"=>"",
      "email"=>[
        [
          "email"=>""
        ]
      ]
    ];
    $util = new \App\Utils\Util();
    foreach ($rows as $row) {
      $domain = Domain::whereName($row[1])->first();
//      if (!$domain) {

      $isPresent = true;
      $websiteScrapedData = [];
      try {
        $body = $util->sitePresenceCheck($row[1]);
      } catch (\Exception $exception) {
        $isPresent = false;
      }
      if ($isPresent) {
        $websiteScrapedData = (self::scrapeWebsiteData($body, $isPresent));
        if($isPresent)
        {
          //Call to api to fetch social links,emails,phones,postal address
          $data = \App\Helpers\Helper::getDomainInfo($row[1]);
        }

      }
      Domain::create([
        'name' => $row[1],
        'region' => $this->country,
        'create_date' => $row[3],
        'expiry_date' => $row[5],
        'name_servers' => $row[50] ?? "NA",
        'is_present' => $isPresent,
        'title' => $websiteScrapedData["title"] ?? null,
        'description' => $websiteScrapedData["description"] ?? null,
        'facebook' => $data['socialLinks']['facebook'] ?? null,
        'twitter' => $data['socialLinks']['twitter'] ?? null,
        'instagram' => $data['socialLinks']['instagram'] ?? null,
        'linkedin' => $data['socialLinks']['linkedIn'] ?? null,
//        'phone_number' => $data['phones'] ? $data['phones'][0] : null,
        'email' => $data['emails'][0]['email'] ?? null,
        'domain_registrar_name'=>$row[7]
      ]);
//      }
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


