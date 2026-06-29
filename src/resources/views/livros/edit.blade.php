@extends('layouts.app')

@section('title', 'Editar Livro')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil me-2"></i>Editar Livro: {{ $livro->Titulo }}
            </div>
            <div class="card-body">
                <form action="{{ route('livros.update', $livro) }}" method="POST" novalidate>
                    @csrf @method('PUT')
                    @include('livros._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i>Atualizar
                        </button>
                        <a href="{{ route('livros.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
