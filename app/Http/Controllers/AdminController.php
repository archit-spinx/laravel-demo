<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pages;
use App\models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class AdminController extends Controller
{
    //
    public function pages(){
        $data = DB::table('pages')->paginate(5);
        return view('admin/pages',['pagedatas'=>$data]);
    }

    public function addPages(){
        return view('admin/addpages');
    }

    public function savePage(Request $req){
        $page = new Pages;
        $req->validate([
            'page_title' => 'required|max:255|unique:pages,title,',
            'pagecontent'=> 'required',

        ],
         [
                'page_title.required' => 'Page Title is required',
                'pagecontent.required' => 'Content is required',
                'page_title.unique' => 'Page title is already exists',
        ]);

        $page->title = $req->page_title;
        $page->content = $req->pagecontent;
        $page->user_by = auth()->user()->id;
        $page->save();

        return redirect()->back()->with('message', 'Page added successfully.');
    }

    public function editPages($id){
        $data = Pages::find($id);
        return view('admin/editpages',['pagedata'=>$data]);
    }

    function updatePage(Request $req){
            
         $req->validate([
            'page_title' => 'required|max:255|unique:pages,title,'.$req->id,
            'pagecontent'=> 'required',

        ],
         [
                'page_title.required' => 'Page Title is required',
                'pagecontent.required' => 'Content is required',
                'page_title.unique' => 'Page title is already exists',
        ]);

        $data = Pages::find($req->id);
        $data->title = $req->page_title;
        $data->content = $req->pagecontent;
        $data->user_by = auth()->user()->id;
        $data->update();

        return redirect()->back()->with('message', 'Page updated successfully.');
    }

    function deletePages($id){
        $data = Pages::find($id);
        $data->delete();
       return redirect('admin/pages');
    }

    public function userslist(){
        $data = DB::table('users')->paginate(50);
        return view('admin/users',['pagedatas'=>$data]);
    }

     public function editUser($id){
        $data = User::find($id);
        return view('admin/edituser',['pagedata'=>$data]);
    }

     public function addUsers(){
        return view('admin/addusers');
    }

    public function saveUsers(Request $req){
        $user = new User;
        $req->validate([
            //'page_title' => 'required|max:255|unique:pages,title,'.$req->id,
            'name' => 'required|string,max:255',
            'email' => 'required,string,email,max:255,unique:users,email,'.$req->id,
            'phone' => 'required|max:10',
            'password' => 'required,string,min:8',
            'role' => 'required',

        ],
        );

        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->role = $req->role;
        $user->password = Hash::make($req->password);
        $user->save();

        return redirect()->back()->with('message', 'User added successfully.');
    }

     function deleteUser($id){
        $data = user::find($id);
        $data->delete();
       return redirect('admin/users');
    }

      public function updateUser(Request $req){
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
           // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:10'],
            'role' => ['required'],

        ],
        );

        $user = User::find($req->id);
        $user->name = $req->name;
       // $user->email = $req->email;
        $user->phone = $req->phone;
        $user->role = $req->role;
        $user->update();

        return redirect()->back()->with('message', 'User updated successfully.');
    }

    public function dashboard(){
        return view('admin/dashboard');
    }
}
