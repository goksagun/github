<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Config;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }
    public function getLogout(Request $request)
    {
        Auth::logout();

        $request->session()->forget('github.token');
        $request->session()->forget('github.username');

        return redirect('auth/login');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider
     * @return Response
     */
    public function redirectToProvider($provider = 'github')
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param Request $request
     * @param string $provider
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider = 'github')
    {
        $user = Socialite::driver($provider)->user();

        if ($user->token) {
            $request->session()->push("{$provider}.token", $user->token);
            $request->session()->push("{$provider}.username", $user->nickname);

            $userLogin = User::where('provider_id', '=', $user->getId())->first();

            if (!$userLogin) {
                $userData = [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'username' => $user->getNickname(),
                    'avatar' => $user->getAvatar(),
                    'provider_id' => $user->getId(),
                ];

                $userLogin = User::create($userData);
            }

            Auth::login($userLogin);
        }

//        dd($user, $userData);

        return redirect('/')->withMessage(['success' => "Login successful."]);

//        // OAuth Two Providers
//        $token = $user->token;
//
//        // OAuth One Providers
//        $token = $user->token;
//        $tokenSecret = $user->tokenSecret;
//
//        // All Providers
//        $user->getId();
//        $user->getNickname();
//        $user->getName();
//        $user->getEmail();
//        $user->getAvatar();
    }
}