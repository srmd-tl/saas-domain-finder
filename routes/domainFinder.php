<?php
Route::group(["middleware" => ["auth", "is_subscriber"]], function () {
  // Route url
  Route::get('/', 'DashboardController@dashboardAnalytics')->name('index');
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
});

//Stripe routes for admin

Route::prefix('admin')->group(function () {
  Route::get('stripe-products', 'StripeProductController@index')->name('stripeProduct.index');
  Route::post('stripe-product', 'StripeProductController@store')->name('stripeProduct.store');
  Route::get('stripe-product/create', 'StripeProductController@create')->name('stripeProduct.create');
});
//Stripe Billing Routes For Guest User
Route::get('pricing', 'BillingController@pricing')->name('index.pricing');
Route::post('update/paymentMethod', 'BillingController@updatePaymentMethod')->name('update.paymentMethod');
Route::post('add/subscription', 'BillingController@addSubscription')->name('add.subscription');
//Unimplemented routes
  Route::resource('user', 'UserController');
  Route::post('planstore', function () {
  })->name('plan.store');

  Route::post('clientstore', function () {
  })->name('client.store');
