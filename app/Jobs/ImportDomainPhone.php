<?php

namespace App\Jobs;

use App\Imports\DomainPhoneImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportDomainPhone implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $date;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(string $date)
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
    Excel::import(new DomainPhoneImport(), public_path(sprintf("whois/%s-%s.csv", "phone", $this->date)));

  }
}
