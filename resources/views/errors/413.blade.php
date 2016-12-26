@extends('main')

@section('title', 'Error 411')

@section('content')

@include('partials._error', array('errorcode' => 'Error 413 - Request Entity Too Large', 'errormessage' => 'De server kon een verzoek niet accepteren wegens zijn grootte', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection