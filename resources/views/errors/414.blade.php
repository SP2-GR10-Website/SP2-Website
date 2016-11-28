@extends('main')

@section('title', 'Error 414')

@section('content')

@include('partials._error', array('errorcode' => 'Error 414 - Request URL Too Large', 'errormessage' => 'De server kon een URL niet accepteren wegens zijn grootte', 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection