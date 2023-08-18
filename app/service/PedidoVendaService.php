<?php

class PedidoVendaService
{
    public static function notificarVendedorPedido($pedido_venda)
    {
        $emailTemplate = new EmailTemplate(EmailTemplate::ATUALIZACAO);
        
        $titulo = $emailTemplate->titulo;
        $mensagem = $emailTemplate->mensagem;
        
        $titulo = $pedido_venda->render($titulo);
        $mensagem = $pedido_venda->render($mensagem);
        
        $user_id = $pedido_venda->vendedor->system_user_id;
        
        $notificationParam = [
            'key' => $pedido_venda->id
        ];
        $icon = 'fas fa-file-invoice-dollar';
        
        SystemNotification::register( $user_id, $titulo, $mensagem, new TAction(['PedidoVendaFormView', 'onShow'], $notificationParam), 'Visualizar Pedido', $icon);
        
        SendGridMailService::enviar($pedido_venda->vendedor->email, $titulo, $mensagem);
        
    }
    
    public static function notificarAprovador($pedido_venda)
    {
        $emailTemplate = new EmailTemplate(EmailTemplate::PEDIDO_AGUARDANDO_APROVACAO);
        
        $titulo = $emailTemplate->titulo;
        $mensagem = $emailTemplate->mensagem;
        
        $titulo = $pedido_venda->render($titulo);
        $mensagem = $pedido_venda->render($mensagem);
        
        $notificationParam = [
            'key' => $pedido_venda->id
        ];
        $icon = 'fas fa-file-invoice-dollar';
        
        
        $aprovadores = Aprovador::getAprovadorAtualFromPedidoVenda($pedido_venda);
        
        if($aprovadores)
        {
            foreach($aprovadores as $aprovador)    
            {
                $user_id = $aprovador->system_user_id;
        
                SystemNotification::register( $user_id, $titulo, $mensagem, new TAction(['PedidoVendaFormView', 'onShow'], $notificationParam), 'Visualizar Pedido', $icon);
                
                SendGridMailService::enviar($aprovador->system_user->email, $titulo, $mensagem);
            }
        }
        
        
        
    }
}
