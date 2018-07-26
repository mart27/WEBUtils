<?php

namespace WEBUtils\Utils;

/**
 * Description of LogSistema
 *
 * @author Marcelo
 */
class LogSistema {

    private $pathLog;

    function __construct($pathLog) {
        $this->pathLog = $this->preparaDirPathLog($pathLog);
        $this->geraArquivoLog();
    }

    private function nomeArquivoLog() {
        return $this->pathLog . "log_sistema_" . date("Y_m_d") . ".txt";
    }

    private function preparaDirPathLog($dir) {
        $ano = date("Y");
        $mes = date("m");
        $caminho = $dir . $ano . "/" . $mes."/";

        if (!file_exists($caminho)) {
            mkdir($caminho, "0777", true);
        }
        return $caminho;
    }

    private function geraArquivoLog() {

        $data = date("d/m/Y H:i:s");
        if (!file_exists($this->nomeArquivoLog())) {
            $arquivo = fopen($this->nomeArquivoLog(), "ab");
            fwrite($arquivo, "[$data] INICIANDO LOG DO DIA.\r\n");
            fclose($arquivo);
        }
    }

    public function gravaLog($usuario_id, $tela, $texto) {
        $this->geraArquivoLog();
        $hora = date("H:i:s T");
        $ipUsuario = $_SERVER['REMOTE_ADDR'];

        $arquivo = fopen($this->nomeArquivoLog(), "ab");
        fwrite($arquivo, "[" . $hora . "] " . $ipUsuario . " - [" . $tela . "] - [ID USER: " . $usuario_id . "] - " . utf8_encode($texto) . "\r\n");
        fclose($arquivo);
    }

}
