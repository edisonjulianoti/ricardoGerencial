<?php

class NotaFiscal extends TRecord
{
    const TABLENAME  = 'nota_fiscal';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $pedido_venda;
    private $cliente;
    private $condicao_pagamento;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('pedido_venda_id');
        parent::addAttribute('condicao_pagamento_id');
        parent::addAttribute('obs');
        parent::addAttribute('mes');
        parent::addAttribute('ano');
        parent::addAttribute('valor_total');
        parent::addAttribute('data_emissao');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
    
    }

    /**
     * Method set_pedido_venda
     * Sample of usage: $var->pedido_venda = $object;
     * @param $object Instance of PedidoVenda
     */
    public function set_pedido_venda(PedidoVenda $object)
    {
        $this->pedido_venda = $object;
        $this->pedido_venda_id = $object->id;
    }

    /**
     * Method get_pedido_venda
     * Sample of usage: $var->pedido_venda->attribute;
     * @returns PedidoVenda instance
     */
    public function get_pedido_venda()
    {
    
        // loads the associated object
        if (empty($this->pedido_venda))
            $this->pedido_venda = new PedidoVenda($this->pedido_venda_id);
    
        // returns the associated object
        return $this->pedido_venda;
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
     * Method getNotaFiscalItems
     */
    public function getNotaFiscalItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('nota_fiscal_id', '=', $this->id));
        return NotaFiscalItem::getObjects( $criteria );
    }

    public function set_nota_fiscal_item_pedido_venda_item_to_string($nota_fiscal_item_pedido_venda_item_to_string)
    {
        if(is_array($nota_fiscal_item_pedido_venda_item_to_string))
        {
            $values = PedidoVendaItem::where('id', 'in', $nota_fiscal_item_pedido_venda_item_to_string)->getIndexedArray('id', 'id');
            $this->nota_fiscal_item_pedido_venda_item_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_item_pedido_venda_item_to_string = $nota_fiscal_item_pedido_venda_item_to_string;
        }

        $this->vdata['nota_fiscal_item_pedido_venda_item_to_string'] = $this->nota_fiscal_item_pedido_venda_item_to_string;
    }

    public function get_nota_fiscal_item_pedido_venda_item_to_string()
    {
        if(!empty($this->nota_fiscal_item_pedido_venda_item_to_string))
        {
            return $this->nota_fiscal_item_pedido_venda_item_to_string;
        }
    
        $values = NotaFiscalItem::where('nota_fiscal_id', '=', $this->id)->getIndexedArray('pedido_venda_item_id','{pedido_venda_item->id}');
        return implode(', ', $values);
    }

    public function set_nota_fiscal_item_nota_fiscal_to_string($nota_fiscal_item_nota_fiscal_to_string)
    {
        if(is_array($nota_fiscal_item_nota_fiscal_to_string))
        {
            $values = NotaFiscal::where('id', 'in', $nota_fiscal_item_nota_fiscal_to_string)->getIndexedArray('id', 'id');
            $this->nota_fiscal_item_nota_fiscal_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_item_nota_fiscal_to_string = $nota_fiscal_item_nota_fiscal_to_string;
        }

        $this->vdata['nota_fiscal_item_nota_fiscal_to_string'] = $this->nota_fiscal_item_nota_fiscal_to_string;
    }

    public function get_nota_fiscal_item_nota_fiscal_to_string()
    {
        if(!empty($this->nota_fiscal_item_nota_fiscal_to_string))
        {
            return $this->nota_fiscal_item_nota_fiscal_to_string;
        }
    
        $values = NotaFiscalItem::where('nota_fiscal_id', '=', $this->id)->getIndexedArray('nota_fiscal_id','{nota_fiscal->id}');
        return implode(', ', $values);
    }

    public function set_nota_fiscal_item_produto_to_string($nota_fiscal_item_produto_to_string)
    {
        if(is_array($nota_fiscal_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $nota_fiscal_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->nota_fiscal_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_fiscal_item_produto_to_string = $nota_fiscal_item_produto_to_string;
        }

        $this->vdata['nota_fiscal_item_produto_to_string'] = $this->nota_fiscal_item_produto_to_string;
    }

    public function get_nota_fiscal_item_produto_to_string()
    {
        if(!empty($this->nota_fiscal_item_produto_to_string))
        {
            return $this->nota_fiscal_item_produto_to_string;
        }
    
        $values = NotaFiscalItem::where('nota_fiscal_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public static function createFromPedidoVenda($pedidoVenda)
    {
        $notaFiscal = new NotaFiscal();
        $notaFiscal->fromArray($pedidoVenda->toArray());
    
        unset($notaFiscal->id);
    
        $notaFiscal->pedido_venda_id = $pedidoVenda->id;
        $notaFiscal->store();
    
        $pedidoVendaItems = $pedidoVenda->getPedidoVendaItems();
    
        if($pedidoVendaItems)
        {
            foreach($pedidoVendaItems as $pedidoVendaItem)
            {
                $notaFiscalItem = new NotaFiscalItem();
                $notaFiscalItem->fromArray($pedidoVendaItem->toArray());
                unset($notaFiscalItem->id);
            
                $notaFiscalItem->nota_fiscal_id = $notaFiscal->id;
                $notaFiscalItem->pedido_venda_item_id = $pedidoVendaItem->id;
                $notaFiscalItem->store();
            }
        }
    
        return $notaFiscal;
    }

    
}

