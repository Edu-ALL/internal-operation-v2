<?php

namespace App\Http\Controllers;

use App\Enums\LoggerModuleEnum;
use App\Enums\LogTypeEnum;
use App\Http\Traits\LoggingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MenuRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    use LoggingTrait;
    private MenuRepositoryInterface $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        # check credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $logDetails = [
                'user' => $user,
            ];
            
            # checking the user type 
            # if the user still has contract permissions with eduALL
            # if no then kick them to login page
            if (!$user_type = $user->user_type->where('tbl_user_type_detail.status', 1)->first()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $this->logAlert(LoggerModuleEnum::Auth, $logDetails);

                return back()->withErrors([
                    'password' => 'You don\'t have permission to login. If this problem persists, please contact our administrator.'
                ]);
            }

            # if the user still has contract access with eduALL
            # then check if the contract access is full-time or part-time
            # when the type name is part-time then check if the date they're login is still on the contract date
            # if no then kik them to login page
            if ($user_type->type_name != 'Full-Time' && ($user_type->pivot->end_date <= Carbon::now()->toDateString())) {

                $this->logAlert(LoggerModuleEnum::Auth, $logDetails);

                return back()->withErrors([
                    'password' => 'Your don\'t have permission to login. If this problem persists, please contact our administrator.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'password' => 'Wrong email or password',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function logoutFromExpirationTime(Request $request)
    {
        $timeout = 3600;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('login')->withError('You had not activity in '.$timeout/60 .' minutes ago.');
    }
}
