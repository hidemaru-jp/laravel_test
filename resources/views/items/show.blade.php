@extends('layouts.app')

@section('content')
  <table>
    <tr>
      <th>Item Id</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
    </tr>
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->description}}</td>
        <td>{{$item->price}}</td>
      </tr>
  </table>
  <a href="/items/{{$item->id}}/edit">Edit</a>
  
  <form action="/items/{{$item->id}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete">
    <input type="submit" name="" value="Delete">
  </form>
  
  <a href="/items">Back to index</a>

  <form action="/cart" method="POST" class="item-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="item_id" value={{$item->id}}>
    <input type="hidden" name="name" value="{{$item->name}}">
    <input type="hidden" name="price" value={{$item->price}}>
    <input type="text" name="quantity" value="1">
    <button type="submit" class="btn-sm btn-blue">カートに入れる</button>
  </form>
@endsection