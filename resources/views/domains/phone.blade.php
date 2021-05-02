@extends('layouts/contentLayoutMaster')

@section('title', 'Domain Phone Table')


@section('content')
  {{$dataTable->table()}}
@endsection

@push('scripts')
  {{$dataTable->scripts()}}
@endpush
