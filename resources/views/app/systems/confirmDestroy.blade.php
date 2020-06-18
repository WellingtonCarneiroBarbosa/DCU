@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('systems.index') }}">Não, voltar para lista de sistemas</a>
                Deseja mesmo deletar <u>{{ $system->name }}</u> ?
            </div>
            <div class="card-body">
                <h5>
                   Atenção! Este sistema será deletado. O sistema não conseguirá mais
                   realizar contato com a API do {{ config('app.name') }}
                </h5>
                <span class="mt-2">Detalhes do sistema</span>
                <ul>
                    <li>Nome => {{ $system->name }}</li>
                    <li>Token => {{ $system->token }}</li>
                    <li>Cadastrado em => {{ $system->created_at }}</li>
                </ul>
                <div class="float-right">
                    <form action="{{ route('systems.destroy', [$system->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
    
                        <a href="{{ route('systems.index') }}">
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