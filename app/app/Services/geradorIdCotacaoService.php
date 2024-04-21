<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class geradorIdCotacaoService

{
    public function generateQuotationId($nomeEmpresa, $nome)
    {

        $nomeEmpresaFormatado = strtolower(str_replace(' ', '', $nomeEmpresa));
        $nomeFormatado = strtolower(str_replace(' ', '', $nome));

        $today = Carbon::now()->format('dm');

        return $today . $nomeEmpresaFormatado . $nomeFormatado;
    }
}
