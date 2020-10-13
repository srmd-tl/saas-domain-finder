<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    $date = "2020-10-11";
    //Your username.
    $username = '2020-11-01';
    //Your password.
    $password = '3CHf7ZJfQ541';
    try {
      self::curlCall($username, $password, $date);

    } catch (\Exception $exception) {
      Log::alert($exception->getMessage());
      dd($exception);
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
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_VERBOSE, true);


      $headers = array();
      //Basic Auth
      $header = sprintf("Authorization: Basic %s", $basicAuth);
      $headers[] = $header;
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $result = curl_exec($ch);
      if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
      }

      //putting content retrieved from API
      file_put_contents($filepath, $result);

      if ((filesize($filepath) > 0)) {
        throw new \Exception("File Fetched");
      } else {
        throw new \Exception("File Not Found!");
      }

      curl_close($ch);

    } else {
      throw new \Exception("File Already Exists");
    }

  }
}

//curl --request GET  --url https://global.whoisdatacenter.com/2020-10-11.zip  --header 'authorization: Basic MjAyMC0xMS0wMTozQ0hmN1pKZlE1NDE=' -O -J
