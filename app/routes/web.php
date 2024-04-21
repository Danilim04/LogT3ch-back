<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mail', function () {
    $dadosCotacao = [
        'infoEmpresa' => [
            'nome' => 'Daniel',
            'empresa' => 'logt3ch',
            'email' => 'daniel@logt3ch.com',
            'telefone' => '(31) 98385-7490'
        ],

        'infoSite' => [
            'tipoSite' => 'Blog',
            'ObjtSite' => 'Aumentar Vendas',
            'expectativaSite' => 'Design Atraente e Profissional',
            'funcinabilidadesAdd' => 'Chat ao vivo, sistema de reserva'
        ]
    ]; // Simule os dados da cotação aqui
    return new App\Mail\sendMailCotacaoCliente($dadosCotacao);
});
