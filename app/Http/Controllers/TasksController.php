<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;    // 追加

class TasksController extends Controller
{
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // メッセージ一覧を取得
        $tasks = Task::all();

        // メッセージ一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
   


      // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $message = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'message' => $message,
        ]);
    }

   // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // メッセージを作成
        $message = new Task;
        $message->content = $request->content;
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
     // getでmessages/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'message' => $message,
        ]);
    }

   // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $message =Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'message' => $message,
        ]);
    }

    // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);
        // メッセージを更新
        $message->content = $request->content;
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

  // deleteでmessages/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $message = Task::findOrFail($id);
        // メッセージを削除
        $message->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}