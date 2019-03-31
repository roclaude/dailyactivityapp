<?php require_once(dirname(__FILE__) . "/functions.php"); ?>

<?php
    if ($user->is_loggedin()) {
        header('Location: index.php');
        exit();
    }

    $page_title = "Login" . ( defined('SITE_NAME') ? ' | ' . SITE_NAME : null );
?>

<?php include_once( BASE_PATH . "/templates/header.php" ); ?>

    <div class="login-form-panel">
        <div class="panel panel-default">
            <div class="panel-body">

                <form action="<?= BASE_URL ?>/includes/login.php" method="POST">
                    <?php if ( isset($_GET["error"]) && !empty($_GET["error"]) ) : ?>
                        <div class="alert alert-danger" role="alert">Invalid username or password!</div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="userEmail">Email address:</label>
                        <input type="email" name="useremail" id="userEmail" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" name="userpass" id="userPassword" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="rememberme" class="form-check-input" id="rememberMe" value="1">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
        <p class="text-center">user@test.com / password</p>
        <p class="text-center">leader@test.com / password</p>
    </div>

<?php include_once( BASE_PATH . "/templates/footer.php" ); ?>
