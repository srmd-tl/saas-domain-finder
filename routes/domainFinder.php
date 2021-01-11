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
});
//Stripe Billing Routes For Guest User
Route::get('pricing', 'BillingController@pricing')->name('index.pricing');
Route::post('update/paymentMethod', 'BillingController@updatePaymentMethod')->name('update.paymentMethod');
Route::post('add/subscription', 'BillingController@addSubscription')->name('add.subscription');
//single charge
Route::post('purchase', 'BillingController@singleCharge')->name('single.charge');
//Unimplemented routes
Route::resource('user', 'UserController');
Route::post('planstore', function () {
})->name('plan.store');

Route::post('clientstore', function () {
})->name('client.store');

//Logout
Route::any('logout', function () {
  \Illuminate\Support\Facades\Auth::logout();
  return redirect()->route('login');

})->name('logout');


//Stripe Webhook
Route::post('webhook/stripe', function () {
  echo "hello there" . PHP_EOL;
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
    case 'payment_intent.succeeded':
      $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
      // Then define and call a method to handle the successful payment intent.
      // handlePaymentIntentSucceeded($paymentIntent);
      break;
    case 'payment_method.attached':
      $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
      // Then define and call a method to handle the successful attachment of a PaymentMethod.
      // handlePaymentMethodAttached($paymentMethod);
      break;
    // ... handle other event types
    case 'invoice.updated':
      $invoice =$event->data->object;
      print_r($invoice);
    case 'invoice.payment_succeeded':
      $invoice =$event->data->object;
      if($invoice)
      {
        $customerId=  $invoice->customer;
        $user = User::whereStripeId($customerId)->first();
//        $user->update(['domainsView'=>]);
      }
      print_r($user);
    default:
      echo 'Received unknown event type ' . $event->type;
  }

  http_response_code(200);
});
