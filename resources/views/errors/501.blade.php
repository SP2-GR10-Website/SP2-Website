@extends('main')

@section('title', 'Error 501')

@section('content')

@include('partials._error', array('errorcode' => 'Error 501 - Not Implemented', 'errormessage' => 'De server ondersteunt verzoeken van jouw soort niet', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection