<?php

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 15:59
 */

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /** @var string  */
    protected $redirecTo = '/admin';
    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    /**
     * @param LoginRequest $request
     * @return Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (auth()->guard('admin')->attempt($request->only('email', 'password'))) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}
