@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="float-right" href="{{ route('users.index') }}">Voltar para lista de usuários</a>
                    Cadastrar novo usuário
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', [$user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name" class="col-form-label">Nome do Usuário</label>

                                <input required class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="col-form-label">E-mail do Usuário</label>

                                <input required class="form-control" type="email" name="email" id="email" value="{{ $user->email }}">
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
