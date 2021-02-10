<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    //�R�����g�V�K�o�^
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
    
    //�R�����g�X�V
    public function update($comment_id, Request $request)
    {
        $validator  = Validator::make($request->all(), [
          'body' => ['required', 'max:2000'],
        ]);
        $comment = Comment::findOrFail($comment_id);
        if ($validator->fails()) {
          //�R�����gID�X�V���̃G���[���b�Z�[�W���Z�b�g[withInput]�Z�b�V����(_old_input)�Z�b�g[withErrors]�G���[�Z�b�g
          return redirect()->route('posts.show', ['post' => $comment->post_id])
                           ->withInput([$comment_id.'body' => $request->body])
                           ->withErrors([$comment_id.'update_body' => $validator->errors()->first()]);
        }
        $comment->body = $request->body;
        $comment->save();
        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }
    
    //�R�����g�폜
    public function destroy($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        \DB::transaction(function () use ($comment) {
            $comment->delete();
        });

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }
}