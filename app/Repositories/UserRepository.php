<?php


namespace App\Repositories;


use App\StripeProduct;
use Stripe\Exception\ApiErrorException;
use Stripe\Subscription;

class UserRepository
{

  /**
   * Add Subscription Data
   * @param int $userId
   * @param int $productId
   * @return string
   * @throws ApiErrorException
   */
  public function addUserSubscription(int $userId, int $productId)
  {
    $product = StripeProduct::findOrFail($productId);
    if ($product) {
      $data = [
        "user_id" => $userId,
        "name" => "default",
        "stripe_id" => env("MANUAL_PAYMENT") ?? "mp2021sdf",
        "stripe_status" => "active",
        "stripe_plan" => env("MANUAL_PAYMENT") ?? "mp2021sdf",
        "quantity" => 1,
      ];
      \Laravel\Cashier\Subscription::create($data);
      return true;
    }

  }
}
