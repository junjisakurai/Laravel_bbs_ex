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
                    <div class="border-top p-4">
                        <div class="mb-4 text-right both-end-parent">
                            <time class="text-secondary both-end-left">
                                {{ $comment->created_at->format('Y.m.d H:i') }}
                            </time>
                            '{{$comment->id}}update_body'
                            <div class="both-end-right">
                              <form style="display: inline-block;" method="POST" action="{{ route('comments.update', ['comment' => $comment]) }}">
                                  @csrf
                                  @method('patch')
                                  <input type="hidden" id="{{$comment->id}}update_body" name="{{$comment->id}}update_body" value="あああ">
                                  <input type="button" class="btn btn-primary" id="updateBtn" comment_id="{{$comment->id}}" value="編集する">
                                  <input type="hidden" class="btn btn-primary" id="{{$comment->id}}commentBtn" value="コメントする">
                              </form>
                              <form style="display: inline-block;" method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger">削除する</button>
                              </form>
                            </div>
                        </div>
                        <p class="mt-2" id="{{$comment->id}}comment_body">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                        <textarea id="{{$comment->id}}edit_body" name="body" style="display: none;" class="form-control {{ $errors->has($comment->id.'update_body') ? 'is-invalid' : '' }}" rows="4">{!! (e($comment->body)) !!}</textarea>
                        @if ($errors->has($comment->id.'update_body'))
                            <div class="invalid-feedback">
                                {{ $errors->first($comment->id.'update_body') }}
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