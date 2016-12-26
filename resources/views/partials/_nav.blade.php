<!--       Default Bootstrap Navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          {{-- <a href="/"><div id="groepslogo"></div></a> --}}
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="@yield('activePageHome')"><a href="/">Home <span class="sr-only">(current)</span></a></li>
              <li class="@yield('activePageRoute')"><a href="/route-info">Route-info</a></li>
              <li class="@yield('activePageTrein')"><a href="/trein-info">Trein-info</a></li>
              <li class="@yield('activePageStation')"><a href="/station-info">Station-info</a></li>
              <li class="@yield('activePageContact')"><a href="/contact">Contact us</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>