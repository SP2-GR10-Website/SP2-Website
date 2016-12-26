@extends('main')

@section('title', 'Error 401')

@section('content')

@include('partials._error', array('errorcode' => 'Error 401 - Unauthorized', 'errormessage' => 'Je hebt geen machtigingen om deze pagina te bezoeken', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/main.js"></script>
@endsection