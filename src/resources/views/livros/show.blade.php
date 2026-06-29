@extends('layouts.app')

@section('title', $livro->Titulo)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-book me-2"></i>Detalhes do Livro
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Código</dt>
                    <dd class="col-sm-8">{{ $livro->Codl }}</dd>

                    <dt class="col-sm-4">Título</dt>
                    <dd class="col-sm-8">{{ $livro->Titulo }}</dd>

                    <dt class="col-sm-4">Editora</dt>
                    <dd class="col-sm-8">{{ $livro->Editora }}</dd>

                    <dt class="col-sm-4">Edição</dt>
                    <dd class="col-sm-8">{{ $livro->Edicao }}ª edição</dd>

                    <dt class="col-sm-4">Ano de Publicação</dt>
                    <dd class="col-sm-8">{{ $livro->AnoPublicacao }}</dd>

                    <dt class="col-sm-4">Valor</dt>
                    <dd class="col-sm-8">
                        <strong class="text-success">
                            R$ {{ number_format($livro->Valor, 2, ',', '.') }}
                        </strong>
                    </dd>

                    <dt class="col-sm-4">Autores</dt>
                    <dd class="col-sm-8">
                        @foreach($livro->autores as $autor)
                            <span class="badge badge-autor me-1 mb-1">{{ $autor->Nome }}</span>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4">Assuntos</dt>
                    <dd class="col-sm-8">
                        @forelse($livro->assuntos as $assunto)
                            <span class="badge badge-assunto me-1 mb-1">{{ $assunto->Descricao }}</span>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                    </dd>
                </dl>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('livros.edit', $livro) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <a href="{{ route('livros.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
