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
}

?>

<html>
<body>
<h1>Authentication service (Intern)</h1>

<?php if (isset($request) && $request->hasError): ?>
<h2>Something went wrong</h2>
<p> <?= $request->getError();  ?>  </p>
<?php endif; ?>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <button type="submit">Log me in!</button>
</form>

<p>Not registred yet ? <a href="register.php">Register me!</a></p>
<p>Log in via <a href="<?= $facebookHelper->getLoginUrl() ?>">Facebook</a> </p>

</body>

    <head>
        <title>Login</title>
    </head>
</html>