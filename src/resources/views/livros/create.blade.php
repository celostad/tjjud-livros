@extends('layouts.app')

@section('title', 'Novo Livro')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Cadastrar Livro
            </div>
            <div class="card-body">
                <form action="{{ route('livros.store') }}" method="POST" novalidate>
                    @csrf
                    @include('livros._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Salvar
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
