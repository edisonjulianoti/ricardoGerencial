<?php

class SendGridMailService
{
    public static function enviar($destinatario, $titulo, $mensagem)
    {
        
        $data = array();

        $data['personalizations'][] = [
            'to' => [['email'=>$destinatario]],
            'subject'=>$titulo
        ];
        $data['from'] = ['email'=>'mailer@adiantibuilder.com.br', 'name'=>'Adianti Builder'];
        $data['content'] = [['type' => 'text/html', 'value' => $mensagem]];
        
        //BuilderHttpClientService::post('https://api.sendgrid.com/v3/mail/send', $data, 'Bearer ', ['Content-Type: application/json']);
        
    }
}
