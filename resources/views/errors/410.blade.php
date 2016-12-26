@extends('main')

@section('title', 'Error 410')

@section('content')

@include('partials._error', array('errorcode' => 'Error 410 - Gone', 'errormessage' => 'De gevraagde bron is niet langer meer beschikbaar', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection