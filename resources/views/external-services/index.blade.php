
@extends('layouts/contentLayoutMaster')

@section('title', 'Third Party Services')


@section('content')
  <div class="row" id="basic-table">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">External Services</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <a class="btn btn-md btn-primary" href="{{route('external-services.create')}}">Create</a>
            <!-- Table with outer spacing -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($services as $service)
                <tr>
                  <th scope="row">{{$service->id}}</th>
                  <td>{{$service->service_name}}</td>
                  <td>{{$service->username}}</td>
                  <td>{{$service->email}}</td>
                  <td>{{$service->password}}</td>
                  <td><a href="{{route("external-services.edit",$service->id)}}">Edit</a></td>
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

