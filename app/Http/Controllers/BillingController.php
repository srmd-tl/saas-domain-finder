<?php

namespace App\Http\Controllers;

use App\StripeProduct;
use Illuminate\Http\Request;

class BillingController extends Controller
{
  public function addSubscription(Request $request)
  {
    if (auth()->user()->hasPaymentMethod()) {
      //
      return auth()->user()->newSubscription('default', $request->planName)->create($request->paymentMethod);
    }
    auth()->user()->addPaymentMethod($request->paymentMethod);
    return auth()->user()->newSubscription('default', $request->planName)->create($request->paymentMethod);
  }

  /**
   * Update Payment Method View
   * @param planName
   *
   */
  public function updatePaymentMethod(Request $request)
  {
    auth()->user()->createOrGetStripeCustomer();
    $intent = auth()->user()->createSetupIntent();
    $planName = $request->planName;
    $planId = $request->planId;
    return view('stripe.updatePaymentMethod', compact('intent', 'planName', 'planId'));
  }

  public function pricing(Request $request)
  {
    $pricings = StripeProduct::paginate(5);
    return view('stripe.pricing', compact('pricings'));
  }
}
