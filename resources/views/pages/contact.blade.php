@extends('main')

@section('title', 'Contact us')

@section('activePageContact', 'active')

@section('content')





<div class="container" id="contact">
  <div class="jumbotron" style="background-color:white">
   <h1 class="text-center">Contact us</h1>
   <p class="text-center">Heb je vragen of opmerkingen? Laat het ons zeker weten!</p>
  </div>
  <hr>
  <div class="col-lg-10 col-lg-offset-1 text-center">
      <div class="infoErasmus">
      <h2>Erasmus Hogeschool Brussel</h2>
      <div class="adres">
        <p>Kampus Kaai</p>
        <p>Nijverheidskaai 170</p>
        <p>1070 Anderlecht</p>
        </div>
        </div>
        <div id="apiGoogle" style="width: 400px;height: 400px">
        </div>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">

  <div class="formCss">
       
        <h2>Contacteer ons</h2>
  <form id="contactUs" method="post">
     <div class="labelContact">
        <label for="name">Naam:</label>
     </div>
     <div class="inputContact">
       <input id="name" class="input" name="name" type="text" value="" size="30"/>
     </div>
  <div class="labelContact">
        <label for="email">Email:</label>
    </div>
    <div class="inputContact">
        <input id="email" class="input" name="email" type="text" value="" size="30"/>
    </div>
  <div class="labelContact">
    <label for="message">Bericht:</label>
    </div>
    <div class="inputContact">
       <textarea id="message" class="input" name="message" rows="7" cols="30"></textarea>
       </div>
    <div class="inputContact">
   <input id="submit_button" type="submit" value="Verzenden" onclick="IsEmpty()" />
   </div>

    </form> 
        </div>
    <div class="ontwikkelaars">
        <div class="headerOntwik">
            <h2>Ontwikkelaars:</h2>
            </div>
            <div class="ontwikkelaarsText">
      <p>Wij zijn een groep studenten aan de Erasmus Hogeschool die als school opdracht een werkende Java-applicatie en Php Laravel website voor de NMBS moeten maken. We moeten een Java-applicatie maken die het personeel van de NMBS kan gebruiken om treinen,stations en routes op te vragen. Deze informatie kan dan gebruikt worden om een ticket voor een klant te kopen. De website moet aan de hand van een api van de NMBS realtime routes,stations en treinen kunnen opvragen. Als u nog vragen heeft kan u deze altijd vragen via het contact formulier.</p><br>
      </div>
       <div class="headerOntwik">
     <h2>Het ontwikkelingsteam</h2>
     </div>
     <div class="ontwikkelaarsText">
     <p> Rik, Manish, Dietger, Nofel, Robbe en Thibaut </p>
</div>

      </div>
  </div>
</div>  
@endsection
 
@section('scripts')
  <script src="/js/pages/contact.js"></script>
@endsection