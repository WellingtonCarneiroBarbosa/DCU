@extends('layouts.app')

@section('content')
    <div class="container">
       <div class="row justify-content-center">
           <div class="col-md-8">
               <div class="card">
                   <div class="card-header">
                       <div class="float-right">
                           <a href="{{ route('tickets.messages', [$ticket->id]) }}">Visualizar mensagens</a>
                       </div>
                       <h5>Visualizar Ticket</h5>
                    </div>
                   <div class="card-body">
                       <h6>Sobre o cliente:</h6>
                       <ul>
                           <li>Nome: {{ $ticket->client['name'] }}</li>
                           <li>E-mail: {{ $ticket->client['email'] }}</li>
                           <li>Sistema: {{ $ticket->client->system['name'] }}</li>
                       </ul>
                       <h6>Sobre o ticket:</h6>
                       <ul>
                           <li>Ticket ID: {{ $ticket->id }}</li>
                           <li>Categoria: {{ $ticket->demand['demand'] }}</li>
                           <li>
                               Status: 
                               @if(! $ticket->user_id)
                               em aberto 
                               @elseif(! $ticket->deleted_at)
                               em andamento 
                               @else 
                               resolvido 
                               @endif
                            </li>
                            @if($ticket->user_id)
                            <li>Responsável: {{ $ticket->user_id }}</li>
                            @endif 
                            <li>Aberto em: {{ $ticket->created_at }}</li>
                            @if($ticket->deleted_at)
                            <li>Fechado em: {{ $ticket->deleted_at }}</li>
                            @endif
                       </ul>
                   </div>
               </div>
           </div>
        </div> 
    </div>
@endsection