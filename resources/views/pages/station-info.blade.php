@extends('main')

@section('title', 'Station-info')

@section('activePageStation', 'active')

@section('content')
<div class="container-fluid" id="station-info">
  <div class="row">
    <div class="linkerdeel">
      <div>
         <form>
            <label for="name">Station:</label>
            <select id="name"></select>
            <br>
            <label for="treinTijd">Tijdstip:</label>
            <input class="form-control" name="treinTijd" type="datetime-local" id="treinTijd">
        </form>
       <div class="btn btn-success zoekBtn btn-block" onclick="getStation('initialise')">Zoek</div>
      </div>
    </div>
    <div class="rechterdeel" id="rechterdeelId">
      <div id="treinen">
        
      </div>
      <div id="extraTreinenBtnCont"></div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="/js/pages/station-info.js"></script>
@endsection