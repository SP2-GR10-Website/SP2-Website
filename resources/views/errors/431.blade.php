@extends('main')

@section('title', 'Error 431')

@section('content')

@include('partials._error', array('errorcode' => 'Error 431 - Request Header Fields Too Large', 'errormessage' => 'De server kon je verzoek niet verwerken, ', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection