<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UploadPhotoRequest;
use App\Utils\ProfilePhotoProcessor;
use Illuminate\Http\UploadedFile;

class UserController extends Controller
{
    public function uploadPhoto(UploadPhotoRequest $request): void
    {
        $user = user();

        abort_if(!$user, 401);

        /** @var UploadedFile $photo */
        $photo = $request->file('photo');

        $image_processor = new ProfilePhotoProcessor($photo, $user);
        $avatar = $image_processor->save();

        $user->update(compact('avatar'));
    }
}
