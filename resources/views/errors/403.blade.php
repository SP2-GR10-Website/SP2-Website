@extends('main')

@section('title', 'Error 403')

@section('content')

@include('partials._error', array('errorcode' => 'Error 403 - Forbidden', 'errormessage' => 'Je hebt geen machtigingen om deze pagina te bezoeken', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection