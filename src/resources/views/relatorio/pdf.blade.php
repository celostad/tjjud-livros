<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório — Livros por Autor</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #212529; }
        h1 { font-size: 15px; color: #0d47a1; border-bottom: 2px solid #0d47a1; padding-bottom: 5px; margin-bottom: 4px; }
        .subtitulo { color: #666; font-size: 9px; margin-bottom: 16px; }
        .autor-header { background-color: #0d47a1; color: #fff; padding: 5px 10px; font-weight: bold; font-size: 12px; margin-top: 14px; margin-bottom: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 0; }
        th { background-color: #e3f2fd; color: #0d47a1; text-align: left; padding: 4px 6px; font-size: 9px; text-transform: uppercase; border-bottom: 1px solid #90caf9; }
        td { padding: 4px 6px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) td { background-color: #fafafa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; border-top: 1px solid #ddd; padding-top: 6px; color: #999; font-size: 9px; text-align: center; }
        .badge { background-color: #e8f5e9; color: #2e7d32; padding: 1px 4px; border-radius: 3px; font-size: 8px; margin-right: 2px; }
    </style>
</head>
<body>
    <h1><i></i> Relatório — Livros por Autor</h1>
    <div class="subtitulo">Gerado em: {{ now()->format('d/m/Y H:i:s') }}</div>

    @if($dados->isEmpty())
        <p>Nenhum dado disponível.</p>
    @else
        @foreach($dados as $codAu => $livros)
            @php $primeiro = $livros->first(); @endphp
            <div class="autor-header">
                Autor: {{ $primeiro->autor_nome }}
                ({{ $livros->count() }} livro(s))
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Editora</th>
                        <th class="text-center">Edição</th>
                        <th class="text-center">Ano</th>
                        <th class="text-right">Valor</th>
                        <th>Assuntos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($livros as $livro)
                        <tr>
                            <td>{{ $livro->Codl }}</td>
                            <td><strong>{{ $livro->Titulo }}</strong></td>
                            <td>{{ $livro->Editora }}</td>
                            <td class="text-center">{{ $livro->Edicao }}ª</td>
                            <td class="text-center">{{ $livro->AnoPublicacao }}</td>
                            <td class="text-right">R$ {{ number_format($livro->Valor, 2, ',', '.') }}</td>
                            <td>
                                @if($livro->assuntos)
                                    @foreach(explode(', ', $livro->assuntos) as $assunto)
                                        <span class="badge">{{ $assunto }}</span>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif

    <div class="footer">
        Cadastro de Livros — Teste Técnico TJJUD &bull; PHP 8.3 + Laravel + MySQL 8
    </div>
</body>
</html>
