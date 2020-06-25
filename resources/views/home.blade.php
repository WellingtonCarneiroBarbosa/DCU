@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h5>Tickets em Aberto</h5>
    </div>
    
        @if(count($tickets) > 0) 
        <div class="row">
            @foreach($tickets as $tk)
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header">Demanda: {{ $tk->demand['demand'] }}</div>

                    <div class="card-body">
                        <div class="row mb-2">Mensagem: {{ $tk->message }}</div>
                        <div class="row mb-2">Aberto por <u class="mr-1 ml-1">{{ $tk->client['name'] }}</u> {{ $tk->created_at->diffForHumans() }}</div>
                        <a href="{{ route('tickets.show', [$tk->id]) }}">
                            <button class="btn btn-primary">Visualizar</button>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $tickets->links() }}
        </div>
        @else 
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Tickets</div>

                    <div class="card-body">
                        Não há tickets em aberto no momento.
                        @if($qtd_in_progress_tickets != 0)
                        Você possui {{ $qtd_in_progress_tickets }} ticket(s) em andamento
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

</div>
@endsection
