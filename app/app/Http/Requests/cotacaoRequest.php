<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CotacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'dadosEmpresa.nome' => 'required|string|max:255|min:3',
            'dadosEmpresa.empresa' => 'required|string|max:255|min:3',
            'dadosEmpresa.email' => 'required|email|max:255',
            'dadosEmpresa.telefone' => 'required|string|regex:/^\(\d{2}\) \d{5}-\d{4}$/',
            'dadosSite.tipoSite' => ['required', Rule::in(['1', '2', '3', 'outros']), 'string'],
            'dadosSite.tipoSiteOutros' => 'nullable|string|max:255|min:3',
            'dadosSite.ObjtSite' => ['required', Rule::in(['1', '2', '3', '4', 'outros']), 'string'],
            'dadosSite.ObjtSiteOutros' => 'nullable|string|max:255|min:3',
            'dadosSite.expectativaSite' => ['required', Rule::in(['1', '2', '3', 'outros']), 'string'],
            'dadosSite.expectativaSiteOutros' => 'nullable|string|max:255|min:3',
            'dadosSite.funcinabilidadesAdd' => ['nullable', Rule::in(['1', '2', '3', 'outros']), 'string'],
            'dadosSite.funcinabilidadesAddOutros' => 'nullable|string|max:255|min:3',
            'dadosSite.mensagem' => 'nullable|string|max:255|min:3'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Houve um erro com os dados fornecidos. Por favor, verifique e tente novamente.',
            'exampleRequest' => [
                'dadosEmpresa' => [
                    'nome' => 'Nome Exemplo',
                    'empresa' => 'Empresa Exemplo',
                    'email' => 'email@exemplo.com',
                    'telefone' => '(99) 99999-9999'
                ],
                'dadosSite' => [
                    'tipoSite' => '1',
                    'ObjtSite' => '2',
                    'expectativaSite' => '1',
                    'funcinabilidadesAdd' => '1',
                    'mensagem' => 'Descrição breve do que é esperado.'
                ]
            ],
            'errors' => $validator->errors()
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
