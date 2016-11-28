@extends('main')

@section('title', 'Error 400')

@section('content')

@include('partials._error', array('errorcode' => 'Error 400 - Bad Request', 'errormessage' => 'Je verzoek kon niet behandeld worden door de server', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection