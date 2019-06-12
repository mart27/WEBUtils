<?php

namespace WEBUtils\Utils;

use WEBUtils\Database\ResultSet;
use WEBUtils\Utils\Utils;
use Exception;

/**
 * Classe para conexão com banco de dados MySQL 
 * @author Marcelo
 *
 */
class ConnDB {

    private $conexao;
    private $error;
    //private $db_config;
    private $re;
    private $sql;
    private $last_id;
    //private $record;
    //private $fields;
    private $status;
    private $affected_row;
    private $isError = false;

    function __construct($dados) {
        $this->Open($dados);
    }

    /**
     * Abre a conexao com banco de dados     
     * @param array $dados
     * @return boolean
     */
    function Open($dados) {
        if (!isset($this->status)) {
            $this->conexao = mysqli_connect($dados["HOST"], $dados["USERNAME"], $dados["PASSWORD"], $dados["DBNAME"]);
            //mysqli_set_charset($this->conexao, 'utf-8');
            if (mysqli_connect_errno() != 0) {
                $this->error = "Nao foi possivel conectar no banco de dados <b>\"" . $dados["DBNAME"] . "\"</b>";
                $this->status = false;
                $this->isError = true;
            } else {
                $this->status = true;
            }
        }
        // echo "status: #".$this->status."#";
        return $this->status;
    }

    /**
     * Executa uma instrução sql
     * @param $sql
     * @return mixed
     */
    function Execute($sql) {
        if (!$this->status) {
            $this->Open();
        }
        $this->sql = $sql;
        $this->re = mysqli_query($this->conexao, $this->sql);
        $this->vsql = $this->sql;
        if (!$this->re) {
            $this->error = "Erro na execução da query " . mysqli_error($this->conexao);
            $this->isError = true;
            $this->status = false;
        } else {
            $this->isError = false;
            return new ResultSet($this->re);
        }
    }

    function Close() {
        if ($this->status) {
            $this->status = false;
            mysqli_close($this->conexao);
            unset($this->conexao);
        }
    }

    function ShowErrors() {
        return $this->error;
    }

    function ShowSql() {
        return $this->vsql;
    }

    function Insert($tabela, $obj) {
        try {
            $dados = Utils::objectToArray($obj);
            if (!is_array($dados)) {
                return false; //estava comentado
            }

            $campos = implode(array_keys($dados), ',');
            $valores = "'" . implode("','", array_values($this->EscapeString($dados))) . "'";

            $this->sql = "INSERT INTO $tabela ($campos) VALUES ($valores)";
            $this->re = $this->Execute($this->sql);
            $this->vsql = $this->sql;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function Update($tabela, $obj, $where) {
        $dados = Utils::objectToArray($obj);
        if (!is_array($dados)) {
            return false;
        }
        $fields = array_keys($dados);
        $values = array_values($dados);
        $i = 0;
        $f = array_count_values($dados);
        $this->sql = "UPDATE $tabela SET ";
        while ($fields[$i]) {
            if (($i <= $f) and ( $i >= 1)) {
                $this->sql .= ", ";
            }
            $this->sql .= $fields[$i] . " = '" . $values[$i] . "'";
            $i++;
        }
        $this->sql .= " WHERE $where";
        $this->re = $this->Execute($this->sql);
        $this->vsql = $this->sql;
        if ($this->re) {
            return true;
        } else {
            $this->error = "[" . mysqli_errno($this->conexao) . "]" . mysqli_error($this->conexao);
            $this->isError = true;
        }
    }

    function Delete($tabela, $where) {
        $this->sql = "DELETE FROM $tabela ";
        $this->sql .= " WHERE $where";
        $this->re = $this->Execute($this->sql);
        $this->vsql = $this->sql;
        if ($this->re) {
            return true;
        } else {
            $this->error = "[" . mysqli_errno($this->conexao) . "]" . mysqli_error($this->conexao);
            $this->isError = true;
        }
    }

    function AffectedRow() {
        $this->affected_row = mysqli_affected_rows($this->conexao);
        return $this->affected_row;
    }

    function InsertId() {
        $this->last_id = mysqli_insert_id($this->conexao);
        return $this->last_id;
    }

    public function getIsError() {
        return $this->isError;
    }

    function EscapeString($value) {
        if (is_array($value)) {
            $campos = array_keys($value);
            $valores = array_values($value);
            for ($i = 0; $i < count($value); $i++) {
                $arr[$campos[$i]] = mysqli_escape_string($this->conexao, $valores[$i]);
            }
            return $arr;
        } else {
            if ($value == '') {
                $value = 'NULL';
            }
            if (!is_numeric($value) || $value[0] == '0') {
                if (get_magic_quotes_gpc()) {
                    $value = stripslashes($value);
                }
                $value = mysql_escape_string($this->conexao, $string);
            }
            return $value;
        }
    }

}
