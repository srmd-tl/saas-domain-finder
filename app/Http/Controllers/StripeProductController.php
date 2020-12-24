<?php

namespace App\Http\Controllers;

use App\StripeProduct;
use App\Utils\StripeTraits;
use Illuminate\Http\Request;

class StripeProductController extends Controller
{
  use StripeTraits;

  public function store(Request $request)
  {
    $request->validate([
      "name" => "required",
      "price" => "required"
    ]);
    try {
      $product = $this->storeProduct($request->name);
    } catch (\Exception $e) {
      return back()->withErrors($e->getMessage());
    }
    try {
      $price = $this->storePlan($request->price, $product->id);
    } catch (\Exception $e) {
      return back()->withErrors($e->getMessage());

    }
    StripeProduct::create([
      "name" => $request->name,
      "stripe_product_id" => $product->id,
      "amount" => $request->amount,
      "view" => $request->view,//how much domains he can view
      "interval" => $request->interval ?? "Monthly",
      "stripe_price_id" => $price->id
    ]);
    return back()->withSuccess("Product Saved");
  }

  public function create()
  {
    return view('stripe.product.create');
  }

  public function index()
  {
    $data = [StripeProduct::all()];
    return view('stripe.product.list',$data);
  }
}
