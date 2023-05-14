<?php

namespace App\Services\User;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\QueryException;

class UserService
{
    #region Login
    public function login(LoginRequest $request)
    {
        $credentials = [
            'phone' => clearPhone($request->phone),
            'password' => $request->password
        ];
        if (!auth()->attempt($credentials))
            throwError('login or password incorrect');

        $client = new Client();
        try {
            $response = $client->post(config('services.passport.url'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.id'),
                    'client_secret' => config('services.passport.secret'),
                    'username' => $request->phone,
                    'password' => $request->password,
                    'scope' => '*'
                ]
            ])->getBody();
            return json_decode($response);
        }catch (Exception | GuzzleException $e){
            throwError($e->getMessage(),$e->getCode());
        }
    }
    #endregion

    #region Register
    public function register(RegisterRequest $request):void
    {
        try {
            User::create($request->validated());
        }catch (QueryException $e){
            throwError($e->getMessage(),$e->getCode());
        }
    }
    #endregion

    #region logout
    public function logout():void
    {
        auth()->user()->tokens()->delete();
    }
    #endregion

    public function refreshToken(string $token) {
        $client = new Client();
        try {
            $response = $client->post(config('services.passport.url'),[
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token,
                    'client_id' => config('services.passport.id'),
                    'client_secret' => config('services.passport.secret'),
                    'scope' => '*',
                ]
            ]);
            return json_decode($response->getBody());
        } catch (Exception | GuzzleException $e){
            throwError($e->getMessage(),$e->getCode());
        }
    }
}
