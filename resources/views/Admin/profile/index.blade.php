@extends('adminlte::page')
@section('title', "Meu Perfil")
@section('content_header')
<h1>Meu Perfil</h1>
@endsection
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            <h5><i class="icon fas fa-ban">...</i>Ocorreu um erro.</h5>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-success">
        {{session('warning')}}
    </div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{route('profile.save')}}" method="POST" class="form-horizontal">
        @method('PUT')
        @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label"> Nome Completo</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->name}}" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" />
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label"> E-mail</label>
                <div class="col-sm-10">
                    <input type="email" name="email" value="{{$user->email}}" id="email"
                        class="form-control @error('email') is-invalid @enderror" />
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Nova Senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" />
                </div>
            </div>
            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-2 col-form-label"> Confirmar Senha</label>
                <div class="col-sm-10">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-2">
                    <input method="POST" type="submit" value="Editar"
                        class="form-control " />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

