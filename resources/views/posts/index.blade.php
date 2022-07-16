@extends('layouts.app')

@section('title', 'Blog posts')

@section('content')


@each('posts.partials.post',$posts,'post')



@endsection