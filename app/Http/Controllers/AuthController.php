<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $ability = ['user.store'];
            return $this->response('Autenticado', 200, [
                'user' => auth()->user(),
                'token' => $request->user()->createToken($request->email)->plainTextToken,
            ]);
        }

        return $this->errors('Unauthorized', 403, ['message' => 'Falha na autenticação']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response('Token revoked', 200);
    }

    public function verify(): \Illuminate\Http\JsonResponse
    {
        return \App\Custom\Jwt::validate();
    }

    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return $this->errors('Não autorizado', 401);
        }
        $password = $request->password;
        $hash = $user->password;
        if(!password_verify($password, $hash)){
            return $this->errors('Não autorizado', 401);
        }

        $token = \App\Custom\Jwt::create($user);

        return $this->response('Autorizado',200,[
            'token' => $token
        ]);
    }
}
