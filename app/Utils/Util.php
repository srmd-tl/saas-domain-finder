<?php

namespace App\Utils;

use Entrecore\GTMetrixClient\GTMetrixClient;
use Entrecore\GTMetrixClient\GTMetrixTest;
use Illuminate\Support\Facades\Http;

/**
 * Class Util
 * @package App\Utils
 */
class Util
{
  /**
   * @return GTMetrixTest
   * @throws \Entrecore\GTMetrixClient\GTMetrixConfigurationException
   * @throws \Entrecore\GTMetrixClient\GTMetrixException
   */
  public function callToGtMetrix(): GTMetrixTest
  {
    $client = new GTMetrixClient();
    $client->setUsername("sarmadking@gmail.com");
    $client->setAPIKey("1a914d14d5f887ed117ffc90667c8f9a");
    $client->getLocations();
    $client->getBrowsers();

    $test = $client->startTest("http://www.measurement2000.com");


    //Wait for result
    while ($test->getState() != GTMetrixTest::STATE_COMPLETED &&
      $test->getState() != GTMetrixTest::STATE_ERROR) {
      ($client->getTestStatus($test));
      sleep(5);
    }
    return ($client->getTestStatus($test));
  }

  /**
   * @param string $url
   * @throws \Exception
   */
  public function sitePresenceCheck(string $url)
  {
    $data = Http::get($url);
    if($data->status()==200)
    {
      return $data->body();
    }
    else{
      throw new \Exception("Site is down");
    }
  }


}
//s8rDjaiq
