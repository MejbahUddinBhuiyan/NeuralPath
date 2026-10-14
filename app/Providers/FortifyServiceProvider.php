<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap Fortify authentication.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | User Management
        |--------------------------------------------------------------------------
        */

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::updateUserProfileInformationUsing(
            UpdateUserProfileInformation::class
        );

        Fortify::updateUserPasswordsUsing(
            UpdateUserPassword::class
        );

        Fortify::resetUserPasswordsUsing(
            ResetUserPassword::class
        );

        Fortify::redirectUserForTwoFactorAuthenticationUsing(
            RedirectIfTwoFactorAuthenticatable::class
        );

        /*
        |--------------------------------------------------------------------------
        | Authentication Views
        |--------------------------------------------------------------------------
        */

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.reset-password', [
                'request' => $request,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | NeuralPath Login Authorization
        |--------------------------------------------------------------------------
        |
        | Only active users with verified email addresses
        | and valid passwords can log in.
        |
        */

        Fortify::authenticateUsing(function (Request $request) {

            $email = Str::lower(trim(
                (string) $request->input('email', '')
            ));

            $user = User::where('email', $email)->first();

            if (! $user) {
                return null;
            }

            if (! $user->isActive()) {
                return null;
            }

            if (! $user->hasVerifiedEmail()) {
                return null;
            }

            if (! Hash::check(
                (string) $request->input('password', ''),
                $user->password
            )) {
                return null;
            }

            return $user;
        });

        /*
        |--------------------------------------------------------------------------
        | Login Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('login', function (Request $request) {

            $throttleKey = Str::transliterate(
                Str::lower(
                    (string) $request->input(Fortify::username())
                ).'|'.$request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        /*
        |--------------------------------------------------------------------------
        | Two-Factor Authentication Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('two-factor', function (Request $request) {

            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
                    ?: $request->ip()
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Passkey Authentication Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('passkeys', function (Request $request) {

            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId())
                .'|'.$request->ip()
            );
        });
    }
}
