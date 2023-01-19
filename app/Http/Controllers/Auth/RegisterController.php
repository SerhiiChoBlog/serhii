<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\AvatarGeneratorService;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
    }

    public function getAvatarFilename(): string
    {
        $service = new AvatarGeneratorService(request('email'));
        return $service->handle();
    }

    /**
     * @param array<string, string> $data
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
        /** @var User $user */
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $this->getAvatarFilename(),
        ]);

        return $user;
    }

    protected function redirectTo(): string
    {
        return RouteServiceProvider::USER_HOME;
    }
}
