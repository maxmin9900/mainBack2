<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AvatarRequest;
use App\Http\Requests\Api\ProfileRequest;
use App\Http\Resources\ServiceProviderResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Service\ServiceProvider;
use App\Models\User\User;
use App\Services\Utility;
use function auth;

class ProfileController extends ApiController
{
    public function index()
    {
        return $this->successResponse(
            new UserProfileResource(auth()->user())
        );
    }

    public function avatar(AvatarRequest $request)
    {
        if (auth()->user()->avatar) {
            Utility::deleteFile(auth()->user()->avatar);
        }
        $file = Utility::uploadFile($request->file('avatar'));
        auth()->user()->update([
            'avatar' => $file
        ]);
        return $this->successResponse('ok');
    }

    public function getProfile($id)
    {
        $user = User::findByWalletId($id);
        if (!$user) {
            return $this->error404Response('User Profile Not Found');
        }
        $userService = ServiceProvider::where('user_id', $user->id)
            ->with('Service')
            ->get();
        return $this->successResponse([
            'user' => new UserProfileResource($user),
            'services' => ServiceProviderResource::collection($userService)
        ]);
    }

    public function update(ProfileRequest $request)
    {
        auth()->user()->update(
            $request->only('name', 'email', 'phone')
        );
        return $this->successResponse("ok");
    }
}
