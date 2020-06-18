@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('demands.create') }}">Cadastrar Demanda</a>
                <h4>Lista de Demandas</h4>
            </div>
            <div class="card-body">
                @if(count($demands) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Demanda</th>
                            <th>Prioridade</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demands as $demand)
                        <tr>
                            <td class="text-center">{{ $demand->id }}</td>
                            <td>{{ $demand->demand }}</td>
                            <td>
                                @if($demand->priority == 1)
                                Baixa
                                @elseif($demand->priority == 2)
                                Média
                                @elseif($demand->priority == 3)
                                Alta
                                @else
                                Urgente
                                @endif
                            </td>
                            <td class="td-actions text-right">
                                <a href="{{ route('demands.show', [$demand->id]) }}">
                                    <button title="Mais Detalhes" type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm " data-original-title="" title="">
                                        <i class="fa fa-eye pt-1"></i>
                                    </button>
                                </a>
                                <a href="{{ route('demands.edit', [$demand->id]) }}">
                                    <button title="Editar"type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="">
                                        <i class="fa fa-edit pt-1"></i>
                                    </button>
                                </a>
                                <a href="{{ route('demands.confirmDelete', [$demand->id]) }}">
                                    <button title="Excluir" type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm " data-original-title="" title="">
                                        <i class="fa fa-trash pt-1"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <h5>Ainda não há demandas cadastradas. Clique <a href="{{ route('demands.create') }}">aqui</a> para cadastrar uma nova demanda</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
