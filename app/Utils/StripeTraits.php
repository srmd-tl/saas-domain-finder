<?php
declare(strict_types=1);

namespace App\Utils;


use Exception;
use Stripe\Exception\ApiErrorException;
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
      env("STRIPE_SK"));
  }

  /**
   * @param int $price
   * @param string $productId
   * @return Price
   * @throws Exception
   */
  public function storePlan(int $price, string $productId): Price
  {
    try {
      $plan = $this->initClient()->prices->create([
        'unit_amount' => $price,
        'currency' => 'usd',
        'product' => $productId,
      ]);
    } catch (ApiErrorException $e) {
      throw new Exception($e->getMessage());
    }
    return $plan;
  }
}
