<?php

require_once __DIR__ . '/../phpmailer/src/Exception.php';
require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class clsMailer
{
  public static function enviarCodigo($correo, $nombre, $codigo)
  {
    $mail = new PHPMailer(true);

    try {

      $mail->SMTPDebug = 2;
      $mail->Debugoutput = function ($str, $level) {
        error_log("SMTP DEBUG [$level]: $str");
      };

      $mail->isSMTP();
      $mail->Host = "cobranzasperu.com";
      $mail->SMTPAuth = true;
      $mail->Username = "asistencia@cobranzasperu.com";
      $mail->Password = "6#2(Osd04f8+";

      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = 465;

      $mail->CharSet = "UTF-8";

      $mail->setFrom(
        "asistencia@cobranzasperu.com",
        "Cobranzas Perú"
      );

      if (empty($correo)) {
        throw new Exception("Correo destino vacío");
      }

      $mail->addAddress($correo);

      $mail->isHTML(true);

      $mail->Subject = "Código de verificación - Cobranzas Perú";

      $mail->Body = "
                Hola {$nombre},<br><br>
                Tu código de verificación para CYC WEB ADMIN es:<br><br>
                <div style='
                    font-size:24px;
                    font-weight:bold;
                    color:#860404;
                    letter-spacing:3px;
                '>
                    {$codigo}
                </div>
                <br>
                Este código vence en 10 minutos.
            ";

      if (!$mail->send()) {

        error_log("MAIL ERROR: " . $mail->ErrorInfo);

        return false;
      }

      error_log("MAIL OK: enviado a " . $correo);

      return true;
    } catch (Exception $e) {

      error_log("MAIL EXCEPTION: " . $e->getMessage());

      return false;
    }
  }
}
