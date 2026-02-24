<?php

class clsCaptcha
{
  public static function verificar($token, $ip)
  {
    /* SECRET KEY INCRUSTADO */
    $secret = "6Lcs1swrAAAAACtYpT1dpVRu9jRbKuyOeqdTO0y6";

    if (!$token)
      return false;

    $data = http_build_query([
      "secret"   => $secret,
      "response" => $token,
      "remoteip" => $ip
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
