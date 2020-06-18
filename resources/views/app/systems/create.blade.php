@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a class="float-right" href="{{ route('systems.index') }}">Voltar para lista de sistemas</a>
                    Cadastrar novo sistema
                </div>
                <div class="card-body">
                    <form action="{{ route('systems.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label">Nome do Sistema</label>

                                <input required class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
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
