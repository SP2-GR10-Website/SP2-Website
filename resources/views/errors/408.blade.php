@extends('main')

@section('title', 'Error 408')

@section('content')

@include('partials._error', array('errorcode' => 'Error 408 - Request Timeout', 'errormessage' => 'De server deed er te lang over om te antwoorden', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection