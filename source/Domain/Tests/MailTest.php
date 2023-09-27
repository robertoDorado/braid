<?php

namespace Source\Domain\Tests;

use Source\Support\Mail;

require __DIR__ . "../../../../vendor/autoload.php";

/**
 * MailTest Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class MailTest
{
    /**
     * MailTest constructor
     */
    public function __construct()
    {
        Mail::sendEmail([
            "emailFrom" => "no-reply@braid.com", "nameFrom" => "Braid.pro",
            "emailTo" => "robertodorado7@gmail.com", "nameTo" => "Roberto Felipe Dorado Pena",
            "body" => Mail::loadTemplateConfirmEmail([
                "url" => __DIR__ . "./../../../themes/braid-theme/mail/confirm-email.php",
                "name" => "Roberto Felipe Dorado Pena",
                "email" => "robertodorado7@gmail.com",
                "link" => url("/user/email-confirmed?dataMail=" . base64_encode("robertodorado7@gmail.com") . "")
            ]),
            "subject" => iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Confirmação de e-mail")
        ]);
    }
}

new MailTest();