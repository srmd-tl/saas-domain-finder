<?php
declare(strict_types=1);

namespace App\Utils;


use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\Plan;
use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;

/**
 * Trait StripeTraits
 * @package App\Utils
 */
trait StripeTraits
{
  /**
   * @var
   */
  private $client;

  /**
   * @param string $name
   * @return Product
   * @throws Exception
   */
  public function storeProduct(string $name): Product
  {
    try {
      $product = $this->initClient()->products->create([
        'name' => $name,
      ]);
    } catch (ApiErrorException $e) {
      throw new Exception($e->getMessage());
    }
    return $product;
  }

  /**
   * @return StripeClient
   */
  private function initClient(): StripeClient
  {
    return new StripeClient(
      env("STRIPE_SECRET"));
  }

  /**
   * @param int $price
   * @param string $productId
   * @return Plan
   * @throws Exception
   */
  public function storePlan(int $price, string $productId): Plan
  {
    try {
      $plan = $this->initClient()->plans->create([
        'amount' => $price,
        'currency' => 'usd',
        'product' => $productId,
        'interval' => 'month',
      ]);
    } catch (ApiErrorException $e) {
      throw new Exception($e->getMessage());
    }
    return $plan;
  }
}
