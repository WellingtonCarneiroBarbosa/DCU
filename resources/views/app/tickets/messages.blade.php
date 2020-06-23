@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(! $ticket->deleted_at)
                        <div class="float-right"><a href="{{ route('tickets.response', [$ticket->id]) }}">Responder</a></div>
                        @endif
                        Mensagens do Ticket {{ $ticket->id }}
                    </div>
                    <div class="card-body" id="card-messages">
                        <ul>
                            Mensagem principal:
                            <li>{{ $ticket->message }}</li>
                        </ul>
                        <ul>
                            {{ $ticket_messages->links() }}
                            Respostas:
                            @if(count($ticket_messages) > 0 )
                            @foreach ($ticket_messages as $response)
                                @if($response->responsible_id)
                                <li class="mb-2">Suporte: {{ $response->message }} <br> <span class="text-sm">{{ $response->created_at }}</span></li>
                                @else 
                                <li class="mb-2">Cliente: {{ $response->message }} <br> <span class="text-sm">{{ $response->created_at }}</span></li>
                                @endif
                            @endforeach
                            @else 
                            Ainda não há respostas.
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection