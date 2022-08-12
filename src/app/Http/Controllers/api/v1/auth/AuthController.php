<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method POST
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request):JsonResponse
    {
        // Insert User Into Database
        resolve(UserRepository::class)->create($request->name,$request->email,$request->password);
        return response()->json(['message' => 'user created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Login User
     * @method GET
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request):JsonResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = auth()->user()->createToken(config('constant.create_token'));
            return response()->json(['token' => $user->plainTextToken],
                Response::HTTP_OK);
        }
        throw ValidationException::withMessages([
            'email' => 'incorrect credentials.'
        ]);


    }

    /**
     * Return User Info
     * @method GET
     * @return JsonResponse
     */
    public function user():JsonResponse
    {
        return response()->json([Auth::user()], Response::HTTP_OK);
    }

    /**
     * Log User Out
     * @method GET
     * @return JsonResponse
     */
    public function logout():JsonResponse
    {
        Auth::logout();
        return response()->json(['message' => 'logged out successfully']);
    }

}
