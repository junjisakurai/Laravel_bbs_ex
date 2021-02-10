<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    //コメント新規登録
    public function store(Request $request)
    {
        $params = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|max:2000',
        ]);
        $post = Post::findOrFail($params['post_id']);
        $post->comments()->create($params);

        return redirect()->route('posts.show', ['post' => $post]);
    }
    
    //コメント更新
    public function update($comment_id, Request $request)
    {
        $validator  = Validator::make($request->all(), [
          'body' => ['required', 'max:2000'],
        ]);
        $comment = Comment::findOrFail($comment_id);
        if ($validator->fails()) {
          //コメントID更新文のエラーメッセージをセット[withInput]セッション(_old_input)セット[withErrors]エラーセット
          return redirect()->route('posts.show', ['post' => $comment->post_id])
                           ->withInput([$comment_id.'body' => $request->body])
                           ->withErrors([$comment_id.'update_body' => $validator->errors()->first()]);
        }
        $comment->body = $request->body;
        $comment->save();
        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }
    
    //コメント削除
    public function destroy($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        \DB::transaction(function () use ($comment) {
            $comment->delete();
        });

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }
}