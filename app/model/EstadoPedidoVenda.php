<?php

class EstadoPedidoVenda extends TRecord
{
    const TABLENAME  = 'estado_pedido_venda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    const ELABORACAO = '1';
    const ANALISE_COMERCIAL = '2';
    const ANALISE_FINANCEIRA = '3';
    const EM_PROCESSAMENTO = '4';
    const EM_FATURAMENTO = '6';
    const AGUARDANDO_ENTREGA = '7';
    const FINALIZADO = '8';
    const CANCELADO = '9';
    const REPROVADO = '10';
    const GERANDO_FINANCEIRO = '5';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cor');
        parent::addAttribute('kanban');
        parent::addAttribute('ordem');
        parent::addAttribute('estado_final');
        parent::addAttribute('estado_inicial');
        parent::addAttribute('permite_edicao');
        parent::addAttribute('permite_exclusao');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
    
    }

    /**
     * Method getEstadoPedidoVendaAprovadors
     */
    public function getEstadoPedidoVendaAprovadors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_pedido_venda_id', '=', $this->id));
        return EstadoPedidoVendaAprovador::getObjects( $criteria );
    }
    /**
     * Method getMatrizEstadoPedidoVendas
     */
    public function getMatrizEstadoPedidoVendasByEstadoPedidoVendaOrigems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_pedido_venda_origem_id', '=', $this->id));
        return MatrizEstadoPedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getMatrizEstadoPedidoVendas
     */
    public function getMatrizEstadoPedidoVendasByEstadoPedidoVendaDestinos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_pedido_venda_destino_id', '=', $this->id));
        return MatrizEstadoPedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_pedido_venda_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendaHistoricos
     */
    public function getPedidoVendaHistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_pedido_venda_id', '=', $this->id));
        return PedidoVendaHistorico::getObjects( $criteria );
    }

    public function set_estado_pedido_venda_aprovador_estado_pedido_venda_to_string($estado_pedido_venda_aprovador_estado_pedido_venda_to_string)
    {
        if(is_array($estado_pedido_venda_aprovador_estado_pedido_venda_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $estado_pedido_venda_aprovador_estado_pedido_venda_to_string)->getIndexedArray('nome', 'nome');
            $this->estado_pedido_venda_aprovador_estado_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->estado_pedido_venda_aprovador_estado_pedido_venda_to_string = $estado_pedido_venda_aprovador_estado_pedido_venda_to_string;
        }

        $this->vdata['estado_pedido_venda_aprovador_estado_pedido_venda_to_string'] = $this->estado_pedido_venda_aprovador_estado_pedido_venda_to_string;
    }

    public function get_estado_pedido_venda_aprovador_estado_pedido_venda_to_string()
    {
        if(!empty($this->estado_pedido_venda_aprovador_estado_pedido_venda_to_string))
        {
            return $this->estado_pedido_venda_aprovador_estado_pedido_venda_to_string;
        }
    
        $values = EstadoPedidoVendaAprovador::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
        return implode(', ', $values);
    }

    public function set_estado_pedido_venda_aprovador_aprovador_to_string($estado_pedido_venda_aprovador_aprovador_to_string)
    {
        if(is_array($estado_pedido_venda_aprovador_aprovador_to_string))
        {
            $values = Aprovador::where('id', 'in', $estado_pedido_venda_aprovador_aprovador_to_string)->getIndexedArray('id', 'id');
            $this->estado_pedido_venda_aprovador_aprovador_to_string = implode(', ', $values);
        }
        else
        {
            $this->estado_pedido_venda_aprovador_aprovador_to_string = $estado_pedido_venda_aprovador_aprovador_to_string;
        }

        $this->vdata['estado_pedido_venda_aprovador_aprovador_to_string'] = $this->estado_pedido_venda_aprovador_aprovador_to_string;
    }

    public function get_estado_pedido_venda_aprovador_aprovador_to_string()
    {
        if(!empty($this->estado_pedido_venda_aprovador_aprovador_to_string))
        {
            return $this->estado_pedido_venda_aprovador_aprovador_to_string;
        }
    
        $values = EstadoPedidoVendaAprovador::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('aprovador_id','{aprovador->id}');
        return implode(', ', $values);
    }

    public function set_matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string($matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string)
    {
        if(is_array($matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string)->getIndexedArray('nome', 'nome');
            $this->matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string = implode(', ', $values);
        }
        else
        {
            $this->matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string = $matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string;
        }

        $this->vdata['matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string'] = $this->matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string;
    }

    public function get_matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string()
    {
        if(!empty($this->matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string))
        {
            return $this->matriz_estado_pedido_venda_estado_pedido_venda_origem_to_string;
        }
    
        $values = MatrizEstadoPedidoVenda::where('estado_pedido_venda_destino_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_origem_id','{estado_pedido_venda_origem->nome}');
        return implode(', ', $values);
    }

    public function set_matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string($matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string)
    {
        if(is_array($matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string)->getIndexedArray('nome', 'nome');
            $this->matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string = implode(', ', $values);
        }
        else
        {
            $this->matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string = $matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string;
        }

        $this->vdata['matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string'] = $this->matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string;
    }

    public function get_matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string()
    {
        if(!empty($this->matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string))
        {
            return $this->matriz_estado_pedido_venda_estado_pedido_venda_destino_to_string;
        }
    
        $values = MatrizEstadoPedidoVenda::where('estado_pedido_venda_destino_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_destino_id','{estado_pedido_venda_destino->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_tipo_pedido_to_string($pedido_venda_tipo_pedido_to_string)
    {
        if(is_array($pedido_venda_tipo_pedido_to_string))
        {
            $values = TipoPedido::where('id', 'in', $pedido_venda_tipo_pedido_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_tipo_pedido_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_tipo_pedido_to_string = $pedido_venda_tipo_pedido_to_string;
        }

        $this->vdata['pedido_venda_tipo_pedido_to_string'] = $this->pedido_venda_tipo_pedido_to_string;
    }

    public function get_pedido_venda_tipo_pedido_to_string()
    {
        if(!empty($this->pedido_venda_tipo_pedido_to_string))
        {
            return $this->pedido_venda_tipo_pedido_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('tipo_pedido_id','{tipo_pedido->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_cliente_to_string($pedido_venda_cliente_to_string)
    {
        if(is_array($pedido_venda_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_cliente_to_string = $pedido_venda_cliente_to_string;
        }

        $this->vdata['pedido_venda_cliente_to_string'] = $this->pedido_venda_cliente_to_string;
    }

    public function get_pedido_venda_cliente_to_string()
    {
        if(!empty($this->pedido_venda_cliente_to_string))
        {
            return $this->pedido_venda_cliente_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_vendedor_to_string($pedido_venda_vendedor_to_string)
    {
        if(is_array($pedido_venda_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_vendedor_to_string = $pedido_venda_vendedor_to_string;
        }

        $this->vdata['pedido_venda_vendedor_to_string'] = $this->pedido_venda_vendedor_to_string;
    }

    public function get_pedido_venda_vendedor_to_string()
    {
        if(!empty($this->pedido_venda_vendedor_to_string))
        {
            return $this->pedido_venda_vendedor_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_estado_pedido_venda_to_string($pedido_venda_estado_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_estado_pedido_venda_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $pedido_venda_estado_pedido_venda_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_estado_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_estado_pedido_venda_to_string = $pedido_venda_estado_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_estado_pedido_venda_to_string'] = $this->pedido_venda_estado_pedido_venda_to_string;
    }

    public function get_pedido_venda_estado_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_estado_pedido_venda_to_string))
        {
            return $this->pedido_venda_estado_pedido_venda_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_condicao_pagamento_to_string($pedido_venda_condicao_pagamento_to_string)
    {
        if(is_array($pedido_venda_condicao_pagamento_to_string))
        {
            $values = CondicaoPagamento::where('id', 'in', $pedido_venda_condicao_pagamento_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_condicao_pagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_condicao_pagamento_to_string = $pedido_venda_condicao_pagamento_to_string;
        }

        $this->vdata['pedido_venda_condicao_pagamento_to_string'] = $this->pedido_venda_condicao_pagamento_to_string;
    }

    public function get_pedido_venda_condicao_pagamento_to_string()
    {
        if(!empty($this->pedido_venda_condicao_pagamento_to_string))
        {
            return $this->pedido_venda_condicao_pagamento_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_transportadora_to_string($pedido_venda_transportadora_to_string)
    {
        if(is_array($pedido_venda_transportadora_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_transportadora_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_transportadora_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_transportadora_to_string = $pedido_venda_transportadora_to_string;
        }

        $this->vdata['pedido_venda_transportadora_to_string'] = $this->pedido_venda_transportadora_to_string;
    }

    public function get_pedido_venda_transportadora_to_string()
    {
        if(!empty($this->pedido_venda_transportadora_to_string))
        {
            return $this->pedido_venda_transportadora_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('transportadora_id','{transportadora->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_negociacao_to_string($pedido_venda_negociacao_to_string)
    {
        if(is_array($pedido_venda_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $pedido_venda_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_negociacao_to_string = $pedido_venda_negociacao_to_string;
        }

        $this->vdata['pedido_venda_negociacao_to_string'] = $this->pedido_venda_negociacao_to_string;
    }

    public function get_pedido_venda_negociacao_to_string()
    {
        if(!empty($this->pedido_venda_negociacao_to_string))
        {
            return $this->pedido_venda_negociacao_to_string;
        }
    
        $values = PedidoVenda::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_historico_pedido_venda_to_string($pedido_venda_historico_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_historico_pedido_venda_to_string))
        {
            $values = PedidoVenda::where('id', 'in', $pedido_venda_historico_pedido_venda_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_historico_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_historico_pedido_venda_to_string = $pedido_venda_historico_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_historico_pedido_venda_to_string'] = $this->pedido_venda_historico_pedido_venda_to_string;
    }

    public function get_pedido_venda_historico_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_historico_pedido_venda_to_string))
        {
            return $this->pedido_venda_historico_pedido_venda_to_string;
        }
    
        $values = PedidoVendaHistorico::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_historico_estado_pedido_venda_to_string($pedido_venda_historico_estado_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_historico_estado_pedido_venda_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $pedido_venda_historico_estado_pedido_venda_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_historico_estado_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_historico_estado_pedido_venda_to_string = $pedido_venda_historico_estado_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_historico_estado_pedido_venda_to_string'] = $this->pedido_venda_historico_estado_pedido_venda_to_string;
    }

    public function get_pedido_venda_historico_estado_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_historico_estado_pedido_venda_to_string))
        {
            return $this->pedido_venda_historico_estado_pedido_venda_to_string;
        }
    
        $values = PedidoVendaHistorico::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_historico_aprovador_to_string($pedido_venda_historico_aprovador_to_string)
    {
        if(is_array($pedido_venda_historico_aprovador_to_string))
        {
            $values = Aprovador::where('id', 'in', $pedido_venda_historico_aprovador_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_historico_aprovador_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_historico_aprovador_to_string = $pedido_venda_historico_aprovador_to_string;
        }

        $this->vdata['pedido_venda_historico_aprovador_to_string'] = $this->pedido_venda_historico_aprovador_to_string;
    }

    public function get_pedido_venda_historico_aprovador_to_string()
    {
        if(!empty($this->pedido_venda_historico_aprovador_to_string))
        {
            return $this->pedido_venda_historico_aprovador_to_string;
        }
    
        $values = PedidoVendaHistorico::where('estado_pedido_venda_id', '=', $this->id)->getIndexedArray('aprovador_id','{aprovador->id}');
        return implode(', ', $values);
    }

    public static function getProximoEstadoPedidoVenda($estado_pedido_venda_id_atual)
    {
        $estadoPedidoVendaAtual = new EstadoPedidoVenda($estado_pedido_venda_id_atual);
    
        $estadoPedidoVenda = EstadoPedidoVenda::where('id', 'in', "(SELECT estado_pedido_venda_destino_id FROM matriz_estado_pedido_venda WHERE estado_pedido_venda_origem_id = {$estado_pedido_venda_id_atual})")
                                              ->where('ordem', '>', $estadoPedidoVendaAtual->ordem)
                                              ->orderBy('ordem', 'asc')
                                              ->first();
        if($estadoPedidoVenda)
        {
            return $estadoPedidoVenda;
        }
    
        return false;
    
    }

}

