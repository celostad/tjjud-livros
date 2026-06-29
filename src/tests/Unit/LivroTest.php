<?php

namespace Tests\Unit;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    public function test_livro_pode_ser_criado(): void
    {
        $livro = Livro::create([
            'Titulo'        => 'Teste de Livro',
            'Editora'       => 'Editora Teste',
            'Edicao'        => 1,
            'AnoPublicacao' => '2024',
            'Valor'         => 49.90,
        ]);

        $this->assertDatabaseHas('Livro', ['Titulo' => 'Teste de Livro']);
        $this->assertEquals(49.90, $livro->Valor);
    }

    public function test_livro_pode_ter_multiplos_autores(): void
    {
        $livro  = Livro::create([
            'Titulo' => 'Livro Multiplos Autores', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2024', 'Valor' => 10.00,
        ]);
        $autor1 = Autor::create(['Nome' => 'Autor A']);
        $autor2 = Autor::create(['Nome' => 'Autor B']);

        $livro->autores()->attach([$autor1->CodAu, $autor2->CodAu]);

        $this->assertCount(2, $livro->autores);
    }

    public function test_livro_pode_ter_multiplos_assuntos(): void
    {
        $livro    = Livro::create([
            'Titulo' => 'Livro Assuntos', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2024', 'Valor' => 10.00,
        ]);
        $assunto1 = Assunto::create(['Descricao' => 'Romance']);
        $assunto2 = Assunto::create(['Descricao' => 'Ficção']);

        $livro->assuntos()->attach([$assunto1->codAs, $assunto2->codAs]);

        $this->assertCount(2, $livro->assuntos);
    }

    public function test_excluir_livro_remove_relacionamentos(): void
    {
        $livro  = Livro::create([
            'Titulo' => 'Livro Para Excluir', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2024', 'Valor' => 10.00,
        ]);
        $autor = Autor::create(['Nome' => 'Autor X']);
        $livro->autores()->attach($autor->CodAu);

        $livro->delete();

        $this->assertDatabaseMissing('Livro', ['Titulo' => 'Livro Para Excluir']);
        $this->assertDatabaseMissing('Livro_Autor', ['Livro_Codl' => $livro->Codl]);
    }

    public function test_valor_nao_pode_ser_negativo(): void
    {
        $request = new \App\Http\Requests\LivroRequest();
        // Regra: Valor min:0
        $this->assertContains('min:0', $request->rules()['Valor']);
    }

    public function test_titulo_nao_pode_exceder_40_caracteres(): void
    {
        $request = new \App\Http\Requests\LivroRequest();
        $this->assertContains('max:40', $request->rules()['Titulo']);
    }

    public function test_ano_publicacao_deve_ter_4_digitos(): void
    {
        $request = new \App\Http\Requests\LivroRequest();
        $this->assertContains('size:4', $request->rules()['AnoPublicacao']);
    }
}
