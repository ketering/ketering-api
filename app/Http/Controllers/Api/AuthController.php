<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(['email', 'password', 'device']), [
            'email' => ['required'],
            'password' => ['required'],
            'device' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken($request->device)->plainTextToken;
            $success['name'] = $user->name . ' ' . $user->surname;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Invalid login credentials. Please try again.'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Register api
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ['required', 'max:255'],
            "surname" => ['required', 'max:255'],
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "password" => ['required', 'confirmed', 'min:8', 'max:255'],
            "device" => ['required']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = $request->all();
//        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $role = Role::guest();
        $role->users()->save($user);
        $success['token'] = $user->createToken($request->device)->plainTextToken;
        $success['name'] = $user->name . ' ' . $user->surname;

        return $this->sendResponse($success, 'User registered successfully.', Response::HTTP_CREATED);
    }

    /**
     * Logout a user
     *
     * @return JsonResponse
     */
    public function logout()
    {
        # code
        $all = false;

        if (\request('all') == true) {
            $all = true;
            request()->user()->tokens()->delete();
        } else {
            request()->user()->currentAccessToken()->delete();
        }

        return $this->sendResponse($all ? 'All tokens revoked' : 'Current token revoked', 'User logout successfully.', Response::HTTP_OK);
    }
}
