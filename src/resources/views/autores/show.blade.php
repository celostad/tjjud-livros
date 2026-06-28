@extends('layouts.app')
@section('title', $autor->Nome)
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-person me-2"></i>Detalhes do Autor</div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Código</dt><dd class="col-sm-8">{{ $autor->CodAu }}</dd>
                    <dt class="col-sm-4">Nome</dt><dd class="col-sm-8">{{ $autor->Nome }}</dd>
                    <dt class="col-sm-4">Livros</dt>
                    <dd class="col-sm-8">
                        @forelse($autor->livros as $livro)
                            <a href="{{ route('livros.show', $livro) }}" class="badge badge-autor text-decoration-none me-1">{{ $livro->Titulo }}</a>
                        @empty
                            <span class="text-muted">Nenhum livro vinculado.</span>
                        @endforelse
                    </dd>
                </dl>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('autores.edit', $autor) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil me-1"></i>Editar</a>
                <a href="{{ route('autores.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
