@extends('layouts.app')
@section('title', 'Editar Assunto')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2"></i>Editar Assunto</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('assuntos.update', $assunto) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="Descricao" class="form-label required-star">Descrição</label>
                        <input type="text" name="Descricao" id="Descricao" maxlength="20"
                               class="form-control @error('Descricao') is-invalid @enderror"
                               value="{{ old('Descricao', $assunto->Descricao) }}" required>
                        <div class="form-text">Máximo 20 caracteres.</div>
                        @error('Descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Atualizar</button>
                        <a href="{{ route('assuntos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
