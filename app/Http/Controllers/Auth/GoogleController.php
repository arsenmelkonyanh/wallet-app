<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function handleGoogleRedirect(): RedirectResponse
    {
        return Socialite::driver(User::SOCIALITE_TYPE_GOOGLE)->redirect();
    }

    /**
     * Handles callback from google login/register.
     *
     * In case if user already exists update user with needle data and login him.
     * Otherwise create new user from google user and login him.
     *
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $user = Socialite::driver(User::SOCIALITE_TYPE_GOOGLE)->user();

            // check if user already exists by oauth_id and oauth_type
            $existingUser = User::where('oauth_id', $user->id)->where('oauth_type', User::SOCIALITE_TYPE_GOOGLE)->first();

            if ($existingUser) {
                Auth::login($existingUser);

                return Redirect::route('wallets.index');
            }

            // check if user already exists by email
            $existingUser = User::where('email', $user->email)->first();
            if ($existingUser) {
                // set already existing user oauth_id and oauth_type
                $existingUser->oauth_id = $user->id;
                $existingUser->oauth_type = User::SOCIALITE_TYPE_GOOGLE;
                $existingUser->save();

                Auth::login($existingUser);

                return Redirect::route('wallets.index');
            }

            // otherwise create new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => now(),
                'oauth_id' => $user->id,
                'oauth_type' => User::SOCIALITE_TYPE_GOOGLE,
                'password' => Hash::make($user->id)
            ]);

            Auth::login($newUser);

            return Redirect::route('wallets.index');
        } catch (\Exception $ex) {
            Log::error('Unable to create user by google', ['msg' => $ex->getMessage()]);
            return Redirect::route('login');
        }
    }
}
