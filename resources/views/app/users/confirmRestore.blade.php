@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('users.index') }}">Não, voltar para lista de usuários</a>
                Deseja mesmo ativar <u>{{ $user->name }}</u> ?
            </div>
            <div class="card-body">
                <h5>
                    Atenção! Este usuário será ativado.
                    O usuário poderá realizar login e alterações no sistema
                </h5>
                <span class="mt-2">Detalhes do usuário</span>
                <ul>
                    <li>ID => {{ $user->id }}</li>
                    <li>Nome => {{ $user->name }}</li>
                    <li>E-mail => {{ $user->email }}</li>
                    <li>Cadastrado em => {{ $user->created_at }}</li>
                    <li>Desativado em => {{ $user->deleted_at }}</li>
                </ul>
                <div class="float-right">
                    <form action="{{ route('users.restore', [$user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
    
                        <a href="{{ route('users.index') }}">
                            <button type="button" class="btn btn-outline-success">Cancelar</button>
                        </a>
                        <button type="submit" class="btn btn-danger">Compreendo as consequências</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection