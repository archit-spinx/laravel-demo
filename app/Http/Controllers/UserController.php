<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Client\Response;


class UserController extends Controller
{
    //

    public function show(){
        return view('profile');
    }
    public function profileUpdate(Request $request){
    
        $user =Auth::user();
        //validation rules
    //echo "<pre>";print_r( $user);
        //echo "Test"; exit;
       
        
        if($request['password']){
            $request->validate([
                'name' =>'required|min:4|string|max:255',
                'email'=>'required|email|string|max:255',
                'password' => 'required|min:6|confirmed'
            ]); 
        }else{
            $request->validate([
                'name' =>'required|min:4|string|max:255',
                'email'=>'required|email|string|max:255',                
            ]); 
        } 
        
        $user =Auth::user();   
        $user->name = $request['name'];
        $user->email = $request['email'];
        if(isset($request['password'])){
        $user->password = bcrypt($request['password']);
        }
        $user->save();
        return back()->with('message','Profile Updated');
    }

    
}
