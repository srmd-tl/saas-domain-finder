<?php

namespace App\Jobs;

use App\Imports\DomainImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportUKDomains implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $date;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($date)
  {
    $this->date = $date;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    Excel::import(new DomainImport("United Kingdom"), public_path(sprintf("whois/%s/country-specific-database/united_kingdom.csv", $this->date)));

  }
}
