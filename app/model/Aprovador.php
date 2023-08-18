<?php

class Aprovador extends TRecord
{
    const TABLENAME  = 'aprovador';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $system_user;

    private static $estadosDisponveis = [];

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
    
    }

    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user(SystemUsers $object)
    {
        $this->system_user = $object;
        $this->system_user_id = $object->id;
    }

    /**
     * Method get_system_user
     * Sample of usage: $var->system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user()
    {
    
        // loads the associated object
        if (empty($this->system_user))
            $this->system_user = new SystemUsers($this->system_user_id);
    
        // returns the associated object
        return $this->system_user;
    }

    /**
     * Method getEstadoPedidoVendaAprovadors
     */
    public function getEstadoPedidoVendaAprovadors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('aprovador_id', '=', $this->id));
        return EstadoPedidoVendaAprovador::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendaHistoricos
     */
    public function getPedidoVendaHistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('aprovador_id', '=', $this->id));
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
    
        $values = EstadoPedidoVendaAprovador::where('aprovador_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
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
    
        $values = EstadoPedidoVendaAprovador::where('aprovador_id', '=', $this->id)->getIndexedArray('aprovador_id','{aprovador->id}');
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
    
        $values = PedidoVendaHistorico::where('aprovador_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
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
    
        $values = PedidoVendaHistorico::where('aprovador_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
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
    
        $values = PedidoVendaHistorico::where('aprovador_id', '=', $this->id)->getIndexedArray('aprovador_id','{aprovador->id}');
        return implode(', ', $values);
    }

    public static function getEstadosDisponiveis()
    {
        if(empty(self::$estadosDisponveis))
        {
            $estadosDisponveis = [-1]; // estado fictcio caso não tenha permissão....
    
            $aprovador = Aprovador::where('system_user_id', '=', TSession::getValue('userid'))->first();
        
            if($aprovador)
            {
                $criteria = new TCriteria();
                $criteria->add(new TFilter('aprovador_id', '=', $aprovador->id));
            
                $estadosDisponveis = EstadoPedidoVendaAprovador::getIndexedArray('estado_pedido_venda_id', 'estado_pedido_venda_id', $criteria);
            }
        
            self::$estadosDisponveis = $estadosDisponveis;
        }
    
    
        return self::$estadosDisponveis;
    
    }

    public static function getAprovadorAtualFromPedidoVenda($pedido_venda)
    {
        $criteria = new TCriteria();
        $criteria->add(new TFilter('estado_pedido_venda_id', '=', $pedido_venda->estado_pedido_venda_id));
    
        $aprovadores_id = EstadoPedidoVendaAprovador::getIndexedArray('aprovador_id', 'aprovador_id', $criteria);
    
        $aprovadores = Aprovador::where('id', 'in', $aprovadores_id)->load();
    
        return $aprovadores;
    }

    
}

