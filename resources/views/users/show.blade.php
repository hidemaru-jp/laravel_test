@extends('layouts.app')

@section('content')
  <table>
    <tr>
      <th>名前</th>
      <th>Email</th>
      <th>電話番号</th>
    </tr>
      <tr>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->mobile_phone_number}}</td>
      </tr>
  </table>
  <a href="/users/{{$user->id}}/edit">Edit</a>
  
  
  <a href="/items">商品一覧へ</a>

@endsection