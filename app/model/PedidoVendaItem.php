<?php

class PedidoVendaItem extends TRecord
{
    const TABLENAME  = 'pedido_venda_item';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $produto;
    private $pedido_venda;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pedido_venda_id');
        parent::addAttribute('produto_id');
        parent::addAttribute('quantidade');
        parent::addAttribute('valor');
        parent::addAttribute('desconto');
        parent::addAttribute('valor_total');
            
    }

    /**
     * Method set_produto
     * Sample of usage: $var->produto = $object;
     * @param $object Instance of Produto
     */
    public function set_produto(Produto $object)
    {
        $this->produto = $object;
        $this->produto_id = $object->id;
    }

    /**
     * Method get_produto
     * Sample of usage: $var->produto->attribute;
     * @returns Produto instance
     */
    public function get_produto()
    {
    
        // loads the associated object
        if (empty($this->produto))
            $this->produto = new Produto($this->produto_id);
    
        // returns the associated object
        return $this->produto;
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
     * Method getNotaFiscalItems
     */
    public function getNotaFiscalItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pedido_venda_item_id', '=', $this->id));
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
    
        $values = NotaFiscalItem::where('pedido_venda_item_id', '=', $this->id)->getIndexedArray('pedido_venda_item_id','{pedido_venda_item->id}');
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
    
        $values = NotaFiscalItem::where('pedido_venda_item_id', '=', $this->id)->getIndexedArray('nota_fiscal_id','{nota_fiscal->id}');
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
    
        $values = NotaFiscalItem::where('pedido_venda_item_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    
}

