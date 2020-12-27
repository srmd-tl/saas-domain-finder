<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PurchasedPackage
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    if (auth()->user()->subscribed('default')) {
      return $next($request);
    }
    return redirect()->route('index.pricing');
  }
}
