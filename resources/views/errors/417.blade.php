@extends('main')

@section('title', 'Error 417')

@section('content')

@include('partials._error', array('errorcode' => 'Error 417 - Expectation Failed', 'errormessage' => 'De server kon niet aan de Expect request-header voorwaarden voldoen', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection