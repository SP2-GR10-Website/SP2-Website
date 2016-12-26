@extends('main')

@section('title', 'Error 502 - Bad Gateway')

@section('content')

@include('partials._error', array('errorcode' => 'Error 404', 'errormessage' => 'De srver kon je verzoek niet afwerken', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection