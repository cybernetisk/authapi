<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

class Mail
{

    protected $transport;

    protected $message;

    public function __construct()
    {
        $this->transport = new Sendmail();
        $this->message = new Message();

        $mailConfig = \App\Config::getInstance()->getConfig("mail");
        $this->message->addFrom($mailConfig['from']['email'], $mailConfig['from']['name'])
                      ->addReplyTo($mailConfig['replyto'])
                      ->setEncoding($mailConfig['encoding']);

        return $this;
    }

    public function sendMessage($email, $subject, $body)
    {
        $this->message->addTo($email)
                      ->setSubject($subject)
                      ->setBody($body);

        $this->transport->send($this->message); //@todo
        return true;
    }

} 