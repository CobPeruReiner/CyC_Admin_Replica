<?php
class clsOtp
{
  const TTL = 600; // 10 minutos
  const MAX_ATTEMPTS = 5;

  public static function generar()
  {
    return strval(rand(100000, 999999));
  }

  public static function guardar($usuario, $otp)
  {
    if (session_status() === PHP_SESSION_NONE)
      session_start();

    $_SESSION["otp_by_user"][$usuario] = [
      "hash" => hash("sha256", $otp),
      "expires" => time() + self::TTL,
      "attempts" => 0
    ];
  }

  public static function verificar($usuario, $otp)
  {
    if (session_status() === PHP_SESSION_NONE)
      session_start();

    if (!isset($_SESSION["otp_by_user"][$usuario]))
      return false;

    $data = $_SESSION["otp_by_user"][$usuario];

    if (time() > $data["expires"]) {
      unset($_SESSION["otp_by_user"][$usuario]);
      return false;
    }

    $data["attempts"]++;

    if ($data["attempts"] > self::MAX_ATTEMPTS) {
      unset($_SESSION["otp_by_user"][$usuario]);
      return false;
    }

    $hash = hash("sha256", $otp);

    if ($hash !== $data["hash"]) {
      $_SESSION["otp_by_user"][$usuario] = $data;
      return false;
    }

    unset($_SESSION["otp_by_user"][$usuario]);

    return true;
  }
}
