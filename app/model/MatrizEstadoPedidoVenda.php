<?php

class MatrizEstadoPedidoVenda extends TRecord
{
    const TABLENAME  = 'matriz_estado_pedido_venda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $estado_pedido_venda_origem;
    private $estado_pedido_venda_destino;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('estado_pedido_venda_origem_id');
        parent::addAttribute('estado_pedido_venda_destino_id');
            
    }

    /**
     * Method set_estado_pedido_venda
     * Sample of usage: $var->estado_pedido_venda = $object;
     * @param $object Instance of EstadoPedidoVenda
     */
    public function set_estado_pedido_venda_origem(EstadoPedidoVenda $object)
    {
        $this->estado_pedido_venda_origem = $object;
        $this->estado_pedido_venda_origem_id = $object->id;
    }

    /**
     * Method get_estado_pedido_venda_origem
     * Sample of usage: $var->estado_pedido_venda_origem->attribute;
     * @returns EstadoPedidoVenda instance
     */
    public function get_estado_pedido_venda_origem()
    {
    
        // loads the associated object
        if (empty($this->estado_pedido_venda_origem))
            $this->estado_pedido_venda_origem = new EstadoPedidoVenda($this->estado_pedido_venda_origem_id);
    
        // returns the associated object
        return $this->estado_pedido_venda_origem;
    }
    /**
     * Method set_estado_pedido_venda
     * Sample of usage: $var->estado_pedido_venda = $object;
     * @param $object Instance of EstadoPedidoVenda
     */
    public function set_estado_pedido_venda_destino(EstadoPedidoVenda $object)
    {
        $this->estado_pedido_venda_destino = $object;
        $this->estado_pedido_venda_destino_id = $object->id;
    }

    /**
     * Method get_estado_pedido_venda_destino
     * Sample of usage: $var->estado_pedido_venda_destino->attribute;
     * @returns EstadoPedidoVenda instance
     */
    public function get_estado_pedido_venda_destino()
    {
    
        // loads the associated object
        if (empty($this->estado_pedido_venda_destino))
            $this->estado_pedido_venda_destino = new EstadoPedidoVenda($this->estado_pedido_venda_destino_id);
    
        // returns the associated object
        return $this->estado_pedido_venda_destino;
    }

    
}

