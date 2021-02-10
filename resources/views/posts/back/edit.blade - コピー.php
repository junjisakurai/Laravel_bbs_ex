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
                      <input type="hidden" value="{{$post->pic_thum()}}" id="is_thum">
                      <canvas id="board" width="460" height="460"></canvas>
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
	
	console.log($('#thum')[0].files[0].name); 
var formData = new FormData(document.forms.post_form);
for (let value of formData.entries()) { 
    console.log(value); 
}
});
if($("#is_thum").attr("value") !== ""){
//document.getElementById("thum").dispatchEvent( document.createEvent( "change" ) ); // イベントを強制的に発生
  //reader.readAsDataURL($('<img src="' + $("#is_thum").attr("value") + '">').[0].currentSrc);http://127.0.0.1:8000/img/upload/74/thum.png
  //reader.readAsDataURL("http://127.0.0.1:8000/img/upload/74/thum.png");
  //let blob = new Blob(["http://127.0.0.1:8000/img/upload/74/thum.png"], {type: 'text/plain'});fetch('https://URL_TO_TARGET_IMAGE')

fetch("http://127.0.0.1:8000/img/upload/74/thum.png")
  .then(response => response.blob())
  .then(blob => new File([blob], "thum.png"))
  .then(file => {
    // fileはFileオブジェクト
    //reader.readAsDataURL(file);
    var formData = new FormData(document.forms.post_form);
    //formData.set("thum",file);
for (let value of formData.entries()) { 
    console.log(value); 
}
  })
  
  //var canvas = document.getElementById("board");
  //const ctx = board.getContext("2d");
  // 画像読み込み
  //const chara = new Image();
  //chara.src = "http://127.0.0.1:8000/img/upload/74/thum.png";  // 画像のURLを指定
  //chara.onload = () => {
    //ctx.drawImage(chara, 0, 0);
  //};
  //canvas.toBlob(function(blob) {
    //reader.readAsDataURL(blob);
  //});
  
}

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