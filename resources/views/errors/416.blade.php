@extends('main')

@section('title', 'Error 416')

@section('content')

@include('partials._error', array('errorcode' => 'Error 416 - Requested Range Not Satisfiable', 'errormessage' => 'Het gevraagde deel van de file ligt buiten diens range', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection