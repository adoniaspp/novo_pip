<?php

class Email {
    
    public static function enviarEmail($dadosEmail) {
        //enviar email
                    $mail = new PHPMailer();

                    $mail->CharSet = 'UTF-8';
        //$mail->Sender = 'contato_naoresponda@pipbeta.com.br';
        //$mail->From = $dadosEmail['contato'] . "<teste@gmail.com>";
        //$mail->FromName = $dadosEmail['contato'];
        $mail->SetFrom("contato_naoresponda@pipbeta.com.br", (empty(trim($dadosEmail['contato'])) ? utf8_decode("Procure Imóveis Paidégua") : $dadosEmail['contato'])  );

//                    $mail->From = 'emailfrom@email.com';
  //                  $mail->FromName = $dadosEmail['contato'];

                    $mail->IsHTML(true);
                    $assunto = ($dadosEmail['assunto']);
                    $mail->Subject =  '=?UTF-8?B?'.base64_encode($assunto).'?=';
                    
                    $mail->Body = $dadosEmail['msg'];
//                    $mail->Body = "<br> <h1>Teste de envio</h1> <br>";
//                    $mail->AltBody = 'Conteudo sem HTML para editores que não suportam, sim, existem alguns';
                    
                    //verificar se existe anexo, ou seja, se está sendo usada a função de enviar anuncios por PDF
                    if($dadosEmail['nomeArquivo'] != ""){
                    $mail->AddAttachment($dadosEmail['nomeArquivo']);
                    }
                    
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Host = "smtp.pipbeta.com.br";
                    $mail->Port = 587;
                    $mail->Username = 'contato_naoresponda@pipbeta.com.br';
                    $mail->Password = 'osestudantes';

                    $mail->AddAddress($dadosEmail['destino'], $dadosEmail['nome']);

                    if ($mail->Send()) {
                        return true;
                    } else {
                        return false;
                    }
    }
}

