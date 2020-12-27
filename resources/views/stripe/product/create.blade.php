
@extends('layouts/contentLayoutMaster')

@section('title', 'Create Product')

@section('content')
  <!-- Basic Inputs Groups start -->
  @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
  @endif
  <section id="basic-input-groups">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Basic Product Info</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form method="POST" action="{{route('stripeProduct.store')}}">
                @csrf
              <div class="row">
                <div class="col-md-4 col-12 mb-1">
                  <fieldset class="form-group">
                    <label for="basicInput">Product Name</label>
                    <input type="text" class="form-control" id="basicInput"  placeholder="Enter name" name="name">
                  </fieldset>
                </div>
                <div class="col-md-4 col-12 mb-1">
                  <fieldset class="form-group">
                    <label for="basicInput">Product Price</label>
                    <input type="text" class="form-control" id="basicInput2"  placeholder="Enter price" name="amount">
                  </fieldset>
                </div>
                <div class="col-md-4 col-12 mb-1">
                  <fieldset class="form-group">
                    <label for="basicInput">Views Allowed</label>
                    <input type="text" class="form-control" id="basicInput3"  placeholder="Enter number of views" name="view">
                  </fieldset>
                </div>
              </div>
                <button class="btn btn-md btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Basic Inputs Groups end -->
@endsection
