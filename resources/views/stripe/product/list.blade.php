
@extends('layouts/contentLayoutMaster')

@section('title', 'Products')


@section('content')
  <div class="row" id="basic-table">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Stripe Products</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <a class="btn btn-md btn-primary" href="{{route('stripeProduct.create')}}">Create</a>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                <tr>
                  <th scope="row">{{$product->id}}</th>
                  <td>{{$product->name}}</td>
                  <td>{{$product->amount}}</td>
                  <td>{{$product->view}}</td>
                </tr>
                @empty
                @endforelse

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
