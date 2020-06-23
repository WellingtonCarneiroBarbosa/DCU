@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a class="float-right" href="{{ route('home') }}">Voltar para tickets em aberto</a>
                    Responder ticket
                </div>
                <div class="card-body">
                    @if(! $ticket['user_id'])
                    <h5>Atenção! Este ticket será movido para a seção "em andamento"</h5>
                    @endif
                    <form action="{{ route('tickets.response', [$ticket->id]) }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label">Resposta</label>

                                <textarea required class="form-control" name="message" id="message" cols="30" rows="10" required>{{ old('message') }}</textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
