<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedTokenController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('auth-token', ['*'], now()->addHours(2))->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 7200,
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete(); // Revoga todos os tokens do usuário
        }

        return response()->json(['message' => 'Logout realizado'], Response::HTTP_OK);
    }
}
