@extends('main')

@section('title', 'Trein-info')

@section('activePageTrein', 'active')

@section('content')
<div class="maincontent" id="trein-info">
    <div class="linkerdeel">
      <div>
        <form>
            <label for="name">Trein ID:</label>
            <input class="form-control" type="text" id="treinId">
        </form>
        <div class="btn btn-success zoekBtn btn-block" onclick="getTrein()">Zoek</div>
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