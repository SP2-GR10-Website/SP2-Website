@extends('main')

@section('title', 'Error 411')

@section('content')

@include('partials._error', array('errorcode' => 'Error 411 - Length Required', 'errormessage' => 'Er is een probleem opgetreden bij de server', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection