@extends('main')

@section('title', 'Contact us')

@section('activePageContact', 'active')

@section('content')


<div class="container" id="contact">
  <div class="jumbotron" style="background-color:white">
   <h1 class="text-center">Contact us</h1>
   <p class="text-center">Heb je vragen of opmerkingen laat het ons zeker weten!</p>
  </div>
  <hr>
  <div class="col-lg-10 col-lg-offset-1 text-center">
      <div class="infoErasmus">
      <h2>Erasmus Hogeschool Brussel</h2>
        <p>Kampus Kaai</p>
        <p>Nijverheidskaai 170</p>
        <p>1070 Anderlecht</p>
        </div>
        <div id="apiGoogle" style="width: 400px;height: 400px">
          
        </div>
  </div>
  <div class="col-lg-10 col-lg-offset-1 text-center">
      <div class="formCss">
        <h2>Contacteer ons</h2>
        <form name='contactUs'>
       		Naam:
       		<textarea rows="1">Uw Naam</textarea><br>
      	 	E-Mail:
      	 	<textarea rows="1">Uw Email</textarea><br>
      	 	Boodschap:
      	 	<textarea rows="4" cols="20">Uw Boodschap</textarea><br>     		
             <input type="submit" value="Verzenden">
        </form>
        </div>
        <div class="ontwikkelaars">
            <h2>Ontwikkelaars:</h2>
      <p>Rik,Manish,Nofel,Dietger,Robbe,Thibaut</p>
      </div>
  </div>
</div>  
@endsection
 
@section('scripts')
  <script src="/js/pages/contact.js"></script>
@endsection