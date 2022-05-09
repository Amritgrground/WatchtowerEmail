<?php
session_start();

class oAuthService {
    private static $clientId = "YOUR CLIENT ID HERE";
    private static $clientSecret = "YOUR CLIENT SECRET HERE";
    private static $authority = "https://login.microsoftonline.com";
    private static $authorizeUrl = '/common/oauth2/authorize?client_id=%1$s&redirect_uri=%2$s&response_type=code';
    private static $tokenUrl = "/common/oauth2/token";

    public static function getLoginUrl($redirectUri) {
        $loginUrl = self::$authority.sprintf(self::$authorizeUrl, self::$clientId, urlencode($redirectUri));
        error_log("Generated login URL: ".$loginUrl);
        return $loginUrl;
    }
}
?>
