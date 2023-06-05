<?php

namespace App\Custom;

use App\Models\User;
use Firebase\JWT\JWT as JWTFirebase;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class Jwt
{
    public static function create(User $data): string
    {
        $key = $_ENV['JWT_KEY'];

        $payload = [
            'exp' => time() + 1800,
            'iat' => time(),
            'data' => $data
        ];

        return JWTFirebase::encode($payload, $key, 'HS256');
    }

    public static function validate()
    {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $key = $_ENV['JWT_KEY'];
        try{
            $token = str_replace('Bearer ', '', $authorization);
            $decoded = JWTFirebase::decode($token, new Key($key, 'HS256'));
            return response()->json($decoded, 200);
        } catch (\Throwable $th){
            return response()->json($th->getMessage(), 401);
        }
    }
}
