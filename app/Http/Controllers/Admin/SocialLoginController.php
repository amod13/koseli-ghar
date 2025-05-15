<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
     /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        $query = http_build_query([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);


        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }




    /**
     * Handle Google callback and authenticate the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback(Request $request)
    {
        // Step 1: Exchange the code for an access token
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
            'code' => $request->code,
        ]);

        if ($response->failed()) {
            return redirect()->route('login')->withErrors(['error' => 'Failed to authenticate with Google.']);
        }

        $accessToken = $response->json()['access_token'];

        // Step 2: Use the access token to fetch user information from Google
        $userInfo = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://www.googleapis.com/oauth2/v2/userinfo')->json();

        // Step 3: Create or log in the user
        $user = User::firstOrCreate(
            ['email' => $userInfo['email']],
            ['name' => $userInfo['name']]
        );

        // Step 4: Log the user in
        Auth::login($user);

        // Redirect to the intended route (e.g., the dashboard)
        return redirect()->intended('/dashboard');
    }

}
