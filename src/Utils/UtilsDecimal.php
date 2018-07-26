<?php

namespace WEBUtils\Utils;

/**
 * Classe com varios metodos para uso geral, valores decimais
 * @author Marcelo
 *
 */
class UtilsDecimal {

    /**
     * FUNÇÃO QUE ADICIONA ZERO(0) A ESQUERDA
     * @author Marcelo R. Santos
     * @version 1.0
     * @param String $kNumero
     * @param String $X
     * @return mixed
     */
    static function zeroEsquerda($kNumero, $X) {
        return str_pad($kNumero, $X, "0", STR_PAD_LEFT);
    }

    /**
     * FUNÇÃO QUE RETIRA ZERO(0) A ESQUERDA
     * @author Mairieli Wessel
     * @version 1.0
     * @param String $numero
     * @return mixed
     */
    static function retiraZeroEsquerda($numero) {
        $caracteres = array("_", ".", "-");
        $numero = str_replace($caracteres, "", $numero);
        while (substr($numero, 0, 1) === 0) {
            $numero = preg_replace("/0/", "", $numero, 1);
        }
        return $numero;
    }

    /**
     * FORMATA DECIMAL PARA O PADRAO MODEA REAL
     * @param decimal $valor
     * @param boolean $simbolo - true para mostrar R$, padrao false
     * @return decimal - valor formatado
     */
    static public function formataMoedaReal($valor, $simbolo = false) {
        //$valor = str_replace(".", "", $valor);
        $s = ($simbolo) ? 'R$ ' : '';
        return $s . number_format($valor, 2, ',', '.'); // retorna R$100.000,50
    }

    static public function formataDecimal($valor, $casasDecimais, $simboloDecimal, $simboloMilhar) {
        $novoValor = str_replace(",", ".", str_replace(".", "", $valor));
        return number_format($novoValor, $casasDecimais, $simboloDecimal, $simboloMilhar);
    }

    /**
     * REMOVE TODOS OS CARACTERES TE UMA STRING, DEIXANDO SOMENTE OS NUMEROS
     * @param String $str
     * @return Integer
     */
    static function somenteNumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

}
