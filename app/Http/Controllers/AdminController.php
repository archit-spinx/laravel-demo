<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pages;
use App\models\Users;
use Illuminate\Support\Facades\DB;
use Auth;

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
            'page_title' => 'required|max:255',
            'pagecontent'=> 'required|unique:pages,title,',

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
            'page_title' => 'required|max:255',
            'pagecontent'=> 'required|unique:pages,title,',

        ],
         [
                'page_title.required' => 'Page Title is required',
                'pagecontent.required' => 'Content is required',
                'pagecontent.unique' => 'Page title is already exists',
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
        $data = DB::table('users')->paginate(5);
        return view('admin/users',['pagedatas'=>$data]);
    }

     public function editUser($id){
        $data = Users::find($id);
        return view('admin/edituser',['pagedata'=>$data]);
    }

     public function addUsers(){
        return view('admin/addusers');
    }

    public function saveUsers(Request $req){
        $page = new Users;
        $req->validate([
            'page_title' => 'required|max:255',
            'pagecontent'=> 'required|unique:pages,title,',

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

     function deleteUser($id){
        $data = users::find($id);
        $data->delete();
       return redirect('admin/users');
    }
}
