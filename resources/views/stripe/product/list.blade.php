
@extends('layouts/contentLayoutMaster')

@section('title', 'Products')


@section('content')
  <div class="row" id="basic-table">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Basic Tables</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <p class="card-text">Using the most basic table Leanne Grahamup, here’s how <code>.table</code>-based tables look in Bootstrap. You can use any example of below table for your table and it can be use with any type of bootstrap tables.</p>
            <p><span class="text-bold-600">Example 1:</span> Table with outer spacing</p>
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
