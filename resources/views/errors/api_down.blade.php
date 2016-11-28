@extends('main')

@section('title', 'Website niet beschikbaar')

@section('content')


@include('partials._error', array('errorcode' => 'Error - Website niet beschikbaar', 'errormessage' => "Er kon geen verbinding worden vastgelegd met <a class='errorlink' href='$url'>$shorturl</a>" , 'errorsmiley' => ':/'))

@endsection


@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection