<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Contract\Auth\Provider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use GuzzleHttp\Client;

use App\User;



class RocketchatAuthProvider implements Provider
{

    public function authenticate(Request $request, Route $route)
    {
        // Logic to authenticate the request.

        $tokenHeader = $request->headers->get('X-Auth-Token');
        $idHeader = $request->headers->get('X-User-Id');

        $client = new Client();

        try{
            $res = $client->get(config('app.rocketchat_url').'/api/v1/me', [
                'headers' => [
                    'X-Auth-Token' => $tokenHeader,
                    'X-User-Id' => $idHeader,
                ],
                'http_errors' => false
            ]);
        } catch(Exception $e){

        }

        if($res->getStatusCode() != 200){
            throw new UnauthorizedHttpException(null, 'Unable to authenticate with supplied userid and token.');
        }

        $me = json_decode($res->getBody()->getContents());

        if($me->_id != $idHeader){
            throw new UnauthorizedHttpException(null, 'Unable to authenticate with supplied userid and token.');
        }

        return User::firstOrCreate(['rcid' => $idHeader]);

    }

    public static function getUser(Request $request){
        $idHeader = $request->headers->get('X-User-Id');

        $user = User::where('rcid', $idHeader)->first();
        if(!$user){
            throw new UnauthorizedHttpException('User not found.');
        }

        return $user;
    }
}

?>