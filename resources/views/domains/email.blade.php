@extends('layouts/contentLayoutMaster')

@section('title', 'Domains Email Table')
<style>
  #yarja-table{
    overflow: scroll;
  }
</style>

@section('content')
  <div id="yarja-table">
  {{$dataTable->table()}}
  </div>
@endsection

@push('scripts')
  {{$dataTable->scripts()}}
@endpush
