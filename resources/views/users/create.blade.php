
@extends('layouts/contentLayoutMaster')

@section('title', 'Create User')

@section('content')
  <!-- Basic Inputs Groups start -->
  @if($errors->any())
    @foreach($errors->all() as $error)
      <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <p class="mb-0">
          {{$error}}
        </p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
    @endforeach
  @endif
  <section id="basic-input-groups">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Basic User Info</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="row">
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Name</label>
                      <input type="text" class="form-control" id="basicInput"  placeholder="Enter name" name="name">
                    </fieldset>
                  </div>
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Email</label>
                      <input type="email" class="form-control" id="basicInput2"  placeholder="Enter Email" name="email">
                    </fieldset>
                  </div>
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Password</label>
                      <input type="password" class="form-control" id="basicInput3"  placeholder="Enter Password" name="password">
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
