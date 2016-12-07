@extends('main')

@section('title', 'Error 405')

@section('content')

@include('partials._error', array('errorcode' => 'Error 405 - Method Not Allowed', 'errormessage' => 'Er is een probleem opgetreden', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection