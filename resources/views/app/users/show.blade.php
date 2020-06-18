@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('users.index') }}">Voltar para lista de usuários</a>
                Mais detalhes sobre <u>{{ $user->name }}</u>
            </div>
            <div class="card-body">
                <ul>
                    <li>ID => {{ $user->id }}</li>
                    <li>Nome => {{ $user->name }}</li>
                    <li>E-mail => {{ $user->email }}</li>
                    <li>Cadastrado em => {{ $user->created_at }}</li>
                    @if($user->deleted_at)
                    <li>Desativado em => {{ $user->deleted_at }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection