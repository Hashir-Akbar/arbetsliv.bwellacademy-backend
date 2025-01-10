<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RemindersController extends Controller
{
    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getRemind()
    {
        return view('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first());

            return back()->withInput();
        }

        $response = Password::sendResetLink($request->only('email'));

        switch ($response) {
            case Password::INVALID_USER:
                Session::flash('error', Lang::get($response));

                return back()->withInput();

            case Password::RESET_LINK_SENT:
                Session::flash('status', Lang::get($response));

                return back();
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return Response
     */
    public function getReset(Request $request)
    {
        $token = $request->query('token');
        if (is_null($token)) {
            abort(403);
        }

        return view('password.reset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first());

            return back()->withInput();
        }

        $credentials = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);

            $user->save();
        });

        switch ($response) {
            case Password::INVALID_TOKEN:
                Session::flash('error', Lang::get($response));

                return redirect()->route('password.remind');

            case Password::INVALID_USER:
                Session::flash('error', Lang::get($response));

                return back();

            case Password::PASSWORD_RESET:
                return redirect('/');
        }
    }
}
