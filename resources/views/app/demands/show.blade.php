@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a class="float-right" href="{{ route('demands.index') }}">Voltar para lista de demandas</a>
                Mais detalhes sobre <u>{{ $demand->demand }}</u>
            </div>
            <div class="card-body">
                <ul>
                    <li>ID => {{ $demand->id }}</li>
                    <li>Demanda => {{ $demand->demand }}</li>
                    <li>Prioridade => {{ $demand->priority }}</li>
                    <li>Detalhes => {{ $demand->description }}</li>
                    <li>Cadastrado em => {{ $demand->created_at }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection