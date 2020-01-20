<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

use App\History;
use Carbon\Carbon;

class NewsController extends Controller
{
    // 以下を追記
  public function add()
  {
      return view('admin.news.create');
  }
  
  //以下を追記
  public function create(Request $request){
      
      //varidation
      $this->validate($request,News::$rules);
      
      $news= new News;
      $form = $request->all();
      
      //フォームから画像が送信されてきたら、保存して、$news->image_pathに画像のパスを保存する
      if (isset($form['image'])){
          $path = $request->file('image')->store('public/image');
          $news->image_path = basename($path);
      }else{
          $news->image_path = null;
      }
      
      //フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      //フォームから送信されてきたimageを削除する
      unset($form['image']);
      
      //データベースに保存する
      $news->fill($form);
      $news->save();
      
      // admin/news/createにリダイレクトする
      return redirect('admin/news/create');
  }
  
  public function index(Request $request){
      $cond_title=$request->cond_title;
      if($cond_title !=''){
          //検索されたら検索結果を取得する
          $posts = News::where('title', $cond_title)->get();
      } else {
          $posts = News::all();
      }
      return view('admin.news.index',['posts'=>$posts,'cond_title'=>$cond_title]);
  }
  
  public function edit(Request $request){
      //News Modelからデータを取得する
      $news = News::find($request->id);
      if(empty($news)){
          abort(404);
      }
      return view('admin.news.edit',['news_form' => $news]);
  }
  
  public function update(Request $request){
      //Validationをかける
      $this->validate($request, News::$rules);
      //News modelからデータを取得する
      $news = News::find($request->id);
      //送信されてきたフォームデータを格納する
      $news_form = $request->all();
      
      if(isset($news_form['image'])){
          $path = $request->file('image')->store('public/image');
          $news->image_path = basename($path);
          unset($news_form['image']);
      } elseif (isset($request->remove)){
          $news->image_path=null;
          unset($news_form['remove']);
      }
      
      unset($news_form['_token']);
      
      //該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      $history = new History;
      $history->news_id=$news->id;
      $history->edited_at=Carbon::now();
      $history->save();
      
      return redirect('admin/news');
  }
  public function delete(Request $request){
      //該当するNews Modelを取得
      $news = News::find($request->id);
      //削除する
      $news->delete();
      return redirect('admin/news/');
  }
}
