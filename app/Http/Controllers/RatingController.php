<?php

namespace App\Http\Controllers;
use App\Models\Rating;
use Illuminate\Http\Request;
use DB;
class RatingController extends Controller
{
     public function reviewsubmit(Request $req){
        $rating = new Rating; 

        $already_added = Rating::where('product_id','=',$req->product_id)
       ->where('rating_user','=',auth()->user()->id)
       ->get();
      
       if (count($already_added)>0) {
         return redirect()->back()->with('message', 'Review already submitted');  
       } else {
         $rating->rating = $req->rating; 
           $rating->product_id =  $req->product_id; 
           $rating->rating_user = auth()->user()->id;
           $rating->save();  
        return redirect()->back()->with('message', 'Review submitted Successfully');
       }
    }
}
