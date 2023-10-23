<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    //
    public function me()
    {
        # code
        $response = new UserResource(auth()->user());

        return $this->sendResponse($response, 'User fetched successfully');
    }

    public function update(Request $request)
    {
        # code
        $user = auth()->user();
        $validator = \Validator::make($request->all(), [
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)]
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update($validator->validated());
        $response = new UserResource($user);

        return $this->sendResponse($response, 'User successfully updated');
    }
}
