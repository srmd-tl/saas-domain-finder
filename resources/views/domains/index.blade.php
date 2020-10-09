
@extends('layouts/contentLayoutMaster')

@section('title', 'Domains Table')


@section('content')
  {{$dataTable->table()}}
@endsection

@push('scripts')
  {{$dataTable->scripts()}}
@endpush
