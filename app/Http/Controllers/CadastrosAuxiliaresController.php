<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Uspdev\CadastrosAuxiliaresClient\Contracts\CursosGraduacaoClientInterface;

class CadastrosAuxiliaresController extends Controller
{
    // A documentação recomenda resolver o client com:
    // app(CursosGraduacaoClientInterface::class)->listar();
    // Aqui o Laravel resolve a mesma interface ao construir o controller e a
    // mantém disponível para as duas ações, sem chamar app() repetidamente.
    public function __construct(
        private readonly CursosGraduacaoClientInterface $cursosGraduacaoClient
    ) {
    }

    public function cursosGraduacao(Request $request)
    {
        \UspTheme::activeUrl('cadastros-auxiliares/cursos-graduacao');

        $busca = trim((string) $request->query('busca', ''));

        $cursos = $this->filtrarCursos($this->cursosGraduacaoClient->listar(), $busca);

        return view('cadastros-auxiliares.cursos-graduacao.index', compact('busca', 'cursos'));
    }

    public function cursoGraduacao(int $codcur)
    {
        \UspTheme::activeUrl('cadastros-auxiliares/cursos-graduacao');

        $curso = $this->cursosGraduacaoClient->obter($codcur);

        return view('cadastros-auxiliares.cursos-graduacao.show', compact('curso', 'codcur'));
    }

    private function filtrarCursos(Collection $cursos, string $busca): Collection
    {
        if ($busca === '') {
            return $cursos;
        }

        return $cursos
            ->filter(function (array $curso) use ($busca) {
                return Str::contains(
                    implode(' ', [
                        $curso['codcur'] ?? '',
                        $curso['nomcur'] ?? '',
                        $curso['codset'] ?? '',
                        $curso['nomset'] ?? '',
                        $curso['nomabvset'] ?? '',
                    ]),
                    $busca,
                    ignoreCase: true
                );
            })
            ->values();
    }
}
