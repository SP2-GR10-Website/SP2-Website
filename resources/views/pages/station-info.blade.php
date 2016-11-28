@extends('main')

@section('title', 'Station-info')

@section('activePageStation', 'active')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="linkerdeel">
      <div class="">
        <form>
            <label for="name">Station:</label>
            <input class="form-control" name="name" type="text" id="name">
            <br>
            <label for="treinTijd">Tijdstip:</label>
            <input class="form-control" name="treinTijd" type="datetime-local" id="treinTijd" value="2016-11-28T11:42">
        </form>
        <div class="btn btn-success zoekBtn btn-block" onclick="getTreinen(0)">Zoek</div>
      </div>
    </div>

    <div id="rechterdeelId" class="rechterdeel">
    </div>

    <!---->
  </div>
</div>
@endsection