@extends('main')

@section('title', 'Error 428')

@section('content')

@include('partials._error', array('errorcode' => 'Error 428 - Precondition Required', 'errormessage' => 'Er is een probleem opgedoken in verband met je verzoek', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection