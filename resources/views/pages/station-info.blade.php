@extends('main')

@section('title', 'Station-info')

@section('activePageStation', 'active')

@section('content')
<div class="maincontent" id="station-info">
    <div id="linkerdeel-hamburger" onclick="toonLinkerdeel()"></div>
    <div class="linkerdeel">
      <div>
         <form>
            <label class="linkerdeel-label" for="name">Station</label>
             <input class="linkerdeel-input" id="name">
            <br>
            <label class="linkerdeel-label" for="treinTijd">Tijdstip</label>
            <input class="form-control linkerdeel-input" name="treinTijd" type="datetime-local" id="treinTijd">
        </form>
       <div class="linkerdeel-submit" onclick="getStation('initialise')">Zoek</div>
      </div>
    </div>
    <div class="rechterdeel" id="rechterdeelId">
      <div id="treinen">
        
      </div>
      <div id="extraTreinenBtnCont"></div>
    </div>
</div>
@endsection

@section('scripts')
  <script src="/js/pages/station-info.js"></script>
@endsection