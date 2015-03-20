<?php
/**
 * Simple class api request
 * Your can use https://github.com/vipparcel/vipparcel-client-php
 */

class API_Request {

    private static function curl_client($resource, $query = array())
    {
        $c = require '_config.php';
        $ch = curl_init($c['api_url'].$resource.'?authToken='.self::auth_token().'&'.http_build_query($query));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        return json_decode(curl_exec($ch), TRUE);
    }

    public static function is_auth()
    {
        return ! empty($_SESSION['vipparcel_access']);
    }

    public static function user_id()
    {
        return $_SESSION['vipparcel_access']['user_id'];
    }

    public static function auth_token()
    {
        return $_SESSION['vipparcel_access']['access_token'];
    }

    public static function personal_info()
    {
        return self::curl_client('/account/personalInfo/details');
    }

    public static function label()
    {
        return self::curl_client('/shipping/label/getList', array('limit' => 1, 'orderBy' => array('created' => 'desc')));
    }

    public static function balance()
    {
        return self::curl_client('/account/balance/getCurrent');
    }
}