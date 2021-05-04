<?php

namespace App\Console\Commands;

use App\ExternalService;
use App\Helpers\Helper;
use App\Jobs\ImportCADomains;
use App\Jobs\ImportDomainEmail;
use App\Jobs\ImportDomainPhone;
use App\Jobs\ImportUKDomains;
use App\Jobs\ImportUSDomains;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

/**
 * Class FetchDomains
 * @package App\Console\Commands
 */
class FetchDomains extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'fetch:domains';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fetch records from whoisdatacenter';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $date = "2021-04-25";
    $emailJob = (new ImportDomainEmail($date))->onQueue('importDomainsEmail');
    dispatch($emailJob);
    dd("hr");
    $phoneResponse = null;
    $emailResponse = null;
    //Fetch Credentails
    $domainFinder = Helper::fetchServicesFromYaml();
    $domainFinderCreds = ExternalService::whereServiceName($domainFinder[array_search("DomainFinder", $domainFinder)])->firstOrFail();
    if (!$domainFinderCreds) {
      Logger::ALERT("Credentails Not FOund");
      throw new \Exception("Credentails Not Found");
    }

    //Your Date
    $date = Carbon::now()->subDays(2)->toDateString();
//    $date = "2020-11-20";
//
//    //Import United States Domains
//    $usJob = (new ImportUSDomains($date));
//    dispatch($usJob);
////      Excel::import(new DomainImport("United States"), public_path(sprintf("whois/%s/country-specific-database/united_states.csv",$date)));
//    //Import Canadian Domains
//    $caJob = (new ImportCADomains($date));
//    dispatch($caJob);
//
////      Excel::import(new DomainImport("Canada"), public_path(sprintf("whois/%s/country-specific-database/canada.csv", $date)));
//    //Import Uk Domains
//    $ukJob = (new ImportUKDomains($date));
//    dispatch($ukJob);
//
//    dd('here');
    //Your username.
    $username = $domainFinderCreds->username;
    //Your password.
    $password = $domainFinderCreds->password;

    $usernameForEmailAPI = "2024-03-31";
    $passwordForEmailAPI = "PSCXMMD19XC1";
    try {
      //to get email file
      $emailResponse = self::dynamicCallCurl(
        $usernameForEmailAPI,
        $passwordForEmailAPI,
        $date,
        "c-us.whoisdatacenter.com",
        "email",
        "united_states-email");

    } catch (\Exception $exception) {
      Log::alert($exception->getMessage());
    }

    $usernameForEmailAPI = "2024-03-31";
    $passwordForEmailAPI = "PSCXMMD19XC1";
    try {
      //to get phone file
      $phoneResponse = self::dynamicCallCurl(
        $usernameForEmailAPI,
        $passwordForEmailAPI,
        $date,
        "c-us.whoisdatacenter.com",
        "phone",
        "united_states-phone");

    } catch (\Exception $exception) {
      Log::alert($exception->getMessage());
    }
    try {
      //To call main api to get domain info related file
      $response = self::curlCall($username, $password, $date);

    } catch (\Exception $exception) {
      Log::alert($exception->getMessage());
      dd($exception);
    }
    //Unzip File
    if ($response) {

      try {
        $response = self::unzipFile($date);
      } catch (\Exception $exception) {
        Log::alert($exception->getMessage());
        dd($exception);
      }


    }
    //Read Csv Files and seed db
    if ($response) {
      //Import Domain Email
      if ($emailResponse) {
        $emailJob = (new ImportDomainEmail($date))->onQueue('importDomainsEmail');
        dispatch($emailJob);
      }
      //Import Domain Phone
      if ($phoneResponse) {
        $phoneJob = (new ImportDomainPhone($date))->onQueue('importDomainsPhone}');
        dispatch($phoneJob);
      }
      //Import United States Domains
      $usJob = (new ImportUSDomains($date))->onQueue('importUSDomains');
      dispatch($usJob);
//      Excel::import(new DomainImport("United States"), public_path(sprintf("whois/%s/country-specific-database/united_states.csv",$date)));
      //Import Canadian Domains
      $caJob = (new ImportCADomains($date))->onQueue('importCADomains');
      dispatch($caJob);

//      Excel::import(new DomainImport("Canada"), public_path(sprintf("whois/%s/country-specific-database/canada.csv", $date)));
      //Import Uk Domains
      $ukJob = (new ImportUKDomains($date))->onQueue('importUKDomains');
      dispatch($ukJob);
//      Excel::import(new DomainImport("United Kingdom"), public_path(sprintf("whois/%s/country-specific-database/united_kingdom.csv", $date)));
    }

    return 0;
  }

  /**
   * @param string $username
   * @param string $password
   * @param string $date
   * @param string $uri
   * @param string $filename
   * @return bool
   * @throws \Exception
   */
  private function dynamicCallCurl(string $username, string $password, string $date, string $uri, string $filename, string $apiType)
  {
    //Generate Basic Auth String
    $basicAuth = base64_encode("$username:$password");
    //output file path
    $filepath = public_path(sprintf('whois/%s-%s.csv', $filename, $date));

    if (!file_exists($filepath)) {
      $ch = curl_init();

      $url = sprintf('https://%s/%s-%s.csv', $uri, $date, $apiType);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_VERBOSE, true);


      $headers = array();
      //Basic Auth
      $header = sprintf("Authorization: Basic %s", $basicAuth);
      $headers[] = $header;
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);

      $statusCode = curl_getinfo($ch)["http_code"];

      if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
      }


      if ($statusCode == 200) {
        //putting content retrieved from API
        file_put_contents($filepath, $result);
        return true;
      } else {
        throw new \Exception("File Not Found!");
      }

      curl_close($ch);

    } else {
      throw new \Exception("File Already Exists");
    }
  }

  /**
   * @param string $username
   * @param string $password
   * @param string $date
   * @throws \Exception
   */
  private function curlCall(string $username, string $password, string $date)
  {
    //Generate Basic Auth String
    $basicAuth = base64_encode("$username:$password");
    //output file path
    $filepath = public_path(sprintf('whois/%s.zip', $date));

    if (!file_exists($filepath)) {
      $ch = curl_init();

      $url = sprintf('https://global.whoisdatacenter.com/%s.zip', $date);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_VERBOSE, true);


      $headers = array();
      //Basic Auth
      $header = sprintf("Authorization: Basic %s", $basicAuth);
      $headers[] = $header;
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);

      $statusCode = curl_getinfo($ch)["http_code"];

      if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
      }


      if ($statusCode == 200) {
        //putting content retrieved from API
        file_put_contents($filepath, $result);
        return true;
      } else {
        throw new \Exception("File Not Found!");
      }

      curl_close($ch);

    } else {
      throw new \Exception("File Already Exists");
    }

  }

  /**
   * @param string $file
   * @return bool
   */
  private function unzipFile(string $file): bool
  {
    $zipArchive = new \ZipArchive();
    $path = public_path(sprintf("whois/%s.zip", $file));
    $status = $zipArchive->open($path);

    if ($status === TRUE) {
      $zipArchive->extractTo(public_path(sprintf("whois/%s", $file)));
      $zipArchive->close();
      return true;

    } else {
      throw new \Exception("File not found");
    }


  }
}

//curl --request GET  --url https://global.whoisdatacenter.com/2020-10-11.zip  --header 'authorization: Basic MjAyMC0xMS0wMTozQ0hmN1pKZlE1NDE=' -O -J
//wget --user="2020-12-31" --password="$d@]4RY}.5X6" Https://global.whoisdatacenter.com/2020-11-22-global-email.csv
//email url
//wget --user=2024-03-31 --password='PSCXMMD19XC1' https://c-us.whoisdatacenter.com/2021-04-03-united_states-email.csv
//phone url
//wget --user=2024-03-31 --password='PSCXMMD19XC1' https://c-us.whoisdatacenter.com/2021-04-03-united_states-phone.csv

