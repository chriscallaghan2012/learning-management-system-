<?php
/**
 * Created by PhpStorm.
 * User: salamaashoush
 * Date: 22/02/17
 * Time: 12:18 م
 */

namespace App\Controllers;


use App\Core\Controller;
use App\Core\Helper;
use App\Core\Request;
use App\Core\ResourceInterface;
use App\Core\Session;
use App\Models\User;

class UserController extends Controller implements ResourceInterface
{
    public function index()
    {
        if (Session::isLogin()&&Session::getLoginUser()->role == 'admin') {

            $users = User::all();
            return view('admin/users/index', ['users' => $users]);
        }else{
            return view('errors/503',['message'=>"You are not allowed to be here!"]);
        }
    }
    public function create()
    {
        if (Session::isLogin()&&Session::getLoginUser()->role == 'admin') {
            $users = User::all();
            return view('admin/users/create', ['users' => $users]);
        }else{
            return view('errors/503',['message'=>"You are not allowed to be here!"]);
        }
    }

    public function store(Request $request)
    {
        if (Session::isLogin()&&Session::getLoginUser()->role == 'admin') {
            if (verifyCSRF($request)) {
                $errors = $this->validator->validate($request, [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'username' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                    'confirm' => 'required|min:8'
                ]);
                if ($request->get('password') !== $request->get('confirm')) {
                    $errors['login'] = "Password not match";
                }
                if (!empty(User::retrieveByEmail($request->get('email')))) {
                    Session::set('error', "User already exists");
                    redirect('/users/create', $request->getLastFromSession());
                } else {
                    if ($errors) {
                        $request->saveToSession($errors);
                        Session::set('error', "non valid data");
                        redirect('/users/create', $request->getLastFromSession());
                    } else {
                        $user = new User();
                        $user->firstname = $request->get('firstname');
                        $user->lastname = $request->get('lastname');
                        $user->username = $request->get('username');
                        $user->email = $request->get('email');
                        $user->password = password_hash($request->get('password'), PASSWORD_DEFAULT);
                        $user->image = upload_file("image");
                        $user->gender = $request->get('gender');
                        $user->country = $request->get('country');
                        $user->role = $request->get('role');
                        if ($request->get('isbaned')) {
                            $user->isbaned = 1;
                        } else {
                            $user->isbaned = 0;
                        }
                        $user->created_at = date("Y-m-d H:i:s");
                        $user->updated_at = date("Y-m-d H:i:s");
                        $user->save();

                        Session::set('message', "User Added Successfully");
                        redirect("/users/$user->id");
                    }
                }
            }
        }else{
            return view('errors/503',['message'=>"You are not allowed to be here!"]);
        }

    }

    public function show($id)
    {
        if(Session::isLogin()){
            $user = User::retrieveByPK($id);
            return view('admin/users/show', ['user' => $user]);
        }else{
            redirect('/login');
        }
    }

    public function edit($id)
    {
        if (Session::isLogin()&&Session::getLoginUser()->id == $id) {
            $user = User::retrieveByPK($id);
            return view('admin/users/edit', ['user' => $user]);
        } else {
            return view('errors/503',['message'=>"You are not allowed to be here!"]);
        }

    }

    public function update(Request $request, $id)
    {
        if (Session::isLogin()&&Session::getLoginUser()->role == "admin") {
            $user = User::retrieveByPK($id);
            if (verifyCSRF($request)) {
                $errors = $this->validator->validate($request, [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'username' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                    'confirm' => 'required|min:8'
                ]);
                if ($request->get('password') !== $request->get('confirm')) {
                    $errors['confirm'] = "Password not match";
                }
                if ($errors) {
                    $request->saveToSession($errors);
                    redirect('users/' . $user->id . '/edit', $request->getLastFromSession());
                } else {
                    $user->firstname = $request->get('firstname');
                    $user->lastname = $request->get('lastname');
                    $user->username = $request->get('username');
                    $user->email = $request->get('email');
                    $user->password = password_hash($request->get('password'), PASSWORD_DEFAULT);
                    if ($request->getFile('image')) {
                        delete_file($user->image);
                        $user->image = upload_file("image");
                    }
                    $user->gender = $request->get('gender');
                    $user->country = $request->get('country');
                    $user->role = $request->get('role');
                    if ($request->get('isbaned')) {
                        $user->isbaned = 1;
                    } else {
                        $user->isbaned = 0;
                    }
                    $user->updated_at = date("Y-m-d H:i:s");
                    $user->update();
                    Session::set('message', "User Updated Successfully");
                    redirect('/users');
                }
            }
        } else {
            return view("errors/503",['message'=>"You are not allowed to be here!"]);
        }

    }

    public function destroy($id)
    {
        if (Session::isLogin()&&Session::getLoginUser()->role == "admin") {
            $user = User::retrieveByPK($id);
            $user->delete();
            Session::set('message', "User Deleted Successfully");
            redirect('/users');
        }else{
            return view("errors/503",['message'=>"You are not allowed to be here!"]);
        }
    }
}