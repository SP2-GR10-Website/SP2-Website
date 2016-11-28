@extends('main')
@section('title', 'Route-info')
@section('activePageRoute', 'active')
@section('content')
  <div class="row">
    <div class="linkerdeel col-lg-3">
      <div class="col-lg-10 col-lg-offset-1">
        {!! Form::open(array('route' => 'route-info.zoek')) !!}
            {{Form::label('stepOn', 'Vertrek:')}}
            {{Form::text('stepOn', null, array('class' => 'form-control'))}}
            <br>
            {{Form::label('stepOff', 'Aankomst:')}}
            {{Form::text('stepOff', null, array('class' => 'form-control'))}}
            <br>
             {{Form::label('treinTijd', 'Tijdstip:')}}
            {{Form::input('datetime-local', 'treinTijd', null, array('class' => 'form-control'))}}
             {{Form::submit('Zoek', array('class' => 'btn btn-success zoekBtn btn-block'))}}
        {!! Form::close() !!}
      </div>
    </div>
    <div class="rechterdeel col-lg-9">
      {!!$data or ""!!}
    </div>
  </div>
@endsection
@section('scripts')
  <script src="/js/website.min.js"></script>
@endsection