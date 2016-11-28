@extends('main')

@section('title', 'Error 503')

@section('content')

@include('partials._error', array('errorcode' => 'Error 503 - Service Unavailable', 'errormessage' => 'De server is tijdelijk niet beschikbaar', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection