<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Resin - Generate Resolver import files</title>

    {!! HTML::style('css/bootstrap.min.css') !!}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Objects <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/object">All objects</a></li>
                <li><a href="/object/with-pid">Objects with PID</a></li>
                <li><a href="/object/without-pid">Objects without PID</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Documents <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/document">All documents</a></li>
                <li><a href="/document/orphans">Orphans</a></li>
              </ul>
            </li>
            <li><a href="/merge">Merge</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/settings/purge">Purge database</a></li>
              </ul>
            </li>
          </ul>
      </div>
    </nav>

    <div class="container">
         @yield('content')
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! Html::script('js/jquery.min.js') !!}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/bootstrap-notify.min.js') !!}
    {!! Html::script('js/autobahn.min.js') !!}
    {!! Html::script('js/scripts.js') !!}
  </body>
</html>
