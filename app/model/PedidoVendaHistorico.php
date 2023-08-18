<?php

class PedidoVendaHistorico extends TRecord
{
    const TABLENAME  = 'pedido_venda_historico';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $pedido_venda;
    private $estado_pedido_venda;
    private $aprovador;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pedido_venda_id');
        parent::addAttribute('estado_pedido_venda_id');
        parent::addAttribute('aprovador_id');
        parent::addAttribute('data_operacao');
        parent::addAttribute('obs');
            
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
     * Method set_aprovador
     * Sample of usage: $var->aprovador = $object;
     * @param $object Instance of Aprovador
     */
    public function set_aprovador(Aprovador $object)
    {
        $this->aprovador = $object;
        $this->aprovador_id = $object->id;
    }

    /**
     * Method get_aprovador
     * Sample of usage: $var->aprovador->attribute;
     * @returns Aprovador instance
     */
    public function get_aprovador()
    {
    
        // loads the associated object
        if (empty($this->aprovador))
            $this->aprovador = new Aprovador($this->aprovador_id);
    
        // returns the associated object
        return $this->aprovador;
    }

    
}

