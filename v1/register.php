<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

require_once 'bootstrap.php';

$_POST['email'] = 'darkamaul@hotmail.fr'; $_POST['username'] = 'Darka';

if (!empty($_POST))
{
    $errorMessageArray = array();
    $cleanPost = array();

    if (isset($_POST['email']))
    {
        $emailValidator = new \Zend\Validator\EmailAddress();

        if ($emailValidator->isValid($_POST['email']))
            $cleanPost['email'] = $_POST['email'];
        else
            array_merge($errorMessageArray, $emailValidator->getMessages());


    } else
        $errorMessageArray[] = 'E-mail field is required.';

    if (isset($_POST['username']))
    {
        $usernameValidator = new \Zend\Validator\StringLength(array('min' => 4, 'max' => 25));

        if ($usernameValidator->isValid($_POST['username']))
            $cleanPost['username'] = $_POST['username'];
        else
            array_merge($errorMessageArray, $usernameValidator->getMessages());

    } else
        $errorMessageArray[] = 'Username field is required.';

    if (empty($errorMessageArray))
    {
        $user = new \App\User();
        $error = $user->uniqueValueForField('username', $cleanPost['username'])
              && $user->uniqueValueForField('email', $cleanPost['email']);

        if ($error === false)
        {
            $userKey = $user->register($cleanPost);
            $user->sendRegisterMail($userKey);

        } else
            $errorMessageArray[] = 'Existing email or username.';

    }
}

?>

<html lang="en">

    <?= \App\Page::getHeader() ?>

<body>

    <?= \App\Page::getNavBar(); ?>


    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <div class="panel panel-primary primary-form">
                    <div class="panel-heading">
                        <div class="panel-title">Register</div> Register to access CyB-Services.
                    </div>

                    <div class="panel-body">
                        <div class="alert alert-info">
                            <span><strong>How it works ?</strong> There is a few steps to go through the registration.</span>

                            <ol>
                                <li>Register on the plateform.</li>
                                <li>Validate your account</li>
                                <li>Link your account to one (or more) authentication method</li>
                            </ol>
                        </div>

                        <?php if (isset($errorMessageArray) && !empty($errorMessageArray)): ?>
                        <div class="alert alert-danger" role="alert">
                            <span><strong>An error occurred during registration</strong></span>
                            <ul>
                                <?php foreach ($errorMessageArray as $errorMessage): ?>
                                    <li><?= $errorMessage ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($error) && $error === false): ?>
                            <div class="alert alert-success" role="alert">
                                <strong>User registered</strong>
                                An email has been send to your e-mail address in order to confirm it.
                            </div>
                        <?php endif; ?>

                        <form id="registerForm" role="form" action="register.php" method="post">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input name="username" type="text" class="form-control" placeholder="Tux" required autofocus />
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input name="email" type="email" class="form-control" placeholder="penguin@escape.no" required />
                            </div>
                        </form>


                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-11 col-sm-12 col-md-12 text-right">
                                <button id="registerButton" type="submit" class="btn btn-labeled btn-success">
                                    <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Register me!</button>
                                <button id="resetButton" type="reset" class="btn btn-labeled btn-danger">
                                    <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->


    <?= \App\Page::getFooter('register'); ?>
</body>
</html>