<?php

namespace Tests\Feature;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorAssuntoTest extends TestCase
{
    use RefreshDatabase;

    // ──────── AUTOR ────────

    public function test_lista_autores(): void
    {
        $this->get(route('autores.index'))->assertStatus(200);
    }

    public function test_cria_autor(): void
    {
        $this->post(route('autores.store'), ['Nome' => 'Novo Autor'])
             ->assertRedirect(route('autores.index'));

        $this->assertDatabaseHas('Autor', ['Nome' => 'Novo Autor']);
    }

    public function test_validacao_nome_autor_obrigatorio(): void
    {
        $this->post(route('autores.store'), ['Nome' => ''])
             ->assertSessionHasErrors('Nome');
    }

    public function test_nao_exclui_autor_com_livros(): void
    {
        $autor = Autor::create(['Nome' => 'Autor Com Livro']);
        $livro = Livro::create([
            'Titulo' => 'L', 'Editora' => 'E',
            'Edicao' => 1, 'AnoPublicacao' => '2020', 'Valor' => 1.00,
        ]);
        $livro->autores()->attach($autor->CodAu);

        $this->delete(route('autores.destroy', $autor))
             ->assertRedirect();

        $this->assertDatabaseHas('Autor', ['Nome' => 'Autor Com Livro']);
    }

    public function test_atualiza_autor(): void
    {
        $autor = Autor::create(['Nome' => 'Nome Antigo']);
        $this->put(route('autores.update', $autor), ['Nome' => 'Nome Novo'])
             ->assertRedirect(route('autores.index'));

        $this->assertDatabaseHas('Autor', ['Nome' => 'Nome Novo']);
    }

    // ──────── ASSUNTO ────────

    public function test_lista_assuntos(): void
    {
        $this->get(route('assuntos.index'))->assertStatus(200);
    }

    public function test_cria_assunto(): void
    {
        $this->post(route('assuntos.store'), ['Descricao' => 'Thriller'])
             ->assertRedirect(route('assuntos.index'));

        $this->assertDatabaseHas('Assunto', ['Descricao' => 'Thriller']);
    }

    public function test_descricao_assunto_max_20_chars(): void
    {
        $this->post(route('assuntos.store'), ['Descricao' => str_repeat('X', 21)])
             ->assertSessionHasErrors('Descricao');
    }

    public function test_nao_exclui_assunto_com_livros(): void
    {
        $assunto = Assunto::create(['Descricao' => 'Vinculado']);
        $livro   = Livro::create([
            'Titulo' => 'L', 'Editora' => 'E',
            'Edicao' => 1, 'AnoPublicacao' => '2020', 'Valor' => 1.00,
        ]);
        $livro->assuntos()->attach($assunto->codAs);

        $this->delete(route('assuntos.destroy', $assunto))
             ->assertRedirect();

        $this->assertDatabaseHas('Assunto', ['Descricao' => 'Vinculado']);
    }
}
