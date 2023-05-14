<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshToken;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\UserService;

/**
 * @group Auth
 */
class AuthController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    /**
     * Login (Avtorizatsiya)
     * @ResponseFile 401 storage/response/auth/401.json
     * @ResponseFile 400 storage/response/auth/400.json
     * @ResponseFile 200 storage/response/auth/200.json
     */
    public function login(LoginRequest $request)
    {
        $res = $this->service->login($request);
        return success($res);
    }

    /**
     * Register
     * @ResponseFile 401 storage/response/auth/401.json
     * @ResponseFile 200 storage/response/register/200.json
     */
    public function register(RegisterRequest $request)
    {
        $this->service->register($request);
        return success();
    }

    /**
     * Logout
     * @ResponseFile 401 storage/response/auth/401.json
     * @ResponseFile 200 storage/response/logout/200.json
     */
    public function logout()
    {
        $this->service->logout();
        return success();
    }

    /**
     * Refresh-token
     * @ResponseFile 401 storage/response/auth/401.json
     * @ResponseFile 200 storage/response/auth/200.json
     */
    public function refreshToken(RefreshToken $request)
    {
        $token = $this->service->refreshToken($request->get('refresh_token'));
        return success($token);
    }
}
