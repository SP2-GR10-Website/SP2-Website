@extends('main')
@section('title', 'Route-info')
@section('activePageRoute', 'active')
@section('content')
<div class="maincontent" id="route-info">
    <div class="linkerdeel">
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
    <div class="rechterdeel" id="rechterdeelId">
        <div id="routeCont">
        <div class="route">
            <div class="routeInfo">
              <div class="routeInfo-vertrek">Vilvoorde</div>
              <div class="routeInfo-vertrek-info">
                <div>Uur: 13u52</div>
                <div>Perron: 5</div>
              </div>
              
              <div class="routeInfo-pijltje"></div>
              <div class="routeInfo-aankomst">Oostende</div>
              <div class="routeInfo-aankomst-info">
                <div>Uur: 13u52</div>
                <div>Perron: 5</div>
              </div>
              <div class="routeInfo-duration">Duur<br>2:13:51</div>
              <div class="routeInfo-overstappen">Overstappen<br>2</div>
              <div class="routeInfo-dropdown">
                <div class="routeInfo-dropdown-img"></div>
              </div>
            </div>
            <div class="overstappen">
              <div class="overstap">
                <div class="overstap-cel">
                  <div class="overstap-halte">Mechelen</div>
                </div>
                <div class="overstap-cel overstap-cel-midden">
                  <div class="overstap-titel">Aankomst (S 301)</div>
                  <div class="overstap-info">Uur: 15u52</div>
                  <div class="overstap-info">Perron: 4</div>
                </div>
                <div class="overstap-cel">
                  <div class="overstap-titel">Vertrek (P 301)</div>
                  <div class="overstap-info">Uur: 15u58</div>
                  <div class="overstap-info">Perron: 6</div>
                </div>
              </div>
              
              <div class="overstap">
                <div class="overstap-cel">
                  <div class="overstap-halte">Antwerpen</div>
                </div>
                <div class="overstap-cel overstap-cel-midden">
                  <div class="overstap-titel">Aankomst (IC 301)</div>
                  <div class="overstap-info">Uur: 16:32</div>
                  <div class="overstap-info">Perron: 7</div>
                </div>
                <div class="overstap-cel">
                  <div class="overstap-titel">Vertrek (S 301)</div>
                  <div class="overstap-info">Uur: 16:55</div>
                  <div class="overstap-info">Perron: 69</div>
                </div>
              </div>

            </div>
          </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
  <script src="/js/pages/route-info.js"></script>
@endsection