<?php
namespace Source\Support;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Mail Source\Support
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Support
 */
class Mail
{
    /** @var PHPMailer */
    private PHPMailer $mail;

    /** @var string Host smtp */
    private const HOST = HOST;

    /** @var bool Autenticação smtp */
    private const SMTP_AUTH = true;

    /** @var string Username */
    private const USERNAME = USERNAME;

    /** @var string Password */
    private const PASSWORD = PASSWORD;

    /** @var string Smtp Secure */
    private const SMTP_SECURE = "tls";

    /** @var int Porta smtp */
    private const PORT = 587;

    /**
     * Mail constructor
     */
    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = self::HOST;
        $this->mail->SMTPAuth = self::SMTP_AUTH;
        $this->mail->Username = self::USERNAME;
        $this->mail->Password = self::PASSWORD;
        $this->mail->SMTPSecure = self::SMTP_SECURE;
        $this->mail->Port = self::PORT;
    }

    public function loadEmailTemplate(array $data)
    {
        $html = file_get_contents($data["url"]);
        if (!$html) {
            throw new \Exception("Erro ao carregar template de e-mail");
        }

        $html = str_replace(['{{ name }}', '{{name}}'], $data['name'], $html);
        $html = str_replace(['{{ email }}', '{{email}}'], $data['email'], $html);
        return $html;
    }

    private function verifyRequiredKeys(array $array)
    {
        $requiredKeys = ["emailFrom", "nameFrom", "emailTo", "nameTo", "body", "subject"];
        foreach ($requiredKeys as $value) {
            if (!array_key_exists($value, $array)) {
                return false;
            }
        }
        return true;
    }

    public function confirmEmailData(array $data)
    {
        if ($this->mail instanceof PHPMailer) {

            if (!$this->verifyRequiredKeys($data)) {
                throw new \Exception("Erro nas chaves obrigatórias.");
            }
            
            extract($data);
            $this->mail->setFrom($emailFrom, $nameFrom);
            $this->mail->addAddress($emailTo, $nameTo);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            if (!$this->mail->send()) {
                throw new \Exception("Mail Error: " . $this->mail->ErrorInfo);
            }
            
        }
    }
}
