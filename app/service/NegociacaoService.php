<?php

class NegociacaoService
{
    public static function podeEditar($negociacao_id)
    {
        $negociacao = new Negociacao($negociacao_id);
        
        if(EtapaNegociacao::where('permite_edicao', '=', 'T')->where('id', '=', $negociacao->etapa_negociacao_id)->first())
        {
            return true;
        }
        
        return false;
    }
    
    public static function podeExcluir($negociacao_id)
    {
        $negociacao = new Negociacao($negociacao_id);
        
        if(EtapaNegociacao::where('permite_exclusao', '=', 'T')->where('id', '=', $negociacao->etapa_negociacao_id)->first())
        {
            return true;
        }
        
        return false;
    }
    
    public static function enviaEmailNovoPedido()
    {
        try 
        {
            TTransaction::open('minierp');
            
            $pedidos = PedidoVenda::where('negociacao_id', 'in', "(SELECT id FROM negociacao where email_novo_pedido_enviado = 'F')")->load();
            
            $emailTemplate = new EmailTemplate(EmailTEmplate::EMAIL_AUTOMATICO_PEDIDO_FROM_NEGOCIACAO);
            TTransaction::close();
            
        } 
        catch (Exception $e) 
        {
            TTransaction::rollback();
                    
            TTransaction::open('minierp');
            $errorLogCrontab = new ErrorLogCrontab();
            $errorLogCrontab->classe = 'NegociacaoService';
            $errorLogCrontab->metodo = 'enviaEmailNovoPedido';
            $errorLogCrontab->mensagem = $e->getMessage();
            $errorLogCrontab->store();
            TTransaction::close();
        }
        
        if($pedidos)
        {
            foreach($pedidos as $pedido)
            {
                try
                {
                    TTransaction::open('minierp');
                
                    $mensagem = $emailTemplate->mensagem;
                    $titulo = $emailTemplate->titulo;
                    
                    $itensPedido = $pedido->getPedidoVendaItems();
                    
                    if($itensPedido)
                    {
                        $itens_pedido = '';
                        foreach($itensPedido as $itemPedido)
                        {
                            $valor_total = number_format($itemPedido->valor_total, 2, ',', '.');
                            $itens_pedido .= "{$itemPedido->produto->nome} - {$itemPedido->quantidade} - R$ {$valor_total} <br>";
                        }
                    }
                    
                    $data_pedido = TDate::date2br($pedido->dt_pedido);

                    $mensagem = str_replace('{nome}', $pedido->cliente->nome, $mensagem);
                    $mensagem = str_replace('{itens_pedido}', $itens_pedido, $mensagem);
                    $mensagem = str_replace('{data_pedido}', $data_pedido, $mensagem);
                    $mensagem = str_replace('{id}', $pedido->id, $mensagem);
                    
                    $titulo = str_replace('{nome}', $pedido->cliente->nome, $titulo);
                    $titulo = str_replace('{id}', $pedido->id, $titulo);
    
                    if($pedido->cliente->email)
                    {
                        MailService::send($pedido->cliente->email, $titulo, $mensagem,  'html');    
                    }
                    
                    $pedido->negociacao->email_novo_pedido_enviado = 'T';
                    $pedido->negociacao->store();
                    
                    TTransaction::close();
                } 
                catch (Exception $e) 
                {
                    TTransaction::rollback();
                    
                    TTransaction::open('minierp');
                    $errorLogCrontab = new ErrorLogCrontab();
                    $errorLogCrontab->classe = 'NegociacaoService';
                    $errorLogCrontab->metodo = 'enviaEmailNovoPedido';
                    $errorLogCrontab->mensagem = "Pedido: {$pedido->id}<br><br>".$e->getMessage();
                    $errorLogCrontab->store();
                    TTransaction::close();
                }
            }
        }
    }
}
