<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ban\BanRequest;
use App\Http\Requests\Admin\Ban\UnbanRequest;
use App\Models\Ban;
use App\Models\User;

class BanController extends Controller
{
    public function ban(BanRequest $request): void
    {
        /** @var User $user */
        $user = User::with('ban')
            ->where('id', $request->user_id)
            ->firstOrFail();

        $user->update(['remember_token' => null]);

        if ($user->ban) {
            return;
        }

        $user->ban()->create(['comment' => $request->comment]);

        if ($request->boolean('disapprove_comments')) {
            $user->comments()
                ->where('is_approved', true)
                ->update(['is_approved' => false]);
        }
    }

    public function unban(UnbanRequest $request): void
    {
        Ban::query()->where('user_id', $request->user_id)->delete();
    }
}
