@extends('main')

@section('title', 'Home')

@section('activePageHome', 'active')

@section('content')
<div class="maincontent">
  <div class="jumbotron" style="background-color:white">
   <h1 class="text-center">Welkom</h1>
   <p class="text-center">bij deftigeNMBS.be</p>
  </div>
  <hr>
  <div class="col-lg-10 col-lg-offset-1 text-center">
    <a href="/route-info">
      <div class="homeWell well">
        <h2>Route-info</h2>
        <p>Hier vind je info over de routes, zoals welke trein je moet nemen, wanneer deze toekomt op welk station en op welk perron dit zal zijn.</p>
      </div>
    </a>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">
    <a href="/trein-info">
      <div class="homeWell well">
        <h2>Trein-info</h2>
        <p>Alle info in verband met treinen vind je hier. Het nummer, type en welke routes ze afleggen zijn voorbeelden.</p>
      </div>
    </a>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">
  <a href="/station-info">
    <div class="homeWell well">
      <h2>Station-info</h2>
      <p>Hier kan je alle treinen raadplegen dat in een station naar keuze stoppen, alsook op welk perron en waar ze nog naartoe gaan.</p>
    </div>
    </a>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">
  <a href="/tarieven">
    <div class="homeWell well">
      <h2>Tarieven</h2>
      <p>Hier vind je alle info m.b.t. de tarieven en hoe deze berekend worden.</p>
    </div>
    </a>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">
  <a href="/contact">
    <div class="homeWell well">
      <h2>Contact us</h2>
      <p>Heb je een voorstel? Een vraag? Of letterlijk eendert wat? Aarzel niet om ons te contacteren.</p>
    </div>
    </a>
  </div>
</div>    
@endsection

@section('scripts')
  <script src="/js/pages/home.js"></script>
@endsection