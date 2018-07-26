<?php

namespace WEBUtils\Utils;

use WEBUtils\Utils\Constantes;
use ReflectionClass;

/**
 * Classe com varios metodos para uso geral
 * @author Marcelo
 *
 */
class Utils {

    /**
     * RETORNA ESTADO(UF) DE ACORDO COM SIGLA INFORMADA
     * @param Sigla do estado 
     * @return String - estado
     */
    static function retornaEstadoUf($valor) {
        return Constantes::listUf()[$valor];
    }

    /**
     * EXIBE ESTADOS (UF) PARA EXIBICAO EM LISTA (<select>)
     * @param type $padrao
     */
    static function exibeHtmlSelectEstadosUf($padrao = "") {
        $estados = Constantes::listUf();

        foreach ($estados as $key => $v) {
            if ($padrao <> "") {
                $selected = ($key == $padrao) ? " selected" : "";
                //echo $selected . " - " . $v;
            }
            echo "<option value='" . $key . "'" . $selected . ">" . $v . "</option>";
        }
    }

    /**
     * ADIONA MASCARA A UM VALOR INFORMADO EX: CEP: #####-###
     * @param String - mascara a ser usada ex: ##/##/####
     * @param String - texto para adicionar a mascara
     * @return String - texto com a mascara especifica
     */
    static function mascara($mascara, $string) {
        $string = str_replace(" ", "", $string);
        for ($i = 0; $i < strlen($string); $i++) {
            $mascara[strpos($mascara, "#")] = $string[$i];
        }
        return $mascara;
    }

    static function cortarTexto($frase, $quantidade) {
        $tamanho = strlen($frase);
        if ($tamanho > $quantidade)
            $frase = substr_replace($frase, "...", $quantidade, $tamanho - $quantidade);
        return $frase;
    }

    static function antiInjection($str) {
        if (!is_numeric($str)) {
            $str = get_magic_quotes_gpc ? stripslashes($str) : $str;
            $str = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($str) : mysql_escape_string($str);
        }
        return $str;
    }

    static public function removeAcentos($texto) {
        //$string = 'ÁÍÓÚÉÄÏÖÜËÀÌÒÙÈÃÕÂÎÔÛÊáíóúéäïöüëàìòùèãõâîôûêÇç';
        //return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $texto));
        // assume $str esteja em UTF-8
        $map = array(
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'é' => 'e',
            'ê' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ç' => 'c',
            'Á' => 'A',
            'À' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'É' => 'E',
            'Ê' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ú' => 'U',
            'Ü' => 'U',
            'Ç' => 'C'
        );

        return strtr($texto, $map); // funciona corretamente
    }

    /**
     * Exclui arquivos e diretorios recursivamente
     * @param type $dir
     * @return type
     */
    static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? Utils::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    static public function objectToArray($object) {
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if ($property->getValue($object) != null || $property->getValue($object) === "") {
                $array[$property->getName()] = $property->getValue($object);
            }
            $property->setAccessible(false);
        }
        return $array;
    }

}
