@extends('main')

@section('title', 'Error 429')

@section('content')

@include('partials._error', array('errorcode' => 'Error 429 - Too Many Requests', 'errormessage' => 'Je hebt al te veel verzoeken aangevraagd', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection