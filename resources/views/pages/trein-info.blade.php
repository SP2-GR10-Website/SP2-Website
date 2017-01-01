@extends('main')

@section('title', 'Trein-info')

@section('activePageTrein', 'active')

@section('content')
<div class="maincontent" id="trein-info">
    <div id="linkerdeel-hamburger" onclick="toonLinkerdeel()"></div>
    <div class="linkerdeel">
      <div>
        <form>
            <label class="linkerdeel-label" for="name">Trein ID</label>
            <input class="form-control linkerdeel-input" type="text" id="treinId">
        </form>
        <div class="linkerdeel-submit" onclick="getTrein()">Zoek</div>
      </div>
    </div>

    <div class="rechterdeel" id="rechterdeelId">
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="/js/pages/trein-info.js"></script>
@endsection