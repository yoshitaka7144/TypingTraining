@extends("question/layout")
@section("content")
<div class="container ops-main">
  <div class="row">
    <div class="col-md-12">
      <h3 class="ops-title">問題一覧</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-11 col-md-offset-1">
      <table class="table text-center">
        <tr>
          <th class="text-center">ID</th>
          <th class="text-center">カテゴリー</th>
          <th class="text-center">問題</th>
          <th class="text-center">かな</th>
          <th class="text-center">編集者</th>
        </tr>
        @foreach($questions as $question)
        <tr>
          <td>
            <a href="/question/{{ $question->id }}/edit">{{ $question->id }}</a>
          </td>
          <td>{{ $question->category }}</td>
          <td>{{ $question->text }}</td>
          <td>{{ $question->kana }}</td>
          <td>{{ $question->editor }}</td>
          <td>
            <form action="/question/{{ $question->id }}" method="post">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-xs btn-danger" aria-label="Left Align"><span class="glyphicon glyphicon-trash"></span></button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
      <div><a href="/question/create" class="btn btn-default">新規作成</a></div>
    </div>
  </div>
</div>
@endsection