<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Services\Auth\Traits\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    use  ThrottlesLogins;


    public function showRegisterationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $this->validateRegister($request);

        $admin = $this->create($request->all());

        $this->guard()->login($admin);

        return redirect()->route('home');

    }

    private function validateRegister($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email',Rule::unique('admins','email')],
            'password' => ['required', 'confirmed', Rules\Password::default()],
            'department' => ['required']
        ]);
    }

    private function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'department' => $data['department']
        ]);
    }

    private function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validateForm($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (!$this->isValidCredentials($request)) {
            $this->incrementLoginAttempts($request);
            return $this->sendLoginFailedResponse();
        }

        $admin = $this->getAdmin($request);

        $this->guard()->login($admin);

        return $this->sendSuccessResponse();
    }

    private function validateForm(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email', 'exists:users'],
                'password' => ['required'],
            ]
        );
    }

    private function isValidCredentials($request)
    {
        return Auth::validate($request->only(['email', 'password']));
    }

    private function sendLoginFailedResponse()
    {
        return back()->with('failed', __('auth.failed'));
    }

    private function getAdmin(Request $request)
    {
        return Admin::where('email', $request->email)->firstOrFail();
    }

    protected function sendHasTwoFactorResponse()
    {
        return redirect()->route('auth.login.code.form');
    }

    private function sendSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    public function showCodeForm()
    {
        return view('auth.two-factor.login-code');
    }



    public function logout()
    {
        session()->invalidate();

        $this->guard()->logout();

        return redirect()->route('home');
    }
}
