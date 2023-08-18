<?php

class CategoriaCliente extends TRecord
{
    const TABLENAME  = 'categoria_cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getPessoas
     */
    public function getPessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_cliente_id', '=', $this->id));
        return Pessoa::getObjects( $criteria );
    }

    public function set_pessoa_tipo_cliente_to_string($pessoa_tipo_cliente_to_string)
    {
        if(is_array($pessoa_tipo_cliente_to_string))
        {
            $values = TipoCliente::where('id', 'in', $pessoa_tipo_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_tipo_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_tipo_cliente_to_string = $pessoa_tipo_cliente_to_string;
        }

        $this->vdata['pessoa_tipo_cliente_to_string'] = $this->pessoa_tipo_cliente_to_string;
    }

    public function get_pessoa_tipo_cliente_to_string()
    {
        if(!empty($this->pessoa_tipo_cliente_to_string))
        {
            return $this->pessoa_tipo_cliente_to_string;
        }
    
        $values = Pessoa::where('categoria_cliente_id', '=', $this->id)->getIndexedArray('tipo_cliente_id','{tipo_cliente->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_categoria_cliente_to_string($pessoa_categoria_cliente_to_string)
    {
        if(is_array($pessoa_categoria_cliente_to_string))
        {
            $values = CategoriaCliente::where('id', 'in', $pessoa_categoria_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_categoria_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_categoria_cliente_to_string = $pessoa_categoria_cliente_to_string;
        }

        $this->vdata['pessoa_categoria_cliente_to_string'] = $this->pessoa_categoria_cliente_to_string;
    }

    public function get_pessoa_categoria_cliente_to_string()
    {
        if(!empty($this->pessoa_categoria_cliente_to_string))
        {
            return $this->pessoa_categoria_cliente_to_string;
        }
    
        $values = Pessoa::where('categoria_cliente_id', '=', $this->id)->getIndexedArray('categoria_cliente_id','{categoria_cliente->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_system_user_to_string($pessoa_system_user_to_string)
    {
        if(is_array($pessoa_system_user_to_string))
        {
            $values = SystemUsers::where('id', 'in', $pessoa_system_user_to_string)->getIndexedArray('name', 'name');
            $this->pessoa_system_user_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_system_user_to_string = $pessoa_system_user_to_string;
        }

        $this->vdata['pessoa_system_user_to_string'] = $this->pessoa_system_user_to_string;
    }

    public function get_pessoa_system_user_to_string()
    {
        if(!empty($this->pessoa_system_user_to_string))
        {
            return $this->pessoa_system_user_to_string;
        }
    
        $values = Pessoa::where('categoria_cliente_id', '=', $this->id)->getIndexedArray('system_user_id','{system_user->name}');
        return implode(', ', $values);
    }

    
}

