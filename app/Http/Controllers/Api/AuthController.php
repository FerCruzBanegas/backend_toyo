<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Owner;
use App\Models\Store;
use App\Http\Controllers\ApiController;
use App\Mail\VerifyOwner;
use Illuminate\Http\Request;
use App\Http\Requests\ResendRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $user = User::where('email', '=', request('username'))
        ->first();


        if ($user && !$user->email_verified_at) {
            return $this->respond([
                'success' => false,
                'user' => ['id' => $user->id, 'code' => $user->code],
                'message' => message('MSG005'),
            ], 403);
        }
        if (!$user || $user->state === 0) {
            return $this->respond([
                'success' => false,
                'message' => message('MSG007'),
            ], 401);
        }
        if (!Hash::check(request('password'), $user->password)) {
            return $this->respond([
                'success' => false,
                'message' => message('MSG006'),
            ], 422);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username' => $user->email,
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $response = app()->handle($request);

        $data = json_decode($response->getContent());

        $auth = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $user->rol,
            'owner' => $user->owner,
            'created' => $user->created_at,
            'updated' => $user->updated_at,
        ];

        return $this->respond([
            'user' => $auth,
            'access_token'  => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in' => $data->expires_in,
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();

        return $this->respond([
            'success' => true,
            'message' => message('MSG008'),
        ]);
    }

    public function register(RegisterRequest $request) 
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'email' => $request->user['email'],
                'password' => $request->user['password'],
                'code' => substr(md5(time()), 0, 10),
                'rol' => 'user',
            ]);

            $owner = Owner::create([
                'names' => $request->owner['names'],
                'surnames' => $request->owner['surnames'],
                'phone' => $request->owner['phone'],
                'ci' => $request->owner['ci'],
                'store_id' => $request->owner['store_id'],
                'user_id' => $user->id,
            ]);

            // $store = Store::create([
            //     'address' => $request->store['address'],
            //     'city_id' => $request->store['city_id'],
            //     'owner_id' => $owner->id,
            // ]);

            $user->sendEmailVerificationNotification();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'success' => true,
            'data' => ['code' => $user->code, 'email' => $user->email],
        ]);
    }

    public function verify($user_id, Request $request) 
    {
        if (! $request->hasValidSignature()) {
            //cambiar a vista de experacion
            return $this->respondError(null, 254);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            $users = User::where('rol', 'admin')->get();

            foreach ($users->pluck('email') as $recipient) {
                Mail::to($recipient)->queue(new VerifyOwner($user));
            }
        }

        return redirect()->to("http://localhost:8080/system/login?code={$user->code}");
    }

    public function resend(ResendRequest $request)
    {
        $user = User::find($request->id);

        if ($user->email == $request->email) {
            if ($user->hasVerifiedEmail()) {
                return $this->respondError(null, 253);
            }

            $user->sendEmailVerificationNotification();
        }

        return $this->respond([
            'success' => true,
            'data' => ['email' => $request->email],
        ]);
    }

    public function forgot(ResetPasswordRequest $request) 
    {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                return $this->respond([
                    'success' => true,
                    'message'=> __($status),
                ]);
            } 

            return $this->respondError(__($status), 422);

        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
    }


    public function reset(ResetPasswordRequest $request) 
    {
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => $request->password,
                    ])->save();

                    $user->tokens()->delete();

                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                return $this->respond([
                    'success' => true,
                    'message'=> message('MSG004'),
                ]);
            }

            if ($status == Password::INVALID_USER) {
                return $this->respondError(trans($status), 422);
            }

            if ($status == Password::INVALID_TOKEN) {
                return $this->respondError(trans($status), 500);
            }

        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
    }
}
