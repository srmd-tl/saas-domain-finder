
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit  Credentials')

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
            <h4 class="card-title">Basic Service Info</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form method="POST" action="{{route('external-services.update',$service->id)}}">
                @csrf
                @method("PUT")
                <div class="row">
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Service Name</label>
                      <select name="name" class="form-control" required>
                        <option selected default>Select Service</option>
                        @forelse($services as $serviceFromFile)
                          <option {{$service->service_name==$serviceFromFile?"selected":""}} value="{{$serviceFromFile}}">{{$serviceFromFile}}</option>
                        @empty
                          <option>Nothing Found</option>
                        @endforelse
                      </select>
                    </fieldset>
                  </div>
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Username</label>
                      <input type="text" class="form-control" id="basicInput2"  placeholder="Enter username if any" name="username" value="{{$service->username}}">
                    </fieldset>
                  </div>
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput">Email</label>
                      <input type="text" class="form-control" id="basicInput3"  placeholder="Enter email if any" name="email" value="{{$service->email}}">
                    </fieldset>
                  </div>
                  <div class="col-md-4 col-12 mb-1">
                    <fieldset class="form-group">
                      <label for="basicInput4">Password</label>
                      <input type="text" class="form-control" id="basicInput4"  placeholder="Enter password" name="password" value="{{$service->password}}">
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
