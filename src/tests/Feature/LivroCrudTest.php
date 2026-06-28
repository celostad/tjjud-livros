<?php

namespace Tests\Feature;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroCrudTest extends TestCase
{
    use RefreshDatabase;

    private function dadosLivro(array $override = []): array
    {
        $autor   = Autor::create(['Nome' => 'Autor Teste']);
        $assunto = Assunto::create(['Descricao' => 'Ficção']);

        return array_merge([
            'Titulo'        => 'Livro de Teste',
            'Editora'       => 'Editora Teste',
            'Edicao'        => 1,
            'AnoPublicacao' => '2024',
            'Valor'         => '49.90',
            'autores'       => [$autor->CodAu],
            'assuntos'      => [$assunto->codAs],
        ], $override);
    }

    public function test_lista_livros(): void
    {
        $response = $this->get(route('livros.index'));
        $response->assertStatus(200)->assertViewIs('livros.index');
    }

    public function test_exibe_formulario_criar(): void
    {
        $this->get(route('livros.create'))->assertStatus(200);
    }

    public function test_cria_livro_com_sucesso(): void
    {
        $dados    = $this->dadosLivro();
        $response = $this->post(route('livros.store'), $dados);

        $response->assertRedirect(route('livros.index'));
        $this->assertDatabaseHas('Livro', ['Titulo' => 'Livro de Teste']);
    }

    public function test_validacao_titulo_obrigatorio(): void
    {
        $dados    = $this->dadosLivro(['Titulo' => '']);
        $response = $this->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors('Titulo');
    }

    public function test_validacao_autor_obrigatorio(): void
    {
        $dados    = $this->dadosLivro(['autores' => []]);
        $response = $this->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors('autores');
    }

    public function test_validacao_ano_formato(): void
    {
        $dados    = $this->dadosLivro(['AnoPublicacao' => '24']);
        $response = $this->post(route('livros.store'), $dados);

        $response->assertSessionHasErrors('AnoPublicacao');
    }

    public function test_atualiza_livro(): void
    {
        $livro = Livro::create([
            'Titulo' => 'Original', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2020', 'Valor' => 10.00,
        ]);
        $dados = $this->dadosLivro(['Titulo' => 'Atualizado']);

        $this->put(route('livros.update', $livro), $dados)
             ->assertRedirect(route('livros.index'));

        $this->assertDatabaseHas('Livro', ['Titulo' => 'Atualizado']);
    }

    public function test_exclui_livro(): void
    {
        $livro = Livro::create([
            'Titulo' => 'Para Excluir', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2020', 'Valor' => 10.00,
        ]);

        $this->delete(route('livros.destroy', $livro))
             ->assertRedirect(route('livros.index'));

        $this->assertDatabaseMissing('Livro', ['Titulo' => 'Para Excluir']);
    }

    public function test_exibe_livro(): void
    {
        $livro = Livro::create([
            'Titulo' => 'Livro Detalhe', 'Editora' => 'Ed',
            'Edicao' => 1, 'AnoPublicacao' => '2020', 'Valor' => 10.00,
        ]);

        $this->get(route('livros.show', $livro))
             ->assertStatus(200)
             ->assertSee('Livro Detalhe');
    }

    public function test_api_lista_livros(): void
    {
        $this->getJson('/api/livros')->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_api_cria_livro(): void
    {
        $dados    = $this->dadosLivro();
        $response = $this->postJson('/api/livros', $dados);

        $response->assertStatus(201)->assertJsonPath('data.Titulo', 'Livro de Teste');
    }
}
