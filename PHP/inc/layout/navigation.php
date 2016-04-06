<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">TN</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MooCaMaster</a>
    </div>
    <div class="navbar-collapse collapse">
      <div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="?p=main">Hjem</a></li>
          <li><a href="?p=user">Min side</a></li>
          <li><a href="?p=admin">Administrasjon</a></li>
        </ul>
      </div>
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
    </div><!--/.navbar-collapse -->
  </div>
</div>
