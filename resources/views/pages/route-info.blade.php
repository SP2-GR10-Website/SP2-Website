@extends('main')
@section('title', 'Route-info')
@section('activePageRoute', 'active')
@section('content')
<div class="maincontent" id="route-info">
  <div class="linkerdeel">
       <form>
            <label for="stepOn">Vertrek:</label>
              <input id="stepOn" onclick="autoComplete('stepOn')">
            <br>
             <label for="stepOff">Aankomst:</label>
            <input id="stepOff" onclick="autoComplete('stepOff')">
            <br>
            <label for="treinTijd">Tijdstip:</label>
            <input class="form-control" name="treinTijd" type="datetime-local" id="treinTijd">
        </form>
         <div class="btn btn-success zoekBtn btn-block" onclick="getRoute()"> Zoek</div>
      </div>
    </div>
    <div class="rechterdeel" id="rechterdeelId">
     <div id="routeCont">

     </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="/js/pages/route-info.js"></script>
@endsection