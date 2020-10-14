<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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

    $date = "2020-10-13";

    //Your username.
    $username = '2020-11-01';
    //Your password.
    $password = '3CHf7ZJfQ541';
    try {
      $response = self::curlCall($username, $password, $date);

    } catch (\Exception $exception) {
      Log::alert($exception->getMessage());
      dd($exception);
    }
    //Unzip File
    if ($response) {

      try {
//        $response = self::unzipFile($date);
      } catch (\Exception $exception) {
        Log::alert($exception->getMessage());
        dd($exception);
      }


    }
    //Read Csv Files and seed db
    if ($response) {

    }

    return 0;
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
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_VERBOSE, true);


      $headers = array();
      //Basic Auth
      $header = sprintf("Authorization: Basic %s", $basicAuth);
      $headers[] = $header;
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);

      //Get Status Code
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
      }



      if ((filesize($filepath) > 0)) {

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
      $zipArchive->extractTo(public_path("whois"));
      $zipArchive->close();
      return true;

    } else {
      throw new \Exception("File not found");
    }



  }
}

//curl --request GET  --url https://global.whoisdatacenter.com/2020-10-11.zip  --header 'authorization: Basic MjAyMC0xMS0wMTozQ0hmN1pKZlE1NDE=' -O -J
