<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class UserController extends Controller{
    public function redirectAdmin(){
        $user = Auth::user();
        if($user->user_type == 0)
            return view('user');
        return view('admin');
    }

    public function details($id){
        $user = Auth::user();
        if($user == null) {
            $query = "select * from reviews where product_id = ".$id;
            $reviews = DB::select($query);
            $data = compact('id','reviews');
            return view('details')->with($data);
        }
        else{
            if($user->user_type == 0){
                $query = "select * from reviews where product_id = ".$id;
                $reviews = DB::select($query);
                $data = compact('id','reviews');
                return view('user-details')->with($data);
            }
            else if($user->user_type == 1){
                $query = "select * from reviews where product_id = ".$id;
                $reviews = DB::select($query);
                $data = compact('id','reviews');
                return view('admin-details')->with($data);
            }
        }
    }

    public function storeReview($id, Request $request){
        $review = Review::create([
            'name' => $request->name,
            'date' => $request->date,
            'review' => $request->text,
            'rating' => $request->rating,
            'product_id' => $id,
        ]);
        $query = "select * from reviews where product_id = ".$id;
        $reviews = DB::select($query);
        $data = compact('id','reviews');
        $user = Auth::user();
        if($user->user_type == 0)
            return view('user-details')->with($data);
        else
            return view('admin-details')->with($data);
    }

    public function deleteReview($id,$uid){
        $query = "delete from reviews where id = ".$uid;
        $review = DB::select($query);
        $query = "select * from reviews where product_id = ".$id;
        $reviews = DB::select($query);
        $data = compact('id','reviews');
        $user = Auth::user();
        if($user->user_type == 0)
            return view('user-details')->with($data);
        else
            return view('admin-details')->with($data);
    }

    public function editReview($id,$uid){
        $data = compact('id','uid');
        return view('edit-review')->with($data);
    }

    public function updateReview($id,$uid,Request $request){
        DB::table('reviews')->where('id',$uid)->update(array(
            'name'=> $request->name,
            'date'=> $request->date,
            'review'=> $request->text,
            'rating'=> $request->rating,
        ));
        $query = "select * from reviews where product_id = ".$id;
        $reviews = DB::select($query);
        $data = compact('id','reviews');
        return view('admin-details')->with($data);
    }
}
