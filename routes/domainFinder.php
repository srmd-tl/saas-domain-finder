<?php

use App\User;

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
  //Third Party APIs Setup
  Route::resource('external-services',ExternalServiceController::class);
});
//Stripe Billing Routes For Guest User
Route::get('pricing', 'BillingController@pricing')->name('index.pricing');
Route::post('update/paymentMethod', 'BillingController@updatePaymentMethod')->name('update.paymentMethod');
Route::post('add/subscription', 'BillingController@addSubscription')->name('add.subscription');
//single charge
Route::post('purchase', 'BillingController@singleCharge')->name('single.charge');
//Unimplemented routes
Route::resource('users', UsersController::class);
Route::post('planstore', function () {
})->name('plan.store');

Route::post('clientstore', function () {
})->name('client.store');

//Logout
Route::any('logout', function () {
  \Illuminate\Support\Facades\Auth::logout();
  return redirect()->route('login');

})->name('logout');
//Campaign
Route::resource('campaign', CampaignController::class);
//Stripe Webhook
Route::post('webhook/stripe', function () {
  $payload = @file_get_contents('php://input');
  $event = null;

  try {
    $event = \Stripe\Event::constructFrom(
      json_decode($payload, true)
    );
  } catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
  }

// Handle the event
  switch ($event->type) {
    case 'invoice.created':
      $invoice = $event->data->object;
      if ($invoice) {
        $customerId = $invoice->customer;
        $user = User::whereStripeId($customerId)->first();
        $lines = $invoice->lines->data[0];
        if ($lines->subscription ?? false) {
          $product = $lines->product;
          $stripeProduct = \App\StripeProduct::whereStripeProductId($product)->firstOrFail();
          $user->subscriptions[0]->update(["quantity" => $user->subscriptions[0]->quantity + $stripeProduct->view]);

        }
      }
      break;

    default:
      echo 'Received unknown event type ' . $event->type;
  }

  http_response_code(200);
});
