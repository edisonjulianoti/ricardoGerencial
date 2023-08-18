<?php

class NotaFiscalItem extends TRecord
{
    const TABLENAME  = 'nota_fiscal_item';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $pedido_venda_item;
    private $nota_fiscal;
    private $produto;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pedido_venda_item_id');
        parent::addAttribute('nota_fiscal_id');
        parent::addAttribute('produto_id');
        parent::addAttribute('quantidade');
        parent::addAttribute('valor');
        parent::addAttribute('desconto');
        parent::addAttribute('valor_total');
            
    }

    /**
     * Method set_pedido_venda_item
     * Sample of usage: $var->pedido_venda_item = $object;
     * @param $object Instance of PedidoVendaItem
     */
    public function set_pedido_venda_item(PedidoVendaItem $object)
    {
        $this->pedido_venda_item = $object;
        $this->pedido_venda_item_id = $object->id;
    }

    /**
     * Method get_pedido_venda_item
     * Sample of usage: $var->pedido_venda_item->attribute;
     * @returns PedidoVendaItem instance
     */
    public function get_pedido_venda_item()
    {
    
        // loads the associated object
        if (empty($this->pedido_venda_item))
            $this->pedido_venda_item = new PedidoVendaItem($this->pedido_venda_item_id);
    
        // returns the associated object
        return $this->pedido_venda_item;
    }
    /**
     * Method set_nota_fiscal
     * Sample of usage: $var->nota_fiscal = $object;
     * @param $object Instance of NotaFiscal
     */
    public function set_nota_fiscal(NotaFiscal $object)
    {
        $this->nota_fiscal = $object;
        $this->nota_fiscal_id = $object->id;
    }

    /**
     * Method get_nota_fiscal
     * Sample of usage: $var->nota_fiscal->attribute;
     * @returns NotaFiscal instance
     */
    public function get_nota_fiscal()
    {
    
        // loads the associated object
        if (empty($this->nota_fiscal))
            $this->nota_fiscal = new NotaFiscal($this->nota_fiscal_id);
    
        // returns the associated object
        return $this->nota_fiscal;
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

    
}

