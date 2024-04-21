<?php

namespace App\Services;

use App\Services\geradorIdCotacaoService;
use App\Models\cotacao;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMailCotacao;
use App\Services\googleSheetsService;
use Google\Service\Sheets;
use \Google\Service\Sheets\ValueRange;
use Illuminate\Support\Carbon;
use App\Mail\sendMailCotacaoCliente;

class cotacaoService
{

    private $dadosEmpresa;
    private $dadosSite;
    private $geradorIdCotacaoService;
    private $dadosbanco;
    private $valorSite;
    private $dadosCotacao;
    private $googleSheetsService;

    public function __construct(
        geradorIdCotacaoService $geradorIdCotacaoService,
        googleSheetsService $googleSheetsService
    ) {
        $this->geradorIdCotacaoService = $geradorIdCotacaoService;
        $this->googleSheetsService = $googleSheetsService;
    }

    public function recebeDados($dadosEmpresa, $dadosSite)
    {
        $this->dadosEmpresa = $dadosEmpresa;
        $this->dadosSite = $dadosSite;
        $this->valorSite = $this->calcularValorSite();
        $this->infoCotacao();
        $this->enviarEmail();
        $this->gravarDadosSheets();
        $this->manipularBanco();

        return ['status' => true, 'mensagem' => 'informacoes salvas com sucesso'];
    }

    public function infoCotacao()
    {

        $this->dadosCotacao['infoEmpresa'] = $this->dadosEmpresa;

        switch ($this->dadosSite['tipoSite']) {
            case '1':
                $this->dadosCotacao['infoSite']['tipoSite'] = "Site Institucional";
                break;
            case '2':
                $this->dadosCotacao['infoSite']['tipoSite'] = "Portfólio";
                break;
            case '3':
                $this->dadosCotacao['infoSite']['tipoSite'] = "Blog";
                break;
            default:
                $this->dadosCotacao['infoSite']['tipoSite'] = $this->dadosSite['tipoSiteOutros'];
                break;
        }

        switch ($this->dadosSite['ObjtSite']) {
            case '1':
                $this->dadosCotacao['infoSite']['ObjtSite'] = "Estabelecer Presença Online";
                break;
            case '2':
                $this->dadosCotacao['infoSite']['ObjtSite'] = "Aumentar Vendas";
                break;
            case '3':
                $this->dadosCotacao['infoSite']['ObjtSite'] = "Compartilhar Conteúdo";
                break;
            case '4':
                $this->dadosCotacao['infoSite']['ObjtSite'] = "Engajar Comunidade";
                break;
            default:
                $this->dadosCotacao['infoSite']['ObjtSite'] = $this->dadosSite['ObjtSiteOutros'];
                break;
        }

        switch ($this->dadosSite['expectativaSite']) {
            case '1':
                $this->dadosCotacao['infoSite']['expectativaSite'] = "Design Atraente e Profissional";
                break;
            case '2':
                $this->dadosCotacao['infoSite']['expectativaSite'] = "Fácil Gestão de Conteúdo";
                break;
            case '3':
                $this->dadosCotacao['infoSite']['expectativaSite'] = "SEO Otimizado para Melhor Visibilidade";
                break;
            default:
                $this->dadosCotacao['infoSite']['expectativaSite'] = $this->dadosSite['expectativaSiteOutros'];
                break;
        }

        if (isset($this->dadosSite['funcinabilidadesAdd'])) {
            switch ($this->dadosSite['funcinabilidadesAdd']) {
                case '1':
                    $this->dadosCotacao['infoSite']['funcinabilidadesAdd'] = "Chat Online";
                    break;
                case '2':
                    $this->dadosCotacao['infoSite']['funcinabilidadesAdd'] = "Formulários Personalizados";
                    break;
                case '3':
                    $this->dadosCotacao['infoSite']['funcinabilidadesAdd'] = "Área de Rastreamento";
                    break;
                default:
                    $this->dadosCotacao['infoSite']['funcinabilidadesAdd'] = $this->dadosSite['funcinabilidadesAddOutros'];
                    break;
            }
        }
        $this->dadosCotacao['valorSugerido'] = $this->valorSite;


        $this->dadosCotacao['envioSheets'] = [
            [
                $this->dadosCotacao['infoEmpresa']['nome'],
                $this->dadosCotacao['infoEmpresa']['empresa'],
                $this->dadosCotacao['infoEmpresa']['email'],
                $this->dadosCotacao['infoEmpresa']['telefone'],
                $this->dadosCotacao['infoSite']['tipoSite'],
                $this->dadosCotacao['infoSite']['ObjtSite'],
                $this->dadosCotacao['infoSite']['expectativaSite'],
                isset($this->dadosCotacao['infoSite']['funcinabilidadesAdd']) ? $this->dadosCotacao['infoSite']['funcinabilidadesAdd'] : "",
                $this->dadosCotacao['valorSugerido'],
                Carbon::now()->format('d/m/Y')

            ]
        ];
    }

    public function manipularBanco()
    {
        $cotacaoId = $this->geradorIdCotacaoService->generateQuotationId($this->dadosEmpresa['empresa'], $this->dadosEmpresa['nome']);

        $existeCotacao = cotacao::where('cotacaoId', $cotacaoId)->first();

        if ($existeCotacao) {
            return [
                'status' => false,
                'mensagem' => 'Cotacao já feita',
                'idCotacao' => $cotacaoId
            ];
        }
        $this->dadosbanco = new cotacao();
        $this->dadosbanco->cotacaoId = $cotacaoId;
        $this->dadosbanco->nome = $this->dadosEmpresa['nome'];
        $this->dadosbanco->nomeEmpresa = $this->dadosEmpresa['empresa'];
        $this->dadosbanco->telefone = $this->dadosEmpresa['email'];
        $this->dadosbanco->email = $this->dadosEmpresa['telefone'];
        $this->dadosbanco->infoSite = $this->dadosSite;
        $this->dadosbanco->valorSugerido = $this->valorSite;
        $this->dadosbanco->save();
        return $this->dadosbanco;
    }


    public function calcularValorSite()
    {
        switch ($this->dadosSite['tipoSite']) {
            case '1':
                $this->valorSite += 1000;
                break;
            case '2':
                $this->valorSite += 500;
                break;
            case '3':
                $this->valorSite += 800;
                break;
            default:
                $this->valorSite += 1000;
                break;
        }

        switch ($this->dadosSite['ObjtSite']) {
            case '1':
                $this->valorSite += 1000;
                break;
            case '2':
                $this->valorSite += 800;
                break;
            case '3':
                $this->valorSite += 650;
                break;
            case '4':
                $this->valorSite += 750;
                break;
            default:
                $this->valorSite += 100;
                break;
        }

        switch ($this->dadosSite['expectativaSite']) {
            case '1':
                $this->valorSite += 1290;
                break;
            case '2':
                $this->valorSite += 895;
                break;
            case '3':
                $this->valorSite += 769;
                break;
            default:
                $this->valorSite += 1300;
                break;
        }
        if (isset($this->dadosSite['funcinabilidadesAdd'])) {

            switch ($this->dadosSite['funcinabilidadesAdd']) {
                case '1':
                    $this->valorSite += 1290;
                    break;
                case '2':
                    $this->valorSite += 895;
                    break;
                case '3':
                    $this->valorSite += 769;
                    break;
                default:
                    $this->valorSite += 1300;
                    break;
            }
        }

        return $this->valorSite;
    }

    public function enviarEmail()
    {
        Mail::send(new sendMailCotacao($this->dadosCotacao));
        Mail::send(new sendMailCotacaoCliente($this->dadosCotacao));
    }

    public function gravarDadosSheets()
    {
        $client = $this->googleSheetsService->googleSheetsClient();

        $service = new Sheets($client);
        $body = new ValueRange([
            'values' => $this->dadosCotacao['envioSheets']
        ]);
        $rangeToWrite = "A2:Z";
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $result = $service->spreadsheets_values->append(env('GOOGLE_ID_PLAN'), $rangeToWrite, $body, $params);

        if ($result->getUpdates()->getUpdatedCells() > 0) {
            return ['status' => 'true'];
        } else {
            return 2;
        }
    }
}
