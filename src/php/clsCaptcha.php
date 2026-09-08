<?php

class clsCaptcha
{
  private static function secret()
  {
    $path = "/run/secrets/recaptcha_secret_key";

    if (!is_readable($path)) {
      return null;
    }

    return trim(file_get_contents($path));
  }

  public static function verificar($token, $ip)
  {
    $secret = self::secret();

    if (!$token || !$secret)
      return false;

    $data = http_build_query([
      "secret"   => $secret,
      "response" => $token
    ]);

    $options = [
      "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "content" => $data,
        "timeout" => 10
      ]
    ];

    $context = stream_context_create($options);

    $result = file_get_contents(
      "https://www.google.com/recaptcha/api/siteverify",
      false,
      $context
    );

    if ($result === false)
      return false;

    $json = json_decode($result, true);

    return isset($json["success"]) && $json["success"] === true;
  }
}
