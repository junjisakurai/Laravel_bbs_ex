<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Log;

class PostsController extends Controller
{
    public function index()
    {
        //$posts = Post::orderBy('created_at', 'desc')->paginate(10);
        //$posts = Post::latest()->get();
        $posts = Post::with(['comments'])->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index')->with('posts', $posts);
    }
    
    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->fill($request->all())->save();
        // ���R�[�h��}�������Ƃ���ID���擾
        $lastInsertedId = $post->id;

        $this->uploadImage($request->file('thum'), $lastInsertedId);
        
        return redirect()->route('top');
    }
    
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.show', [
            'post' => $post,
        ]);
    }
    
    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update($post_id, PostRequest $request)
    {
        $post = Post::findOrFail($post_id);
        $post->fill($request->all())->save();
        // ���R�[�h��}�������Ƃ���ID���擾
        $lastInsertedId = $post_id;
        
        $this->uploadImage($request->file('thum'), $lastInsertedId);
        
        return redirect()->route('posts.show', ['post' => $post]);
    }
    
    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        \DB::transaction(function () use ($post) {
            $post->comments()->delete();
            $post->delete();
        });
        //���R�[�h�̃f�B���N�g�����ƍ폜
        $imgPath = public_path() . \Config::get('fpath.thum') . $post_id;
        unlink(glob($imgPath . '/thum.*')[0]); //�t�@�C���폜
        rmdir($imgPath);//�f�B���N�g���폜

        return redirect()->route('top');
    }
    
    private function uploadImage($reqFile, $lastInsertedId)
    {
        if(!is_null($reqFile) ){
          //�摜5���ȏ�̏ꍇ�A�ŏ�ID����폜
          $path= public_path() .\Config::get('fpath.thum');
          $files = glob($path . '\*');
          if(count($files) > 5){
              $minIdDirectory = $files[count($files) -1];
              unlink(glob($minIdDirectory . '/thum.*')[0]); //�t�@�C���폜
              rmdir($minIdDirectory);//�f�B���N�g���폜
          }
          // �f�B���N�g�����쐬
          if (!file_exists(public_path() .\Config::get('fpath.thum') . $lastInsertedId)) {
            mkdir(public_path() . \Config::get('fpath.thum') . $lastInsertedId, 0777);
          }

          // �{�Ԃ̊i�[�ꏊ�ֈړ� [guessExtension()]�g���q�擾
          $reqFile->move(public_path() . \Config::get('fpath.thum') . $lastInsertedId, "thum." . $reqFile->guessExtension());
        }
    }

}
