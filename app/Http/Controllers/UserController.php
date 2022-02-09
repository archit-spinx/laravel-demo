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
                'email'=>'required|email|string|max:255|unique:users,email,'.$user->id,
                'phone' => 'nullable|max:10',
                'password' => 'required|min:6|confirmed'
            ]); 
        }else{
            $request->validate([
                'name' =>'required|min:4|string|max:255',
                'email'=>'required|email|string|max:255|unique:users,email,'.$user->id, 
                'phone' => 'required|max:10',               
            ]); 
        } 
        
        $user =Auth::user();   


    
        // if($request->hasFile('profile_img')){

        //     $filename = $request->profile_img->getClientOriginalName();
        //     $request->profile_img->move(public_path('uploads'), $filename);
        //     Auth()->user()->update(['profile_img'=>$filename]);
        // }

if($request->hasFile('profile_img')){
        $profileImage = $request->file('profile_img');
     $profileImageSaveAsName = time() . "-profile." . $profileImage->getClientOriginalExtension();

     $upload_path = 'uploads/';
     $profile_image_url = $upload_path . $profileImageSaveAsName;
     $success = $profileImage->move($upload_path, $profileImageSaveAsName);
      Auth()->user()->update(['profile_img'=>$profile_image_url]);
       } 
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        if(isset($request['password'])){
        $user->password = bcrypt($request['password']);
        }
        $user->save();
        return back()->with('message','Profile Updated');
    }

    
}
