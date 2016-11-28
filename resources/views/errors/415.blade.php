@extends('main')

@section('title', 'Error 415')

@section('content')

@include('partials._error', array('errorcode' => 'Error 415 - Unsupported Media Type', 'errormessage' => 'De server kon het mediatype van je verzoek niet verwerken', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection