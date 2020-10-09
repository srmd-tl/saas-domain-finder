<?php

namespace Database\Seeders;

use App\Domain;
use Illuminate\Database\Seeder;

class DomainTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Domain::factory()
      ->times(50)
      ->create();

  }
}
