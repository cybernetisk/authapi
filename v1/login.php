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
if (!empty($_POST))
{
    $login = new \App\Login($_POST);
    $result = $login->authenticate();
    if ($result !== false)
    {
        $user = new \App\User($result);
    }
}

?>

<html>
    <head>
        <title>Login</title>
    </head>

    <body>
        <h1>Authentication service</h1>

        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="login" id="username">

            <label for="password">Password:</label>
            <input type="password" name="password" id="password">

            <button type="submit">Log me in!</button>
        </form>
    </body>
</html>