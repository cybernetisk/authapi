<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 1.0
 * @since 1.0
 */
require_once 'bootstrap.php';

//$_POST['username'] = 'DarkaMaul'; $_POST['password'] = 'test';

$publicToken = (isset($_GET['token'])) ? $_GET['token'] : '';
$facebookConnexion = new \App\Auth\Facebook($publicToken);

$tryLogin = false;

//Login via Facebook
if($facebookConnexion->helper->getSessionFromRedirect() instanceof \Facebook\FacebookSession)
{
    $tryLogin = true;
    $loginMethod = \App\Login::FACEBOOK_AUTH;
    $loginData = $facebookConnexion->helper->getSessionFromRedirect();

    var_dump($loginData);

} else if (!empty($_POST)) //Login via InternAuth
{
    $tryLogin = true;
    $loginMethod = \App\Login::INTERN_AUTH;
    $loginData = $_POST;
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

<?php if (isset($request)): ?>
<h2>Something went wrong</h2>
<p> <?= $request->getData(array());  ?>  </p>
<?php endif; ?>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="login" id="username">

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <button type="submit">Log me in!</button>
</form>

<p>Not registred yet ? <a href="register.php">Register me!</a></p>
<p>Log in via <a href="<?= $facebookConnexion->getLoginUri() ?>">Facebook</a> </p>

</body>

    <head>
        <title>Login</title>
    </head>
</html>