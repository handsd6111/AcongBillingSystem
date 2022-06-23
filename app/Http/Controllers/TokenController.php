<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Storage;

class TokenController extends Controller
{
    public static function generateJwt(array $payload)
    {
        $privateKey = Storage::disk('local')->get("key/access_rsa");
        $realPrivateKey = <<<EOD
        $privateKey
        EOD;

        $jwt = JWT::encode($payload, $realPrivateKey, 'RS256');
        return $jwt;
    }

    public static function generateRefreshToken()
    {
        $next = now()->timestamp;
        $prev = $next * rand(342498, $next);
        $middle = $next * rand(3428, $next);

        return md5($prev . "g34tgew4g" . $middle) . "." . $next;
    }


    public static function decodeJwt(string $jwt)
    {
        $publicKey = Storage::disk('local')->get("key/access_rsa.pub");
        $realPublicKey = <<<EOD
        $publicKey
        EOD;
        $realPublicKey =
            <<<EOD
            -----BEGIN PUBLIC KEY-----
            MIIBojANBgkqhkiG9w0BAQEFAAOCAY8AMIIBigKCAYEAvu/PZpIFsDeV5Wbwez0z
            K3euQJSRyIjXu59uSWUE1TOcl/+MDBu6lf8/KbOTWHEh7qMXNoZ000u93S3DNRPx
            p4S4pI9DOeJ65znSVgZt9W2bzcWFn8BYTRtxc5bBO0uReh2sVMqJ2r7paXK7HOU4
            u5jV4BgGxXT/tI+h41yGqSdtqUMQaeW/1jRYRS+yG69AwSUo+IlFwFeSrKZaKso6
            qb7q1V+M0Zy4CBiXUzsppN+gtVQei5ngdcuMN8+pWML1/VMO2UmAec7s/asy+VZ9
            vnwu80ZKBAYknI6nEePJjYW4Q9kpdQfCRrRRJ55lXmeIQQZWx+aqNxYh0G+Hc1t+
            qea1LYbQ+/yjR7HcgxNMpiq82pJqHdZNNdhSl99w/RgNMVrgvkSHN8JFxEZfGwN6
            EN5ALs265M59RSm+mcfmJe78b8AvAK71kmr7dvEx1ItHocuF4G+2Ia5px0Mp7fhs
            ugnIMWgRBuje/1/aH8IwAM8olUF/5uhq21a5kkIM3TmNAgMBAAE=
            -----END PUBLIC KEY-----
            EOD;
        $data = JWT::decode($jwt, new Key($realPublicKey, 'RS256'));
        return $data;
    }

    public static function verifyAndBase64DecodeJwt(string $jwt)
    {
        try {
            $payload = (array) JWT::jsonDecode(JWT::urlsafeB64Decode(explode('.', $jwt)[1]));
            $cloneJwt = self::generateJwt($payload);
            if ($jwt === $cloneJwt) {
                return $payload;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return false;
    }
}
