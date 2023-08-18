<?php

class PedidoVenda extends TRecord
{
    const TABLENAME  = 'pedido_venda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $cliente;
    private $vendedor;
    private $estado_pedido_venda;
    private $condicao_pagamento;
    private $transportadora;
    private $tipo_pedido;
    private $negociacao;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_pedido_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('vendedor_id');
        parent::addAttribute('estado_pedido_venda_id');
        parent::addAttribute('condicao_pagamento_id');
        parent::addAttribute('transportadora_id');
        parent::addAttribute('negociacao_id');
        parent::addAttribute('dt_pedido');
        parent::addAttribute('obs');
        parent::addAttribute('frete');
        parent::addAttribute('mes');
        parent::addAttribute('ano');
        parent::addAttribute('valor_total');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
        parent::addAttribute('obs_comercial');
        parent::addAttribute('obs_financeiro');
    
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_cliente(Pessoa $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Pessoa instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Pessoa($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_vendedor(Pessoa $object)
    {
        $this->vendedor = $object;
        $this->vendedor_id = $object->id;
    }

    /**
     * Method get_vendedor
     * Sample of usage: $var->vendedor->attribute;
     * @returns Pessoa instance
     */
    public function get_vendedor()
    {
    
        // loads the associated object
        if (empty($this->vendedor))
            $this->vendedor = new Pessoa($this->vendedor_id);
    
        // returns the associated object
        return $this->vendedor;
    }
    /**
     * Method set_estado_pedido_venda
     * Sample of usage: $var->estado_pedido_venda = $object;
     * @param $object Instance of EstadoPedidoVenda
     */
    public function set_estado_pedido_venda(EstadoPedidoVenda $object)
    {
        $this->estado_pedido_venda = $object;
        $this->estado_pedido_venda_id = $object->id;
    }

    /**
     * Method get_estado_pedido_venda
     * Sample of usage: $var->estado_pedido_venda->attribute;
     * @returns EstadoPedidoVenda instance
     */
    public function get_estado_pedido_venda()
    {
    
        // loads the associated object
        if (empty($this->estado_pedido_venda))
            $this->estado_pedido_venda = new EstadoPedidoVenda($this->estado_pedido_venda_id);
    
        // returns the associated object
        return $this->estado_pedido_venda;
    }
    /**
     * Method set_condicao_pagamento
     * Sample of usage: $var->condicao_pagamento = $object;
     * @param $object Instance of CondicaoPagamento
     */
    public function set_condicao_pagamento(CondicaoPagamento $object)
    {
        $this->condicao_pagamento = $object;
        $this->condicao_pagamento_id = $object->id;
    }

    /**
     * Method get_condicao_pagamento
     * Sample of usage: $var->condicao_pagamento->attribute;
     * @returns CondicaoPagamento instance
     */
    public function get_condicao_pagamento()
    {
    
        // loads the associated object
        if (empty($this->condicao_pagamento))
            $this->condicao_pagamento = new CondicaoPagamento($this->condicao_pagamento_id);
    
        // returns the associated object
        return $this->condicao_pagamento;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_transportadora(Pessoa $object)
    {
        $this->transportadora = $object;
        $this->transportadora_id = $object->id;
    }

    /**
     * Method get_transportadora
     * Sample of usage: $var->transportadora->attribute;
     * @returns Pessoa instance
     */
    public function get_transportadora()
    {
    
        // loads the associated object
        if (empty($this->transportadora))
            $this->transportadora = new Pessoa($this->transportadora_id);
    
        // returns the associated object
        return $this->transportadora;
    }
    /**
     * Method set_tipo_pedido
     * Sample of usage: $var->tipo_pedido = $object;
     * @param $object Instance of TipoPedido
     */
    public function set_tipo_pedido(TipoPedido $object)
    {
        $this->tipo_pedido = $object;
        $this->tipo_pedido_id = $object->id;
    }

    /**
     * Method get_tipo_pedido
     * Sample of usage: $var->tipo_pedido->attribute;
     * @returns TipoPedido instance
     */
    public function get_tipo_pedido()
    {
    
        // loads the associated object
        if (empty($this->tipo_pedido))
            $this->tipo_pedido = new TipoPedido($this->tipo_pedido_id);
    
        // returns the associated object
        return $this->tipo_pedido;
    }
    /**
     * Method set_negociacao
     * Sample of usage: $var->negociacao = $object;
     * @param $object Instance of Negociacao
     */
    public function set_negociacao(Negociacao $object)
    {
        $this->negociacao = $object;
        $this->negociacao_id = $object->id;
    }

    /**
     * Method get_negociacao
     * Sample of usage: $var->negociacao->attribute;
     * @returns Negociacao instance
     */
    public function get_negociacao()
    {
    
        // loads the associated object
        if (empty($this->negociacao))
            $this->negociacao = new Negociacao($this->negociacao_id);
    
        // returns the associated object
        return $this->negociacao;
    }

    /**
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pedido_venda_id', '=', $this->id));
        return Conta::getObjects( $criteria );
    }
    /**
     * Method getNotaFiscals
     */
    public function getNotaFiscals()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pedido_venda_id', '=', $this->id));
        return NotaFiscal::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendaHistoricos
     */
    public function getPedidoVendaHistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pedido_venda_id', '=', $this->id));
        return PedidoVendaHistorico::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendaItems
     */
    public function getPedidoVendaItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pedido_venda_id', '=', $this->id));
        return PedidoVendaItem::getObjects( $criteria );
    }

    public function set_conta_pessoa_to_string($conta_pessoa_to_string)
    {
        if(is_array($conta_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $conta_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_pessoa_to_string = $conta_pessoa_to_string;
        }

        $this->vdata['conta_pessoa_to_string'] = $this->conta_pessoa_to_string;
    }

    public function get_conta_pessoa_to_string()
    {
        if(!empty($this->conta_pessoa_to_string))
        {
            return $this->conta_pessoa_to_string;
        }
    
        $values = Conta::where('pedido_venda_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_conta_tipo_conta_to_string($conta_tipo_conta_to_string)
    {
        if(is_array($conta_tipo_conta_to_string))
        {
            $values = TipoConta::where('id', 'in', $conta_tipo_conta_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_tipo_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_tipo_conta_to_string = $conta_tipo_conta_to_string;
        }

        $this->vdata['conta_tipo_conta_to_string'] = $this->conta_tipo_conta_to_string;
    }

    public function get_conta_tipo_conta_to_string()
    {
        if(!empty($this->conta_tipo_conta_to_string))
        {
            return $this->conta_tipo_conta_to_string;
        }
    
        $values = Conta::where('pedido_venda_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->nome}');
        return implode(', ', $values);
    }

    public function set_conta_categoria_to_string($conta_categoria_to_string)
    {
        if(is_array($conta_categoria_to_string))
        {
            $values = Categoria::where('id', 'in', $conta_categoria_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_categoria_to_string = $conta_categoria_to_string;
        }

        $this->vdata['conta_categoria_to_string'] = $this->conta_categoria_to_string;
    }

    public function get_conta_categoria_to_string()
    {
        if(!empty($this->conta_categoria_to_string))
        {
            return $this->conta_categoria_to_string;
        }
    
        $values = Conta::where('pedido_venda_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->nome}');
        return implode(', ', $values);
    }

    public function set_conta_forma_pagamento_to_string($conta_forma_pagamento_to_string)
    {
        if(is_array($conta_forma_pagamento_to_string))
        {
            $values = FormaPagamento::where('id', 'in', $conta_forma_pagamento_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_forma_pagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_forma_pagamento_to_string = $conta_forma_pagamento_to_string;
        }

        $this->vdata['conta_forma_pagamento_to_string'] = $this->conta_forma_pagamento_to_string;
    }

    public function get_conta_forma_pagamento_to_string()
    {
        if(!empty($this->conta_forma_pagamento_to_string))
        {
            return $this->conta_forma_pagamento_to_string;
        }
    
        $values = Conta::where('pedido_venda_id', '=', $this->id)->getIndexedArray('forma_pagamento_id','{forma_pagamento->nome}');
        return implode(', ', $values);
    }

    public function set_conta_pedido_venda_to_string($conta_pedido_venda_to_string)
    {
        if(is_array($conta_pedido_venda_to_string))
        {
            $values = PedidoVenda::where('id', 'in', $conta_pedido_venda_to_string)->getIndexedArray('id', 'id');
            $this->conta_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_pedido_venda_to_string = $conta_pedido_venda_to_string;
        }

        $this->vdata['conta_pedido_venda_to_string'] = $this->conta_pedido_venda_to_string;
    }

    public function get_conta_pedido_venda_to_string()
    {
        if(!empty($this->conta_pedido_venda_to_string))
        {
            return $this->conta_pedido_venda_to_string;
        }
    
        $values = Conta::where('pedido_venda_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
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
    
        $values = NotaFiscal::where('pedido_venda_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = NotaFiscal::where('pedido_venda_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
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
    
        $values = NotaFiscal::where('pedido_venda_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
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
    
        $values = PedidoVendaHistorico::where('pedido_venda_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
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
    
        $values = PedidoVendaHistorico::where('pedido_venda_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
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
    
        $values = PedidoVendaHistorico::where('pedido_venda_id', '=', $this->id)->getIndexedArray('aprovador_id','{aprovador->id}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_item_pedido_venda_to_string($pedido_venda_item_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_item_pedido_venda_to_string))
        {
            $values = PedidoVenda::where('id', 'in', $pedido_venda_item_pedido_venda_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_item_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_item_pedido_venda_to_string = $pedido_venda_item_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_item_pedido_venda_to_string'] = $this->pedido_venda_item_pedido_venda_to_string;
    }

    public function get_pedido_venda_item_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_item_pedido_venda_to_string))
        {
            return $this->pedido_venda_item_pedido_venda_to_string;
        }
    
        $values = PedidoVendaItem::where('pedido_venda_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_item_produto_to_string($pedido_venda_item_produto_to_string)
    {
        if(is_array($pedido_venda_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $pedido_venda_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_item_produto_to_string = $pedido_venda_item_produto_to_string;
        }

        $this->vdata['pedido_venda_item_produto_to_string'] = $this->pedido_venda_item_produto_to_string;
    }

    public function get_pedido_venda_item_produto_to_string()
    {
        if(!empty($this->pedido_venda_item_produto_to_string))
        {
            return $this->pedido_venda_item_produto_to_string;
        }
    
        $values = PedidoVendaItem::where('pedido_venda_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public static function createFromNegociacao($negociacao, $propriedadesPedidoVenda)
    {
        $estadoPedidoVendaInicial = EstadoPedidoVenda::where('estado_inicial', '=', 'T')
                                                     ->first();
    
        $pedidoVenda = new PedidoVenda();
        $pedidoVenda->cliente_id = $negociacao->cliente_id;
        $pedidoVenda->vendedor_id = $negociacao->vendedor_id;
        $pedidoVenda->estado_pedido_venda_id = $estadoPedidoVendaInicial->id;
        $pedidoVenda->dt_pedido = date('Y-m-d');
        $pedidoVenda->mes = date('m');
        $pedidoVenda->ano = date('Y');
        $pedidoVenda->valor_total = 0;
        $pedidoVenda->negociacao_id = $negociacao->id;
    
        $pedidoVenda->tipo_pedido_id = $propriedadesPedidoVenda->tipo_pedido_id;
        $pedidoVenda->condicao_pagamento_id = $propriedadesPedidoVenda->condicao_pagamento_id;
        $pedidoVenda->transportadora_id = $propriedadesPedidoVenda->transportadora_id;
    
        $pedidoVenda->store();
    
        $negociacaoItems = $negociacao->getNegociacaoItems();
    
        if($negociacaoItems)
        {
            foreach($negociacaoItems as $negociacaoItem)
            {
                $pedidoVendaItem = new PedidoVendaItem();
                $pedidoVendaItem->produto_id = $negociacaoItem->produto_id;
                $pedidoVendaItem->quantidade = $negociacaoItem->quantidade;
                $pedidoVendaItem->valor = $negociacaoItem->valor;
                $pedidoVendaItem->valor_total = $negociacaoItem->valor_total;
            
                $pedidoVendaItem->pedido_venda_id = $pedidoVenda->id;
                $pedidoVendaItem->store();
            
                $pedidoVenda->valor_total += $pedidoVendaItem->valor_total;
            }
        
            $pedidoVenda->store();
        }
    
        return $pedidoVenda;
    }

}

