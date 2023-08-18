<?php

class Conta extends TRecord
{
    const TABLENAME  = 'conta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_conta;
    private $categoria;
    private $forma_pagamento;
    private $pessoa;
    private $pedido_venda;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pessoa_id');
        parent::addAttribute('tipo_conta_id');
        parent::addAttribute('categoria_id');
        parent::addAttribute('forma_pagamento_id');
        parent::addAttribute('pedido_venda_id');
        parent::addAttribute('dt_vencimento');
        parent::addAttribute('dt_emissao');
        parent::addAttribute('dt_pagamento');
        parent::addAttribute('valor');
        parent::addAttribute('parcela');
        parent::addAttribute('obs');
        parent::addAttribute('mes_vencimento');
        parent::addAttribute('ano_vencimento');
        parent::addAttribute('ano_mes_vencimento');
        parent::addAttribute('mes_emissao');
        parent::addAttribute('ano_emissao');
        parent::addAttribute('ano_mes_emissao');
        parent::addAttribute('mes_pagamento');
        parent::addAttribute('ano_pagamento');
        parent::addAttribute('ano_mes_pagamento');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
    
    }

    /**
     * Method set_tipo_conta
     * Sample of usage: $var->tipo_conta = $object;
     * @param $object Instance of TipoConta
     */
    public function set_tipo_conta(TipoConta $object)
    {
        $this->tipo_conta = $object;
        $this->tipo_conta_id = $object->id;
    }

    /**
     * Method get_tipo_conta
     * Sample of usage: $var->tipo_conta->attribute;
     * @returns TipoConta instance
     */
    public function get_tipo_conta()
    {
    
        // loads the associated object
        if (empty($this->tipo_conta))
            $this->tipo_conta = new TipoConta($this->tipo_conta_id);
    
        // returns the associated object
        return $this->tipo_conta;
    }
    /**
     * Method set_categoria
     * Sample of usage: $var->categoria = $object;
     * @param $object Instance of Categoria
     */
    public function set_categoria(Categoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }

    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns Categoria instance
     */
    public function get_categoria()
    {
    
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new Categoria($this->categoria_id);
    
        // returns the associated object
        return $this->categoria;
    }
    /**
     * Method set_forma_pagamento
     * Sample of usage: $var->forma_pagamento = $object;
     * @param $object Instance of FormaPagamento
     */
    public function set_forma_pagamento(FormaPagamento $object)
    {
        $this->forma_pagamento = $object;
        $this->forma_pagamento_id = $object->id;
    }

    /**
     * Method get_forma_pagamento
     * Sample of usage: $var->forma_pagamento->attribute;
     * @returns FormaPagamento instance
     */
    public function get_forma_pagamento()
    {
    
        // loads the associated object
        if (empty($this->forma_pagamento))
            $this->forma_pagamento = new FormaPagamento($this->forma_pagamento_id);
    
        // returns the associated object
        return $this->forma_pagamento;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_pessoa(Pessoa $object)
    {
        $this->pessoa = $object;
        $this->pessoa_id = $object->id;
    }

    /**
     * Method get_pessoa
     * Sample of usage: $var->pessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_pessoa()
    {
    
        // loads the associated object
        if (empty($this->pessoa))
            $this->pessoa = new Pessoa($this->pessoa_id);
    
        // returns the associated object
        return $this->pessoa;
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
     * Method getContaAnexos
     */
    public function getContaAnexos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('conta_id', '=', $this->id));
        return ContaAnexo::getObjects( $criteria );
    }

    public function set_conta_anexo_conta_to_string($conta_anexo_conta_to_string)
    {
        if(is_array($conta_anexo_conta_to_string))
        {
            $values = Conta::where('id', 'in', $conta_anexo_conta_to_string)->getIndexedArray('id', 'id');
            $this->conta_anexo_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_anexo_conta_to_string = $conta_anexo_conta_to_string;
        }

        $this->vdata['conta_anexo_conta_to_string'] = $this->conta_anexo_conta_to_string;
    }

    public function get_conta_anexo_conta_to_string()
    {
        if(!empty($this->conta_anexo_conta_to_string))
        {
            return $this->conta_anexo_conta_to_string;
        }
    
        $values = ContaAnexo::where('conta_id', '=', $this->id)->getIndexedArray('conta_id','{conta->id}');
        return implode(', ', $values);
    }

    public function set_conta_anexo_tipo_anexo_to_string($conta_anexo_tipo_anexo_to_string)
    {
        if(is_array($conta_anexo_tipo_anexo_to_string))
        {
            $values = TipoAnexo::where('id', 'in', $conta_anexo_tipo_anexo_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_anexo_tipo_anexo_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_anexo_tipo_anexo_to_string = $conta_anexo_tipo_anexo_to_string;
        }

        $this->vdata['conta_anexo_tipo_anexo_to_string'] = $this->conta_anexo_tipo_anexo_to_string;
    }

    public function get_conta_anexo_tipo_anexo_to_string()
    {
        if(!empty($this->conta_anexo_tipo_anexo_to_string))
        {
            return $this->conta_anexo_tipo_anexo_to_string;
        }
    
        $values = ContaAnexo::where('conta_id', '=', $this->id)->getIndexedArray('tipo_anexo_id','{tipo_anexo->nome}');
        return implode(', ', $values);
    }

    public function get_status()
    {
        if(date('Y-m-d') > $this->dt_vencimento && !$this->dt_pagamento)
        {
            return "<label style='width:120px;' class='label label-danger'> ATRASADA </label>";
        }
        elseif(!$this->dt_pagamento )
        {
            return "<label style='width:120px;' class='label label-warning'> EM ABERTA </label>";
        }
        elseif($this->dt_pagamento )
        {
            return "<label style='width:120px;' class='label label-success'> QUITADA </label>";
        }
    }

    public function get_status_texto()
    {
        if(date('Y-m-d') > $this->dt_vencimento && !$this->dt_pagamento)
        {
            return "ATRASADA";
        }
        elseif(!$this->dt_pagamento )
        {
            return "EM ABERTA";
        }
        elseif($this->dt_pagamento )
        {
            return "QUITADA";
        }
    }

    public function onBeforeStore($object)
    {
        if (! empty($object->dt_emissao))
        {
            $object->mes_emissao = date('m', strtotime($object->dt_emissao));
            $object->ano_emissao = date('Y', strtotime($object->dt_emissao));
            $object->ano_mes_emissao = date('Ym', strtotime($object->dt_emissao));
        }
    
        if (! empty($object->dt_vencimento))
        {
            $object->mes_vencimento = date('m', strtotime($object->dt_vencimento));
            $object->ano_vencimento = date('Y', strtotime($object->dt_vencimento));
            $object->ano_mes_vencimento = date('Ym', strtotime($object->dt_vencimento));
        }
    
        if (! empty($object->dt_pagamento))
        {
            $object->mes_pagamento = date('m', strtotime($object->dt_pagamento));
            $object->ano_pagamento = date('Y', strtotime($object->dt_pagamento));
            $object->ano_mes_pagamento = date('Ym', strtotime($object->dt_pagamento));
        }
    }

        
}

