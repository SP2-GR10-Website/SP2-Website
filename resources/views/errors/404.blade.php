@extends('main')

@section('title', 'Error 404')

@section('content')

@include('partials._error', array('errorcode' => 'Error 404 - Not Found', 'errormessage' => 'Deze pagina bestaat niet', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection