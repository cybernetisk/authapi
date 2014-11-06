<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 1.0
 * @since 1.0
 */
require_once 'bootstrap.php';

$publicToken = (isset($_GET['token'])) ? $_GET['token'] : '';
$facebookHelper = new \Facebook\FacebookRedirectLoginHelper(\App\Login::getLoginUri(array('request' => 'login', 'method' => 'facebook', 'token' => $publicToken)));

$tryLogin = false;
try
{
    //Login via Facebook
    if(isset($_GET['method']) && $_GET['method'] == 'facebook')
    {
        $tryLogin = true;
        $loginMethod = \App\Login::FACEBOOK_AUTH;
        $loginData = $facebookHelper->getSessionFromRedirect();

    } else if (!empty($_POST)) //Login via InternAuth
    {
        $tryLogin = true;
        $loginMethod = \App\Login::INTERN_AUTH;
        $loginData = $_POST;
    }

}
catch (Exception $e)
{
    //@todo Log
    var_dump('Exception : ' . $e->getMessage());
}

if ($tryLogin === true)
{
    $login = new \App\Login($publicToken, $loginData, $loginMethod);
    $result = $login->authenticate();
    if ($result !== false)
    {
        $user = new \App\User($result);
        $request = new \App\Request($_GET);

        if ($request->getStatusCode() === \App\App::SUCCESS_CODE)
        {
            if ($user->isAuthenticate())
            {
                $request->sendResponse($user);
            }
        }

    }

    //Error gestion
    $errors = true;
    if (isset($request))
        $errorMessage = $request->getError();
    else
        $errorMessage = "Unable to find user or user/password don't match.";

}

?>
<html lang="en">

    <?= \App\Page::getHeader() ?>

<body>

    <?= \App\Page::getNavBar() ?>


<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="panel panel-primary primary-form">
                <div class="panel-heading">
                    <div class="panel-title">WebLogin</div> Login service for CyB-Services.
                </div>

                <div class="panel-body">

                    <?php if (isset($errors)): ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-lg-12 alert-danger">
                                <span class="label label-danger">Error</span> <?= $errorMessage;  ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 separator">
                            <h5>Use social medias to connect</h5>

                            <a href="<?= $facebookHelper->getLoginUrl() ?>" class="btn facebook btn-block" role="button">Log in using Facebook</a>
                            <br />
                            <a href="#" class="btn twitter btn-block" role="button">Log in using Twitter</a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 login-box">
                            <form id="internAuthForm" role="form" name="internauth" action="login.php?method=internauth&token=<?= $publicToken ?>" method="post">

                                <h5>Or use CyB Intern Authentication Service</h5>

                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input name="username" type="text" class="form-control" placeholder="Username" required autofocus />
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input name="password" type="password" class="form-control" placeholder="Password" required />
                                </div>

                                <a href="#">Lost your password?</a> <br />
                                Don't have an account? <a href="register.php">Sign up here</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-11 col-sm-12 col-md-12 text-right">
                            <button id="loginButton" type="submit" class="btn btn-labeled btn-success">
                                <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Success</button>
                            <button id="resetButton" type="reset" class="btn btn-labeled btn-danger">
                                <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container -->

    <?= \App\Page::getFooter('login'); ?>
</body>
</html>