<?php

namespace Source\Support;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Mail Source\Support
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Support
 */
class Mail
{
    /** @var bool Autenticação smtp */
    private const SMTP_AUTH = true;

    /** @var string Smtp Secure */
    private const SMTP_SECURE = "tls";

    /** @var int Porta smtp */
    private const PORT = 587;

    public static function loadTemplateConfirmEmail(array $data)
    {
        $html = file_get_contents($data["url"]);
        if (!$html) {
            throw new \Exception("Erro ao carregar template de e-mail");
        }

        $html = str_replace(['{{ name }}', '{{name}}'], $data['name'], $html);
        $html = str_replace(['{{ email }}', '{{email}}'], $data['email'], $html);
        $html = str_replace(['{{ link }}', '{{link}}'], $data['link'], $html);
        return $html;
    }

    private static function verifyRequiredKeys(array $array)
    {
        $requiredKeys = ["emailFrom", "nameFrom", "emailTo", "nameTo", "body", "subject"];
        foreach ($requiredKeys as $value) {
            if (!array_key_exists($value, $array)) {
                return false;
            }
        }
        return true;
    }

    public static function sendEmail(array $data)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = HOST;
        $mail->SMTPAuth = self::SMTP_AUTH;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = self::SMTP_SECURE;
        $mail->Port = self::PORT;

        if (!self::verifyRequiredKeys($data)) {
            throw new \Exception("Erro nas chaves obrigatórias.");
        }

        extract($data);
        $mail->setFrom($emailFrom, $nameFrom);
        $mail->addAddress($emailTo, $nameTo);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!$mail->send()) {
            throw new \Exception("Mail Error: " . $mail->ErrorInfo);
        }
    }
}
