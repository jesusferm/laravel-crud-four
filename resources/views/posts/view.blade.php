<?php
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\TodoController;
?>
@extends('layouts.app')
@section('content')
@section('title', 'Visualizando')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{url('/')}}"><i class="fa fa-home"></i> Inicio</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Visualizando</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<h1 class="border-bottom border-bottom-1">
						{{$todo->title}}
					</h1>
					<p class="d-inline-block post-meta">
						Por <a href="" class="post-meta-author">{{$todo->name}}</a> - <a href="" class="post-meta-date">{{TodoController::nicetime($todo->created_at)}}</a>
					</p>
					<p class="d-inline-block float-right post-comments">
						<a href="" class=""><i class=" fa fa-comments"></i> 0 comentarios</a>
					</p>
				</div>
				<div class="col-md-12">
					<img class="img-fluid" src="{{($todo->nom_img!=''?asset('public').'/'.$todo->dir_files.$todo->nom_img: asset('public/images/default.svg'))}}"/>
				</div>
				<div class="col-md-3 mt-4">
					<h4 class="related-posts-title">
						Entradas recientes <i class="fa fa-arrow-right"></i>
					</h4>
				</div>
				<div class="col-md-9 mt-4">
					<div class="todo-description">
						{!!$todo->description!!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection