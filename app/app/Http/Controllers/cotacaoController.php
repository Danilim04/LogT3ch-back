<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\cotacaoRequest;
use App\Services\cotacaoService;

class cotacaoController extends Controller
{
    private $cotacaoService;
    private $retorno;

    public function __construct(cotacaoService $cotacaoService)
    {
        $this->cotacaoService = $cotacaoService;
    }

    public function cotacao(cotacaoRequest $request)
    {
        $this->retorno = [];

        $dados = $request->all();

        $dadosEmpresa = $dados['dadosEmpresa'];
        $dadosSite = $dados['dadosSite'];

        $this->retorno = $this->cotacaoService->recebeDados($dadosEmpresa, $dadosSite);

        return $this->retorno;
    }
}
