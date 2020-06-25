@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('users.create') }}">Cadastrar Usuário</a>
                <h4>Lista de Usuários</h4>
            </div>
            <div class="card-body">
                @if(count($users) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->deleted_at)
                                Desativado
                                @else
                                Ativado
                                @endif
                            </td>
                            <td class="td-actions text-right">
                                <a href="{{ route('users.show', [$user->id]) }}">
                                    <button title="Mais Detalhes" type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm " data-original-title="">
                                        <i class="fa fa-eye pt-1"></i>
                                    </button>
                                </a>
                                <a href="{{ route('users.edit', [$user->id]) }}">
                                    <button title="Editar"type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="">
                                        <i class="fa fa-edit pt-1"></i>
                                    </button>
                                </a>
                                @if($user->deleted_at)
                                <a href="{{ route('users.confirmRestore', [$user->id]) }}">
                                    <button title="Ativar" type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm " data-original-title="">
                                        <i class="fa fa-check pt-1"></i>
                                    </button>
                                </a>
                                @else
                                <a href="{{ route('users.confirmDelete', [$user->id]) }}">
                                    <button title="Desativar" type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="">
                                        <i class="fa fa-trash pt-1"></i>
                                    </button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        {{ $users->links() }}
                    </tbody>
                </table>
                @else 
                <h5>Parece que só há você por aqui. Clique <a href="{{ route('users.create') }}">aqui</a> para cadastrar um novo usuário</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
