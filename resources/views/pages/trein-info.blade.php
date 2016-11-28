@extends('main')

@section('title', 'Trein-info')

@section('activePageTrein', 'active')

@section('content')
  <div class="row">
    <div class="linkerdeel col-lg-3">
      <div class="col-lg-10 col-lg-offset-1">
        {!! Form::open(array('route' => 'trein-info.zoek')) !!}
            {{Form::label('treinId', 'Trein ID:')}}
            {{Form::input('text', 'treinId', null, array('class' => 'form-control'))}}

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