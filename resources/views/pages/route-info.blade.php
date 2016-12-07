@extends('main')
@section('title', 'Route-info')
@section('activePageRoute', 'active')
@section('content')
<div class="container-fluid" id="route-info">
  <div class="row">
    <div class="linkerdeel col-lg-3">
      <div class="col-lg-10 col-lg-offset-1">
       <form>
            <label for="vertrek">Vertrek:</label>
            <select id="stepOn"></select>
            <br>
             <label for="aankomst">Aankomst:</label>
            <select id="stepOff"></select>
            <br>
            <label for="treinTijd">Tijdstip:</label>
            <input class="form-control" name="treinTijd" type="datetime-local" id="treinTijd">
        </form>
         <div class="btn btn-success zoekBtn btn-block" onclick="getRoute()"> Zoek</div>
      </div>
    </div>
    <div class="rechterdeel" id="rechterdeelId">

    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="/js/pages/route-info.js"></script>
@endsection