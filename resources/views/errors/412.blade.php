@extends('main')

@section('title', 'Error 412')

@section('content')

@include('partials._error', array('errorcode' => 'Error 412 - Precondition Failed', 'errormessage' => 'Er is een probleem opgetreden bij de server', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection