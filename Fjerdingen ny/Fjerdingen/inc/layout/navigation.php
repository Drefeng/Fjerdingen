<section id="header">
  <header>
    <div class="container">
      <a href="?p=main"><img src="img/westerdals_logo.png" id="logo" ></a>
    </div>
    <div class="container">
      <a href="?p=main"><img src="img/Fjerdingen1.png" id="campus"></a>
    </div>



    <!--Menubar-->

  <div class="navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="?p=main">Hjem</a></li>
        <li class="dropdown">Ansatt info</a>
          <ul class="drop-cont">
            <li><a href="">Bygginformasjon</a></li>
            <li><a href="">Samarbeidsmuligheter</a></li>
          </ul>
        </li>
        <li class="dropdown">Student info</a>
          <ul class="drop-cont">
            <li><a href="">Bygginformasjon</a></li>
            <li><a href="">Samarbeidsmuligheter</a></li>
          </ul>
        </li>
        <li><a href="?p=linje-oversikt">Linje oversikt</a></li>
        <li><a href="?p=kart">Kart</a></li>
        <li><a href="?p=forum">Forum</a></li>
      </ul>

    <?php if(!authenticated(array("user", "admin"))): ?>
    <form class="navbar-form navbar-right" role="form" method="post" action="?auth=login">
      <div class="form-group">
        <input id="username" name="username" type="text" placeholder="Brukernavn" class="form-control">
      </div>
      <div class="form-group">
        <input id="password" name="password" type="password" placeholder="Passord" class="form-control">
      </div>
      <button id="login" type="submit" class="btn btn-success">Logg inn</button>
    </form>
    <?php else: ?>
    <div class="pull-right">
       <ul class="nav navbar-nav">
          <li><a href="?auth=logout">Logg ut</a></li>
       </ul>
    </div>
    <?php endif; ?>
  </header>
  </div>
</section><!--/.navbar-collapse -->
