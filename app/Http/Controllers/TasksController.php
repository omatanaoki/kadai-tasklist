<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;    // 追加

class TasksController extends Controller
{
     public function index()
    {
        
         {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->get();

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
             
            return view('tasks.index', $data);
            
        }else{

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
         }  
      
    }

    

      // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
    
    

   // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
         // バリデーション
        $request->validate([
             'status' => 'required|max:10',   // 追加
             
            'content' => 'required|max:100',
             
        ]);
        
        // メッセージを作成
        $task = new Task;
        $task->status = $request->status;    // 追加
        $task->user_id = \Auth::user()->id;  // 追加
        $task->content = $request->content;
        $task->save();
        
        

        // トップページへリダイレクトさせる
        return redirect('/');
        
       
    }
    
    
     // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
    if (\Auth::id() === $task->user_id){
        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
        
    }
    
        // トップページへリダイレクトさせる
        return redirect('/');
}

   // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task =Task::findOrFail($id);
        
    if (\Auth::id() === $task->user_id){
        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
         
    }
     
        // トップページへリダイレクトさせる
        return redirect('/');
}
    // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
             'status' => 'required|max:10',   // 追加
             
            'content' => 'required|max:100',
             
        ]);
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id){
        // メッセージを更新
         $task->status = $request->status;    // 追加
        $task->user_id = \Auth::user()->id;   // 追加
        $task->content = $request->content;
        $task->save();
        
    }
    
        // トップページへリダイレクトさせる
        return redirect('/');
}
  // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        
      
         // idの値で投稿を検索して取得
        $task = \App\Task::findOrFail($id);
      
        
         // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
             
       
    }
        // トップページへリダイレクトさせる
        return redirect('/');
}
}