<?php

namespace WEBUtils\Utils;

/**
 * Classe para upload de arquivos.
 *
 * @author Felipe Ramone <felipe.asd@gmail.com>
 * @version 1.0
 * @package Café
 */
class Upload {

    /**
     * Nome do arquivo que vira de $_FILES[campo]
     *
     */
    protected $_arquivo;

    /**
     * Extensão do arquivo que será enviado
     *
     */
    protected $_arq_ext;

    /**
     * Novo nome que o arquivo receberá
     *
     */
    protected $_novo_nome;

    /**
     * Caminho para onde o arquivo será enviado
     *
     */
    protected $_path;

    /**
     * Limitar a extensão? 'sim' ou 'não'
     *
     */
    protected $_limt_ext = 'sim';

    /**
     * Extensoões validas para o upload
     *
     */
    protected $_ext_validas = array();

    /**
     * Limitar o tamanho máximo do arquivo? 'sim' ou 'não'
     *
     */
    protected $_limt_tam = 'não';

    /**
     * Tamanho em bytes permitidos caso $_limit_tam seja igual sim
     *
     */
    protected $_tam_max = '200000';

    /**
     * Recebe as mensagens que serão retornadas
     *
     */
    protected $_msg_retorno = '';
    protected $isError = false;
    protected $inicioNome = '';

    /**
     * Metodo __call()
     *
     */
    public function __call($_metodo, $_valores) {
        $_m = strtolower($_metodo);
        switch (substr($_m, 0, 3)) {
            case 'get':
            case 'set':
                $_atributo = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $_metodo)), 4);
                $_atributo = "_" . substr($_atributo, 0);
                if (property_exists($this, $_atributo)) {
                    if (substr($_m, 0, 3) == 'set') {
                        $this->{$_atributo} = $_valores[0];
                        return true;
                    } else {
                        return $this->{$_atributo};
                    }
                } else {
                    return false;
                }
                break;
        }
        return false;
    }

    //remove acentos e caractes especiais
    public function remover_caracter($string) {
        $string = str_replace(['Á', 'À', 'Â', 'Ã', 'Ä', 'á', 'à', 'â', 'ã', 'ä'], 'a', $string);
        $string = str_replace(['É', 'È', 'Ê', 'é', 'è', 'ê'], "e", $string);
        $string = str_replace(['Í', 'Ì', 'í', 'ì'], "i", $string);
        $string = str_replace(['Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'ó', 'ò', 'ô', 'õ', 'ö'], "o", $string);
        $string = str_replace(['Ú', 'Ù', 'Ü', 'ú', 'ù', 'ü'], "u", $string);
        $string = str_replace(['Ç', 'ç'], "c", $string);
        $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@º]/", "", $string);
        $string = preg_replace("/ /", "_", $string);
        $string = str_replace(['$', '–'], "", $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Seta as informações do arquivo que será enviado,
     * nome - extensão - novo nome que o arquivo receberá.
     *
     * @param string $_arquivo - arquivo que será enviado "$_FILE[campo]"
     */
    public function setArquivo($_arquivo) {
        $this->_arquivo = $_arquivo;
        $this->_arq_ext = strrchr($this->_arquivo['name'], '.');
        //prepara o nome o nome do arquivo
        $nome_arquivo = trim(substr($this->_arquivo['name'], 0, -4));
        //$this->_arq_nome = $this->remover_caracter($nome_arquivo) . "-";
        $this->_arq_nome = Utils::removeCaracterEspecial($nome_arquivo) . "-";
        //$this->_novo_nome = md5(uniqid(time())) . $this->_arq_ext;
        $this->_novo_nome = $this->_arq_nome . date("Y-m-d") . "-" . date("H-i-s") . $this->_arq_ext;
    }

    public function getExt() {
        return $this->_arq_ext;
    }

    public function getNovoNome() {
        return $this->_novo_nome;
    }

    public function setNovoNome($_novo_nome) {
        $this->_novo_nome = $_novo_nome;
    }

    public function getMsgRetorno() {
        return $this->_msg_retorno;
    }

    function getIsError() {
        return $this->isError;
    }

    function setIsError($isError) {
        $this->isError = $isError;
    }

    public function setInicioNome($nome) {
        $this->inicioNome = $nome;
    }

    /**
     * Verifica a extensão do arquivo
     *
     * @return mixed - false para tamanho ultrapassado ao permitido, true se estiver tudo correto
     */
    private function chkTam() {
        // verifica o tamanho do arquivo e se ele tem um tamanho limite permitido
        if (($this->_limt_tam == 'sim') && ($this->_arquivo['size'] > $this->_tam_max)) {
            $this->isError = true;
            $this->_msg_retorno = "O arquivo deve ter no máximo o tamanho de {$this->_tam_max} bytes!!!";
            return false;
        } else {
            return true;
        }
    }

    /**
     * Verifica a extensão do arquivo
     *
     * @return mixed - false para extensão inválida, true se estiver tudo correto
     */
    private function chkExt() {
        if ($this->_limt_ext == 'sim' && !in_array($this->_arq_ext, $this->_ext_validas)) {
            $this->isError = true;
            $this->_msg_retorno = "A extensão do arquivo é inválida!!! Extensão do seu arquivo {$this->_arq_ext}!!!";
            return false;
        } else {
            return true;
        }
    }

    private function chkInicioNome($nome, $valor) {
        $inicionome = substr($nome, 0, strlen($valor));
        if ($inicionome <> $valor) {
            $this->_msg_retorno = "O arquivo deve iniciar com o nome: " . $valor;
            return false;
        }
        return true;
    }

    /**
     * Metodo para executar o upload do arquivo.
     *
     * @return mixed - false para algum erro, true se enviou o arquivo corretamente
     */
    public function enviar() {
        // verifica se o arquivo foi selecionado
        if (!empty($this->_arquivo['name'])) {
            if ($this->chkTam() === false) {
                return false;
            }

            if ($this->chkExt() === false) {
                return false;
            }

            if ($this->chkInicioNome($this->_arquivo['name'], $this->inicioNome) === false) {
                return false;
            }

            // caso o diretório não exista, é criado
            if (!is_dir($this->_path)) {
                mkdir($this->_path, 0777);
            }

            // faz o upload do arquivo
            if (move_uploaded_file($this->_arquivo['tmp_name'], $this->_path . "/" . $this->_novo_nome)) {
                $this->_msg_retorno = "O arquivo {$this->_arquivo['name']} foi enviado com sucesso!!!";
                return true;
            } else {
                $this->_msg_retorno = "O arquivo {$this->_arquivo['name']} não pode ser enviado!!!";
                return false;
            }
        } else {
            $this->_msg_retorno = "Selecione um arquivo para ser enviado!!!";
            return false;
        }
    }

    private function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

}

// uso:
// cria a instancia da classe
//$_upl = new upload();
//// seta as extensões que serão validas
//$_upl->setExtValidas(array(".jpg", ".JPG", ".gif", ".png",".pdf",".doc",".docx"));
//// seta informações do arquivo, campo vindo do formulário
//$_upl->setArquivo($_FILES['arquivo']);
//// seta o diretório para onde irá o arquivo
//$_upl->setPath("../../downloads");
//// chama o metodo enviar() para realizar o upload
////$_upl->enviar();// exibe a mensagem de retornoecho
//$_upl->getMsgRetorno();
?>
