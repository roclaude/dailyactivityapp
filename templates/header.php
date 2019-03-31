<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $page_title ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="<?=STYLE_ROOT?>styles.css">
  </head>
  <body>

    <?php if ( $user->is_loggedin() ) : ?>
      <nav class="navbar navbar-default">
        <div class="container-fluid">

          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <?php if ( defined('SITE_NAME') ) :?>
              <a class="navbar-brand" href="<?= defined('BASE_URL') ? ( BASE_URL . "/dashboard.php?uid=" . $user->__get( "id" ) ) : null ?>"><?= SITE_NAME ?></a>
            <?php endif; ?>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li <?= $page == 'dashboard' ? 'class="active"' : '' ?>>
                <a href="<?= defined('BASE_URL') ? BASE_URL : null ?>/dashboard.php?uid=<?= $user->__get("id") ?>">
                  Dashboard
                </a>
              </li>
              <li <?= $page == 'team' ? 'class="active"' : '' ?>>
                <a href="<?= defined('BASE_URL') ? BASE_URL : null ?>/dashboard.php">
                  My team
                </a>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              
              <?php if ( $user->is_loggedin() ) : ?>

                <li>
                  <a>
                    <?= "Hi, " . $user->__get( "firstname" ); ?>
                  </a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?= defined('BASE_URL') ? BASE_URL : null ?>/includes/logout.php">Log out</a></li>
                  </ul>
                </li>

              <?php else: ?>
                
                <li>
                  <a href="<?= defined('BASE_URL') ? BASE_URL : null ?>/login.php">
                    Login
                  </a>
                </li>

              <?php endif; ?>

            </ul>
          </div>

        </div>
      </nav>
    <?php endif; ?>