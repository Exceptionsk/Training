<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Frontend\User\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;

class UserController extends Controller
{
  private
      $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
      $this->userRepository = $userRepository;
  }

  public function index(Request $request)
  {
      if (Auth::guard('User')->check()) {
          //if (Auth::guard('User')->user()->role_id == 1) {
              $users      = $this->userRepository->getUsers();
              $roles      = $this->userRepository->getRoles();
              $cur_time   = Carbon::now();
              return view('core.user.index')->with('users', $users)->with('roles', $roles)->with('cur_time',
                  $cur_time);
          //}
      }
      return redirect('/backend/login');
  }

  public function pending(){
    return view('frontend.pending');
  }

  public function create(){
    return view('frontend.register');
  }

  public function store(Request $request)
  {
      // $request->validate();
      $user_name  = trim(Input::get('user_name'));
      $email      = trim(Input::get('email'));
      $password   = trim(bcrypt(Input::get('password')));
      $userObj = new User();
      $userObj->user_name = $user_name;
      $userObj->email = $email;
      $userObj->staff_id = $email;
      $userObj->password = $password;
      $userObj->role_id = 6;
      $userObj->status = 2;
      $this->userRepository->create($userObj);

      return redirect()->action('Frontend\UserController@pending');
  }

}
