@extends('layouts.app')

@section('content')
  // 検索機能
  <div>
    <form action="{{ route('items.index') }}" method="GET">
      <input type="text" name="keyword" value="{{ $keyword }}">
      <input type="submit" value="検索">
    </form>
  </div>

  <table>
    <tr>
      <th>Item Id</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <td></td>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->description}}</td>
        <td>{{$item->price}}</td>
        <td><a href="/items/{{$item->id}}">Details</a></td> // showページへのリンク
      </tr>
    @endforeach
  </table>
@endsection