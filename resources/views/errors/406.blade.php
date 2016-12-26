@extends('main')

@section('title', 'Error 406')

@section('content')

@include('partials._error', array('errorcode' => 'Error 406 - Not Acceptable', 'errormessage' => 'De server heeft je verzoek niet kunnen verwerken', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection