<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin_data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if(Auth::guard('admin')->attempt($admin_data)){
            return redirect('/dashboard')->with('success','Login Successfull!');
        } else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function getDashboard(Request $request){
        $users = User::where('deleted_at',Null)->get();
        return view('dashboard',compact('users'));
    }

    public function getAddUser(){
        return view('add_user_form');
    }

    public function getEditUser($user_id){
        if($user_id > 0){
            $user_data = User::where('id',$user_id)->first();
            return view('add_user_form',compact('user_data'));
        }
    }

    public function postAddEditUser(UserRequest $request){
        $id = $request->get('id');
        if($id != Null){
            $user = User::where('id',$id)->first();            
        } else{
            $user = new User();
            $user->password = Hash::make($request->get('password'));
        }
        
        $user->first_name = $request->get('fname');
        $user->last_name = $request->get('lname');
        $user->dob = $request->get('dob');
        $user->phone = $request->get('phone');
        $user->email = $request->get('email');       
        $user->save();

        if ($request->hasFile('image')) {
            if(FacadesFile::exists(public_path('profile_images/'.$user->image))){
                FacadesFile::delete(public_path('profile_images/'.$user->image));
            }
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/profile_images');
            $image->move($destinationPath, $name);

            $user->image = $name;
            $user->save();
        }

        if($user->id){
            if($id){
                return redirect()->route('get:dashboard')->with('success','User has been edited successfully!');
            } else{
                return redirect()->route('get:dashboard')->with('success','User has been edited successfully!');
            }
        } else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function postDeleteUser(Request $request){
        $id = $request->get('id');
        if($id != Null){
            $user = User::where('id',$id)->first();
            if($user != Null){
                $user->delete();

                return response()->json([
                    'status' => 1,                   
                ]);
            } else{
                return response()->json([
                    'status' => 0,
                ]);
            }
        } else{
            return response()->json([
                'status' => 0,
            ]);
        }
    }

    public function postChangeUserStatus(Request $request){
        $id = $request->get('id');
        if($id != Null){
            $user = User::where('id',$id)->first();
            if($user != Null){
                $user->status = $user->status == 1 ? 0 : 1;
                $user->save();

                return response()->json([
                    'status' => 1,
                    'status_value' => $user->status
                ]);
            } else{
                return response()->json([
                    'status' => 0,
                ]);
            }
        } else{
            return response()->json([
                'status' => 0,
            ]);
        }
    }

    public function getLogout(){
        Auth::guard('admin')->logout();

        return redirect()->route('get:admin_login');
    }
}
