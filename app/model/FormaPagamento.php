<?php

class FormaPagamento extends TRecord
{
    const TABLENAME  = 'forma_pagamento';
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
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('forma_pagamento_id', '=', $this->id));
        return Conta::getObjects( $criteria );
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
    
        $values = Conta::where('forma_pagamento_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
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
    
        $values = Conta::where('forma_pagamento_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->nome}');
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
    
        $values = Conta::where('forma_pagamento_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->nome}');
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
    
        $values = Conta::where('forma_pagamento_id', '=', $this->id)->getIndexedArray('forma_pagamento_id','{forma_pagamento->nome}');
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
    
        $values = Conta::where('forma_pagamento_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    
}

