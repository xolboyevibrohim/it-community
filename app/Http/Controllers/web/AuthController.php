<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Post\PostService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }
    public function register(RegisterRequest $request)
    {
        (new UserService())->register($request);
        return redirect()->route('login');
    }
    public function registerPage()
    {
        return view('pages.auth-register');
    }
    public function loginForm()
    {
        return view('pages.auth-login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('phone', 'password');
        if (!auth()->attempt($credentials,$request->get('remember_me'))) {
            throwError('login or password incorrect');
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
//        $token = $tokenResult->plainTextToken;
        return $this->homePage();
    }

    public function homePage()
    {
        $posts = (new PostService())->postList();
        return view('pages.home',compact('posts'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
