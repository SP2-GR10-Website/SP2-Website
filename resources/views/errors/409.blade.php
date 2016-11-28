@extends('main')

@section('title', 'Error 409')

@section('content')

@include('partials._error', array('errorcode' => 'Error 409 - Conflict', 'errormessage' => 'Er is een conflict opgetreden m.b.t. de status van de server', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection