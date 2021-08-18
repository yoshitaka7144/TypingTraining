@extends("question/layout")
@section("content")
<div class="container ops-main">
  <div class="row">
    <div class="col-md-6">
      <h2>問題登録</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-1">
      <form action="/question/{{ $question->id }}" method="post">
        <!-- updateメソッドにはPUTメソッドがルーティングされているのでPUTにする -->
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label for="category">カテゴリー</label>
          <input type="text" class="form-control" name="category" value="{{ $question->category }}">
        </div>
        <div class="form-group">
          <label for="question">問題</label>
          <input type="text" class="form-control" name="text" value="{{ $question->text }}">
        </div>
        <div class="form-group">
          <label for="kana">かな</label>
          <input type="text" class="form-control" name="kana" value="{{ $question->kana }}">
        </div>
        <button type="submit" class="btn btn-default">登録</button>
        <a href="/question">戻る</a>
      </form>
    </div>
  </div>
</div>
@endsection