<?php

class Mail_Sender {

    private $de;
    private $para = null;
    private $email_recusado;
    private $tipo = "text/plain";
    private $assunto;
    private $mensagem;
    private $cabecalhos;
    private $prioridade = 3;
    private $responder_para = null;
    private $msg_error;

    public function __construct() {
        $this->getTipoEmail();
        $this->getPrioridade();
        $this->getResponderPara();
    }

    private function getTipoEmail() {
        return $this->tipo;
    }

    public function comoHtml() {
        $this->tipo = "text/html";
    }

    public function setDe($de) {
        if (Helpers::isMail($de)) {
            $this->de = $de;
        } else {
            $this->msg_error = "E-mail passado não é válido!";
        }
    }

    private function getDe() {
        if ($this->de) {
            return $this->de;
        } else {
            return false;
        }
    }

    public function setPara($para) {
        if (is_array($para)) {
            if (count($para) > 1) {
                foreach ($para as $email) {
                    if (Helpers::isMail($email)) {
                        $this->para = $this->para . $email . ",";
                    } else {
                        $this->msg_error = "<br/>" . $this->email_recusado . $email . "<br/>";
                    }
                }
            } else {
                $this->para = $para[0];
            }
        } else {
            $this->msg_error = "O método setPara só aceita <strong>array</strong>";
        }
    }

    private function getPara() {
        if ($this->para != null) {
            return rtrim($this->para, ',');
        } else {
            return $this->msg_error;
        }
    }

    public function setAssunto($assunto) {
        if (is_string($assunto)) {
            $this->assunto = trim($assunto);
        } else {
            $this->msg_error = "Você de passar uma <strong>STRING</strong> como parâmetro!";
        }
    }

    private function getAssunto() {
        return $this->assunto;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    private function getMensagem() {
        return $this->mensagem;
    }

    public function setPrioridade($prioridade) {
        if (is_int($prioridade)) {
            $this->prioridade = $prioridade;
        } else {
            $this->msg_error = "Você deve passar um valor <strong>INTEIRO</strong> como parâmetro!";
        }
    }

    private function getPrioridade() {
        return $this->prioridade;
    }

    public function setResponderPara($para) {
        if (is_array($para)) {
            if (count($para) > 1) {
                foreach ($para as $email) {
                    if (Helpers::isMail($email)) {
                        $this->responder_para = $this->responder_para . $email . ",";
                    } else {
                        $this->msg_error = "<br/>" . $this->email_recusado . $email . "<br/>";
                    }
                }
            } else {
                $this->responder_para = $para[0];
            }
        } else {
            $this->msg_error = "O método setResponderPara só aceita <strong>array</strong>";
        }
    }

    private function getResponderPara() {
        if ($this->responder_para != null) {
            return rtrim($this->responder_para, ',');
        } else {
            return $this->getDe();
        }
    }

    private function getCabecalhos() {
        return $this->cabecalhos = "From:".$this->getDe(). "\r\n".
        "Reply-To:".$this->getResponderPara(). "\r\n".
        "X-Mailer:PHP/".phpversion()."\r\n".
        "Erros-To:".$this->getDe()."\r\n".
        "Return-Path:".$this->getDe()."\r\n".
        "Content-Type:". $this->getTipoEmail()."; charset='utf-8'"."\r\n".
        "Date:" .date("r(T)")."\r\n".
        "X-Priority:".$this->getPrioridade()."\r\n".
        "MIME-Version:1.1";        
    }

    public function getError(){
        return $this->msg_error;
    }
    
    public function Enviar() {
        if(!$this->getDe()){
            return false;
        }else{
            if(mail($this->getPara(), $this->getAssunto(), $this->getMensagem(), $this->getCabecalhos())){
                return true; 
            }else{
                return false;
            }
        }
    }
}
