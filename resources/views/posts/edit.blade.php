@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の編集
            </h1>

            <form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data" id="post_form">
                @csrf
                @method('PUT')

                <fieldset class="mb-4">
                    <div class="form-group">
                        <label for="title">
                            タイトル
                        </label>
                        <input
                            id="title"
                            name="title"
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            value="{{ old('title') ?: $post->title }}"
                            type="text"
                        >
                        @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="body">
                            本文
                        </label>

                        <textarea
                            id="body"
                            name="body"
                            class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                            rows="4"
                        >{{ old('body') ?: $post->body }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                {{ $errors->first('body') }}
                            </div>
                        @endif
                    </div>

                    <div id="file_drag_drop_area" class="form-group">
                      ここにファイルをドラッグ&ドロップ<br/>
                      <span>　　　　　　または</span><br/>
                      <input id="thum" type="file" accept="image/*" name="thum">
                      @if($errors->has('thum'))<span class="text-danger">{{ $errors->first('thum') }}</span> @endif
                      <img src="{{$post->pic_thum()}}" width="150"/>
                    </div>

                    <div class="mt-5">
                        <a class="btn btn-secondary" href="{{ route('posts.show', ['post' => $post]) }}">
                            キャンセル
                        </a>

                        <button type="submit" class="btn btn-primary">
                            更新する
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<script>
var reader = new FileReader();
reader.addEventListener('load', function() {
	$("img").attr("src",reader.result);
});

//ファイル選択押下から画像選択
$("#thum").on("change",function(e){
	for(var i = 0;i<e.target.files.length ;i++){
		reader.readAsDataURL(e.target.files[i]);
	}
});
//d&dより画像選択
$("#file_drag_drop_area").on("drop",function(e){
	e.preventDefault();
	for(var i = 0;i<e.originalEvent.dataTransfer.files.length ;i++){
		reader.readAsDataURL(e.originalEvent.dataTransfer.files[i]);
	}
});
$("#file_drag_drop_area").on("dragover",function(e){
	e.preventDefault();
});
</script>
@endsection