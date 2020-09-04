<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class emprestaController
 * @package App\Http\Controllers
 */
class emprestaController extends Controller
{

    /**
     * @return mixed
     */
    public function getInstituicoes()
    {
        $arquivo = Storage::get('public/json/instituicoes.json');
        $instituicoes = json_decode($arquivo);

        foreach ($instituicoes as $instituicao) {
            $arrayInstituicoes[$instituicao->chave] = $instituicao->valor;
        }

        return json_encode($arrayInstituicoes);
    }


    /**
     * @return mixed
     */
    public function getConvenios()
    {
        $arquivo = Storage::get('public/json/convenios.json');
        $convenios = json_decode($arquivo);

        foreach ($convenios as $convenio) {
            $arrayConvenios[$convenio->chave] = $convenio->valor;
        }

        return json_encode($arrayConvenios);
    }


    /**
     * @param Request $request
     * @return false|string
     */
    public function simulacaoCredito(Request $request)
    {
        return $this->calculaSimulacao($request);
    }


    /**
     * @param $request
     * @return false|string
     */
    private function calculaSimulacao($request) {
        $arquivo = Storage::get('public/json/taxas_instituicoes.json');
        $taxas = json_decode($arquivo);
        $instituicoes = json_decode($this->getInstituicoes());

        foreach ($instituicoes as $key => $instituicao) {
            foreach ($taxas as $taxa) {
                if ($key == $taxa->instituicao) {
                    $valorParcela = $request->valor_emprestimo * $taxa->coeficiente;
                    $valorParcelaFormatada = number_format($valorParcela, 2, '.', '');

                    $simulacao = [
                        "taxa" => $taxa->taxaJuros,
                        "parcelas" => $taxa->parcelas,
                        "valor_parcela" => floatval($valorParcelaFormatada),
                        "convenio" => $taxa->convenio
                    ];

                    $arraySimulacao[$taxa->instituicao][] = $simulacao;
                }
            }
        }

        return json_encode($arraySimulacao);
    }

}
