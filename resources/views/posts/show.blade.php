@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <div class="mb-4 text-right">
                <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post]) }}">
                    編集する
                </a>
                <form style="display: inline-block;" method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">削除する</button>
                </form>
            </div>
            <h1 class="h5 mb-4">
                {{ $post->title }}
            </h1>

            <p class="mb-5">
                {!! nl2br(e($post->body)) !!}
            </p>
            <img src="{{$post->pic_thum()}}" width="150"/>
            <section>
                <h2 class="h5 mb-4">
                    コメント
                </h2>
                <form class="mb-4" method="POST" action="{{ route('comments.store') }}">
                    @csrf

                    <input
                        name="post_id"
                        type="hidden"
                        value="{{ $post->id }}"
                    >

                    <div class="form-group">
                        <label for="body">
                            本文
                        </label>

                        <textarea
                            id="body"
                            name="body"
                            class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                            rows="4"
                        >{{ old('body') }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                {{ $errors->first('body') }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            コメントする
                        </button>
                    </div>
                </form>
                @forelse($post->comments as $comment)
                    <?php $update_body = $comment->id.'update_body'; ?>
                    <?php $is_update_body = $errors->has($update_body) ? true : false; ?>
                    <div class="border-top p-4">
                        <div class="mb-4 text-right both-end-parent">
                            <time class="text-secondary both-end-left">
                                {{ $comment->created_at->format('Y.m.d H:i') }}
                            </time>
                            <div class="both-end-right">
                              <form style="display: inline-block;" method="POST" action="{{ route('comments.update', ['comment' => $comment]) }}" onsubmit="return check({{$comment->id}})">
                                  @csrf
                                  @method('patch')
                                  <input type="hidden" class="form-control" id="{{$comment->id}}body" name="body" value="">
                                  <input type="{{ $is_update_body ? 'hidden' : 'button' }}" class="btn btn-primary" id="updateBtn{{$comment->id}}" comment_id="{{$comment->id}}" value="編集する">
                                  <input type="{{ $is_update_body ? 'submit' : 'hidden' }}" class="btn btn-primary" id="{{$comment->id}}commentBtn" value="コメントする">
                              </form>
                              <form style="display: inline-block;" method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger">削除する</button>
                              </form>
                            </div>
                        </div>
                        <p class="mt-2" id="{{$comment->id}}comment_body" style="display: {{ $is_update_body ? 'none' : 'block' }};">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                        <textarea id="{{$comment->id}}edit_body" name="body" style="display: {{ $is_update_body ? 'block' : 'none' }};" 
                         class="form-control {{ $is_update_body ? 'is-invalid' : '' }}" rows="4">{{ old($comment->id.'body' , e($comment->body) ) }}</textarea>
                         
                        @if ($is_update_body)
                            <div class="invalid-feedback">
                                {{ $errors->first($update_body) }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>
<script src="{{ asset('/js/show.js') }}"></script>
@endsection