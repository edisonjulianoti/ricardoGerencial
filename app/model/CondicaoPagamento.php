<?php

class CondicaoPagamento extends TRecord
{
    const TABLENAME  = 'condicao_pagamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('numero_parcelas');
        parent::addAttribute('inicio');
        parent::addAttribute('intervalo');
            
    }

    /**
     * Method getNotaFiscals
     */
    public function getNotaFiscals()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('condicao_pagamento_id', '=', $this->id));
        return NotaFiscal::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('condicao_pagamento_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }

    public function set_nota_fiscal_cliente_to_string($nota_fiscal_cliente_to_string)
    {
        if(is_array($nota_fiscal_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $nota_fiscal_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->nota_fiscal_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_cliente_to_string = $nota_fiscal_cliente_to_string;
        }

        $this->vdata['nota_fiscal_cliente_to_string'] = $this->nota_fiscal_cliente_to_string;
    }

    public function get_nota_fiscal_cliente_to_string()
    {
        if(!empty($this->nota_fiscal_cliente_to_string))
        {
            return $this->nota_fiscal_cliente_to_string;
        }
    
        $values = NotaFiscal::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_nota_fiscal_pedido_venda_to_string($nota_fiscal_pedido_venda_to_string)
    {
        if(is_array($nota_fiscal_pedido_venda_to_string))
        {
            $values = PedidoVenda::where('id', 'in', $nota_fiscal_pedido_venda_to_string)->getIndexedArray('id', 'id');
            $this->nota_fiscal_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_pedido_venda_to_string = $nota_fiscal_pedido_venda_to_string;
        }

        $this->vdata['nota_fiscal_pedido_venda_to_string'] = $this->nota_fiscal_pedido_venda_to_string;
    }

    public function get_nota_fiscal_pedido_venda_to_string()
    {
        if(!empty($this->nota_fiscal_pedido_venda_to_string))
        {
            return $this->nota_fiscal_pedido_venda_to_string;
        }
    
        $values = NotaFiscal::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    public function set_nota_fiscal_condicao_pagamento_to_string($nota_fiscal_condicao_pagamento_to_string)
    {
        if(is_array($nota_fiscal_condicao_pagamento_to_string))
        {
            $values = CondicaoPagamento::where('id', 'in', $nota_fiscal_condicao_pagamento_to_string)->getIndexedArray('nome', 'nome');
            $this->nota_fiscal_condicao_pagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_condicao_pagamento_to_string = $nota_fiscal_condicao_pagamento_to_string;
        }

        $this->vdata['nota_fiscal_condicao_pagamento_to_string'] = $this->nota_fiscal_condicao_pagamento_to_string;
    }

    public function get_nota_fiscal_condicao_pagamento_to_string()
    {
        if(!empty($this->nota_fiscal_condicao_pagamento_to_string))
        {
            return $this->nota_fiscal_condicao_pagamento_to_string;
        }
    
        $values = NotaFiscal::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('tipo_pedido_id','{tipo_pedido->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('transportadora_id','{transportadora->nome}');
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
    
        $values = PedidoVenda::where('condicao_pagamento_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    
}

