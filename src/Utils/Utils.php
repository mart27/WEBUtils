<?php

namespace WEBUtils\Utils;
use WEBUtils\Utils\Constantes;
use ReflectionClass;
use DateTime;
use Exception;

/**
 * Description of Utils
 *
 * @author Marcelo
 */
class Utils {

    /**
     * PEGA A DATA E HORA EM FORMATO MYSQL E CORRIGE yyy-mm-dd h:i:s   para dd/mm/yyyy h:i:s
     * @author Marcelo R. Santos
     * @version 1.0
     * @param date $data data
     * @param int $op opção 0 = data | 1 = data e hora
     * @return mixed
     */
    static function corrigeDataHora($data, $op = 0) {
        if (!isset($data)) {
            $nova_data = "";
        } else {
            $d = explode(" ", $data);
            $d2 = explode("-", $d[0]);
            if ($op == 0) {
                $nova_data = $d2[2] . "/" . $d2[1] . "/" . $d2[0];
            } else {
                $nova_data = $d2[2] . "/" . $d2[1] . "/" . $d2[0] . " - " . $d[1];
            }
        }
        return $nova_data;
    }

    /**
     * PEGA A DATA E HORA EM FORMATO NORMAL E INVERTE PARA MYSQL  dd/mm/yyyy h:i:s  para  yyy-m-dd h:i:s
     * @author Marcelo R. Santos
     * @version 1.0
     * @param date $data data
     * @param int $op opção 0 = data | 1 = data e hora
     * @return mixed
     */
    static function inverteDataHora($data, $op = 0) {
        $d = explode(" ", $data);
        $d2 = explode("/", $d[0]);
        if ($op == 0) {
            $nova_data = $d2[2] . "-" . $d2[1] . "-" . $d2[0];
        } else {
            $nova_data = $d2[2] . "-" . $d2[1] . "-" . $d2[0] . " " . $d[1];
        }
        return $nova_data;
    }

    static function retornaEstadoUf($valor) {
        return Constantes::listUf()[$valor];
    }

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

    static function dataExtenso() {

        // vê o dia da semana em Inglês
        $english_day = date("l");


        // Acha o nome da semana em português
        switch ($english_day) {
            case "Monday":
                $portuguese_day = "Segunda-Feira";
                break;
            case "Tuesday":
                $portuguese_day = "Terça-Feira";
                break;
            case "Wednesday":
                $portuguese_day = "Quarta-Feira";
                break;
            case "Thursday":
                $portuguese_day = "Quinta-Feira";
                break;
            case "Friday":
                $portuguese_day = "Sexta-Feira";
                break;
            case "Saturday":
                $portuguese_day = "Sábado";
                break;
            case "Sunday":
                $portuguese_day = "Domingo";
                break;
        }

        /*         * *vê o mês em Inglês */
        // if ($valor == 0) {
        $english_month = date("n");
        //  } else {
        //        $english_month = date("n") + 1;
        //   }

        /*         * *Acha o mês em português */
        switch ($english_month) {
            case "1":
                $portuguese_month = "Janeiro";
                break;
            case "2":
                $portuguese_month = "Fevereiro";
                break;
            case "3":
                $portuguese_month = "Março";
                break;
            case "4":
                $portuguese_month = "Abril";
                break;
            case "5":
                $portuguese_month = "Maio";
                break;
            case "6":
                $portuguese_month = "Junho";
                break;
            case "7":
                $portuguese_month = "Julho";
                break;
            case "8":
                $portuguese_month = "Agosto";
                break;
            case "9":
                $portuguese_month = "Setembro";
                break;
            case "10":
                $portuguese_month = "Outubro";
                break;
            case "11":
                $portuguese_month = "Novembro";
                break;
            case "12":
                $portuguese_month = "Dezembro";
                break;
        }


        print($portuguese_day);
        print(", ");
        print(date("d"));
        print(" de ");
        print($portuguese_month);
        print(" de ");
        print(date("Y"));
        print(".");
    }

    static function saudacaoUsuario() {
        $today = getdate();
        $hour = $today['hours'];

        if ($hour >= 5 && $hour < 12)
            $saudacao = "Bom dia";
        if ($hour >= 12 && $hour < 18)
            $saudacao = "Boa tarde";
        if (($hour >= 18 && $hour < 24) || ($hour >= 1 && $hour < 5))
            $saudacao = "Boa noite";
        return $saudacao;
    }

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

    /**
     * RETORNA A QUANTIDADE DE DIAS ENTRE 2 DATAS, USAR SOMENTE DATA NO FORMATO
     * Y-m-d
     * @param Date $dataInicio
     * @param Date $dataFim
     * @return Integer 
     */
    static function contasDiasData($dataInicio, $dataFim) {
        //$date = new DateTime($data);
        //$interval = $date->diff(new DateTime(date('Y-m-d'))); // data definida
        //return $interval->format('%Y Anos, %m Meses e %d Dias'); // 110 Anos, 2 Meses e 2 Dias
        //echo $interval->format('%Y Anos e %m Meses');
        //return $interval->format('%d');
        $data_inicial = $dataInicio;
        $data_final = $dataFim;

        //Calcula a diferença em segundos entre as datas
        $diferenca = strtotime($data_final) - strtotime($data_inicial);

        //Calcula a diferença em dias
        $dias = floor($diferenca / (60 * 60 * 24));
        return $dias;
    }

    /**
     * REMOVE TODOS OS CARACTERES TE UMA STRING, DEIXANDO SOMENTE OS NUMEROS
     * @param String $str
     * @return Integer
     */
    static function somenteNumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
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

    static private function isDate($value) {
        if (!$value) {
            return false;
        }
        try {
            new DateTime($value);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
