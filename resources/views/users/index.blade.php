@extends('layouts/contentLayoutMaster')

@section('title', 'Users Table')


@section('content')
  {{$dataTable->table()}}
@endsection

@push('scripts')
  {{$dataTable->scripts()}}
@endpush
