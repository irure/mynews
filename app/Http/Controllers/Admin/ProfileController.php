<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;
use Carbon\Carbon;
use App\profileHistory;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profiles::$rules);
        
        $profile = new Profiles;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        //profile モデルからデータを受け取る
        $profile = Profiles::find($request->id);
        if(empty($profile)){
            abort(404);
        }
        return view('admin.profile.edit',['profile_form'=>$profile]);
    }

    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request,Profiles::$rules);
        //Profile Modelからデータを取得
        $profile = Profiles::find($request->id);
        //送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        
        unset($profile_form['_token']);
        //該当するデータを上書きして保存
        $profile->fill($profile_form)->save();
        
        $profileHistory = new profileHistory;
        $profileHistory->profiles_id = $profile->id;
        $profileHistory->edited_at=Carbon::now();
        $profileHistory->save();
        
        return redirect('admin/profile');
    }
    
    public function delete(Request $request){
        //該当するprofile modelを取得
        $profile = Profiles::find($request->id);
        //削除する
        $profile->delete();
        return redirect('admin/profile/');
    }
    
    public function index(Request $request){
        $posts = Profiles::all();
        return view('admin.profile.index',['posts'=>$posts]);
    }
}
