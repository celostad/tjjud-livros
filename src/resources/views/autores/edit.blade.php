@extends('layouts.app')
@section('title', 'Editar Autor')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2"></i>Editar Autor</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif
                <form action="{{ route('autores.update', $autor) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="Nome" class="form-label required-star">Nome</label>
                        <input type="text" name="Nome" id="Nome" maxlength="40"
                               class="form-control @error('Nome') is-invalid @enderror"
                               value="{{ old('Nome', $autor->Nome) }}" required>
                        @error('Nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Atualizar</button>
                        <a href="{{ route('autores.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
