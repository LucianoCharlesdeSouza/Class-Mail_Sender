# Class-Mail_Sender
Classe de envio de e-mail usando a função nativa mail.
Apenas faça um form com dois input type text com names nome e email
e um textarea com name msg

        $dados_form = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados_form['nome'])):
            if (!in_array("", $dados_form)):
                $email = new Mail_Sender();
                $email->setDe("contato@realtrueweb.com.br");
                $email->setPara([$dados_form['email']]);
                $email->setResponderPara(["souzacomprog@gmail.com"]);
                $email->setAssunto("Valeu {$dados_form['nome']}"
                        . " por ter entrado em contato com a gente!");

                $mensagem = "<img src='" . BASE . "assets/img/capa-min.png' alt='Capa do Canal' title='Capa do Canal' /><br />"
                        . "O email recebido foi de: <strong>{$dados_form['email']}</strong><br />"
                        . "Mensagem: {$dados_form['msg']}";
                $email->setMensagem($mensagem);

                $email->comoHtml();

                if ($email->Enviar()):
                    if ($email->getError()):
                        echo "Não foi possivel fazer o envio ao(s) seguinte(s) email(s): "
                        . " <strong> {$email->getError()} </strong>"
                        . "<p>Porem todo(s) o(s) outro(s) foi(foram) enviado(s) com sucesso!</p>";
                    else:
                        echo "E-mail enviado com sucesso!";
                    endif;
                else:
                    echo $email->getError();
                endif;

            else:
                $data['msg'] = "Preencha todos os campos!";
            endif;
        endif;
