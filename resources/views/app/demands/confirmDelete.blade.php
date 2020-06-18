@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('demands.index') }}">Não, voltar para lista de demandas</a>
                Deseja mesmo deletar <u>{{ $demand->demand }}</u> ?
            </div>
            <div class="card-body">
                <h5>Atenção! Os tickets que possuírem esta demanda receberão a demanda como indefinido</h5>
                <h5 class="text-danger">Há {{ $howManyTicketsWithThisDemand }} tickets com esta demanda</h5 class="text-alert">
                <span class="mt-2">Detalhes da demanda</span>
                <ul>
                    <li>ID => {{ $demand->id }}</li>
                    <li>Demanda => {{ $demand->demand }}</li>
                    <li>Prioridade => {{ $demand->priority }}</li>
                    <li>Detalhes => {{ $demand->description }}</li>
                    <li>Cadastrado em => {{ $demand->created_at }}</li>
                </ul>
                <div class="float-right">
                    <form action="{{ route('demands.destroy', [$demand->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
    
                        <a href="{{ route('demands.index') }}">
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