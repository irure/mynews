<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\HTML;

use App\Profiles;

class ProfileController extends Controller
{
    //
    public function index(Request $request){
        $posts = Profiles::all()->sortByDesc('updated_at');
    
//        if (count($posts)>0){
//            $headline = $posts->shift();
//        }else{
//            $headline = null;
//        }
        
        // news/index.blade.phpファイルを渡している
        //また viewテンプレートにheadline,postsと言う変数を渡している
        return view('profile.index',['posts'=>$posts]);
    }
}
