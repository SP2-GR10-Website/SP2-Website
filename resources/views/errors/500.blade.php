@extends('main')

@section('title', 'Error 500')

@section('content')

@include('partials._error', array('errorcode' => 'Error 500 - Internal Server Error', 'errormessage' => 'De server heeft een intern probleem opgelopen', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection