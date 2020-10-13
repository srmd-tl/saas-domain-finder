<?php

namespace App\Utils;

use Entrecore\GTMetrixClient\GTMetrixClient;
use Entrecore\GTMetrixClient\GTMetrixTest;

class Util
{
  public function callToGtMetrix()
  {
    $client = new GTMetrixClient();
    $client->setUsername("sarmadking@gmail.com");
    $client->setAPIKey("1a914d14d5f887ed117ffc90667c8f9a");
    $client->getLocations();
    $client->getBrowsers();

    $test = $client->startTest("https://www.youtube.com");

    //Wait for result
    while ($test->getState() != GTMetrixTest::STATE_COMPLETED &&
      $test->getState() != GTMetrixTest::STATE_ERROR) {
      ($client->getTestStatus($test));
      sleep(5);
    }
  }

}
