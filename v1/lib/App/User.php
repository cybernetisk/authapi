<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

class User
{
    protected $db;

    protected $userData = array();

    public function __construct($userId = false)
    {

        $this->db = DatabaseFactory::getInstance()->getDb();

        if ($userId !== false)
            $this->loadUserByUserId($userId);
    }

    //@todo
    public function isAuthenticate()
    {
        return !empty($this->userData);
    }

    public function getUserId()
    {
        return $this->userData['id'];
    }

    public function register($userData = array())
    {
        $validationKey = $this->generateKey();

        $sqlRequest = $this->db->prepare("INSERT INTO users (username, email, validateKey) VALUES (:username, :email, :key)");
        $return = $sqlRequest->execute(array(
            ':username' => $userData['username'],
            ':email' => $userData['email'],
            ':key' => $validationKey,
        ));

        if ($return === false) //@todo
            return false;

        $this->userData = $userData;

        return $validationKey;
    }

    public function sendRegisterMail($validationKey)
    {
        $activationLink = App::getPageUri('register', array('mode' => 'activate', 'key' => $validationKey));
        $mailBody = Page::getTemplate('mailRegister');

        $mail = new Mail();
        $mail->sendMessage($this->userData['email'], "Register on CyB CAS", $mailBody);

    }

    public function validate()
    {

    }

    public function uniqueValueForField($field, $value)
    {
        $sqlRequest = $this->db->prepare("SELECT id FROM users WHERE `{$field}` = ? LIMIT 1");
        var_dump($sqlRequest);
        $sqlRequest->execute(array($value));

        $result = $sqlRequest->fetch(\PDO::FETCH_ASSOC);
        return !is_bool($result);
    }

    protected function loadUserByUserId($userId)
    {
        $sqlRequest = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $sqlRequest->execute(array($userId));

        $result = $sqlRequest->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) //@todo Exception
            return false;

        $this->userData = $result;
    }

    protected function generateKey()
    {
        return substr(uniqid() . uniqid(), 1, 32);
    }


} 