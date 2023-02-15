<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\GenerateAvatarService;
use App\Services\GenerateSlugService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
        $this->middleware('guest:admin');
    }

    public function getAvatarFilename(string $slug): string
    {
        $service = new GenerateAvatarService(request('email'), $slug);
        return $service->handle();
    }

    /**
     * @param array<string, string> $data
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:2', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array{name:string, email:string, password:string} $data
     * @return User
     */
    protected function create(array $data): User
    {
        $slug = $this->generateSlug($data['name']);

        /** @var User */
        return User::query()->create([
            'name' => $data['name'],
            'secret' => User::generateSecret($data['email']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $this->getAvatarFilename($slug),
            'slug' => $slug,
        ]);
    }

    protected function generateSlug(string $name): string
    {
        $slug_service = new GenerateSlugService($name);
        return $slug_service->handle();
    }

    protected function redirectTo(): string
    {
        return RouteServiceProvider::USER_HOME;
    }

    protected function guard(): Guard
    {
        return Auth::guard('user');
    }
}
