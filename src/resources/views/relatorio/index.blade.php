@extends('layouts.app')
@section('title', 'Relatório — Livros por Autor')
@section('content')

<div class="relatorio-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1"><i class="bi bi-file-earmark-bar-graph me-2"></i>Relatório: Livros por Autor</h4>
        <small>Gerado em: {{ now()->format('d/m/Y H:i') }}</small>
    </div>
    <a href="{{ route('relatorio.pdf') }}" class="btn btn-light" target="_blank">
        <i class="bi bi-file-pdf me-1 text-danger"></i>Exportar PDF
    </a>
</div>

@if($dados->isEmpty())
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Nenhum dado disponível. Cadastre livros com autores para visualizar o relatório.
    </div>
@else
    @foreach($dados as $codAu => $livros)
        @php $primeiroLivro = $livros->first(); @endphp
        <div class="card autor-bloco mb-3">
            <div class="autor-nome">
                <i class="bi bi-person-fill me-2"></i>
                {{ $primeiroLivro->autor_nome }}
                <span class="badge bg-primary ms-2">{{ $livros->count() }} livro(s)</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Editora</th>
                            <th class="text-center">Edição</th>
                            <th class="text-center">Ano</th>
                            <th class="text-end">Valor</th>
                            <th>Assuntos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($livros as $livro)
                            <tr>
                                <td class="text-muted small">{{ $livro->Codl }}</td>
                                <td><strong>{{ $livro->Titulo }}</strong></td>
                                <td>{{ $livro->Editora }}</td>
                                <td class="text-center">{{ $livro->Edicao }}ª</td>
                                <td class="text-center">{{ $livro->AnoPublicacao }}</td>
                                <td class="text-end">R$ {{ number_format($livro->Valor, 2, ',', '.') }}</td>
                                <td>
                                    @if($livro->assuntos)
                                        @foreach(explode(', ', $livro->assuntos) as $assunto)
                                            <span class="badge badge-assunto me-1">{{ $assunto }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endif

@endsection
