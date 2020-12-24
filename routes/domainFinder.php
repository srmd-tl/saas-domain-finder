<?php
//Report Generator
Route::get('report/{domain}', function (\App\Domain $domain) {
  $util = new \App\Utils\Util();
  try {
    $report = $util->callToGtMetrix($domain->name);
  } catch (Exception $e) {
    abort($e->getMessage());
  }
  if ($report) {
    dd($report);
    return redirect($report->getReportUrl());
  }

})->name('generateReport');

//Domains Routes
Route::get('domains', 'DomainController@index')->name('domains.index');

//Stripe routes

Route::prefix('admin')->group(function () {
  Route::get('stripe-products', 'StripeProductController@index')->name('stripeProduct.index');
  Route::post('stripe-product', 'StripeProductController@store')->name('stripeProduct.store');
  Route::get('stripe-product/create', 'StripeProductController@create')->name('stripeProduct.create');
});

