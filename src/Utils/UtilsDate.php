<?php

namespace WEBUtils\Utils;

use DateTime;
use Exception;

/**
 * Classe com varios metodos para uso geral, classe com metodos para data/hora
  * @author Marcelo
 *
 */
class UtilsDate {

    /**
     * PEGA A DATA E HORA EM FORMATO yyy-mm-dd h:i:s  e CORRIGE PARA dd/mm/yyyy h:i:s
     * @author Marcelo R. Santos
     * @version 1.0
     * @param date $data data
     * @param int $op opção 0 = data | 1 = data e hora
     * @return String
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
     * PEGA A DATA E HORA EM FORMATO NORMAL dd/mm/yyyy h:i:s  E INVERTE PARA yyy-m-dd h:i:s
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

    /**
     * EXIBE A DATA POR EXTENSO
     */
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

        $english_month = date("n");

        /* Acha o mês em português */
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

        return $portuguese_day . ", " . date("d") . " de " . $portuguese_month . " de " . date("Y");
    }

    /**
     * EXIBE A SAUDACAO PARA O USUARIO DE ACORDO COM O HORARIO
     * @return string
     */
    static function saudacaoUsuario() {
        $today = getdate();
        $hour = $today['hours'];

        if ($hour >= 5 && $hour < 12) {
            return "Bom dia";
        } else if ($hour >= 12 && $hour < 18) {
            return "Boa tarde";
        } else if (($hour >= 18 && $hour < 24) || ($hour >= 1 && $hour < 5)) {
            return "Boa noite";
        }
        return "";
    }

    /**
     * RETORNA A QUANTIDADE DE DIAS ENTRE 2 DATAS, USAR SOMENTE DATA NO FORMATO
     * Y-m-d
     * @param Date $dataInicio
     * @param Date $dataFim
     * @return Integer 
     */
    static function contaDiasData($dataInicio, $dataFim) {
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
     * VERIFICA SE DATA INFORMATA É UMA DATA
     * @param Date data para verificar
     * @return boolean
     */
    static private function isData($value) {
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
