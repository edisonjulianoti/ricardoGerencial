<?php

class Pessoa extends TRecord
{
    const TABLENAME  = 'pessoa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_cliente;
    private $categoria_cliente;
    private $system_user;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_cliente_id');
        parent::addAttribute('categoria_cliente_id');
        parent::addAttribute('system_user_id');
        parent::addAttribute('nome');
        parent::addAttribute('documento');
        parent::addAttribute('obs');
        parent::addAttribute('fone');
        parent::addAttribute('email');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
        parent::addAttribute('login');
        parent::addAttribute('senha');
            
    }

    /**
     * Method set_tipo_cliente
     * Sample of usage: $var->tipo_cliente = $object;
     * @param $object Instance of TipoCliente
     */
    public function set_tipo_cliente(TipoCliente $object)
    {
        $this->tipo_cliente = $object;
        $this->tipo_cliente_id = $object->id;
    }

    /**
     * Method get_tipo_cliente
     * Sample of usage: $var->tipo_cliente->attribute;
     * @returns TipoCliente instance
     */
    public function get_tipo_cliente()
    {
    
        // loads the associated object
        if (empty($this->tipo_cliente))
            $this->tipo_cliente = new TipoCliente($this->tipo_cliente_id);
    
        // returns the associated object
        return $this->tipo_cliente;
    }
    /**
     * Method set_categoria_cliente
     * Sample of usage: $var->categoria_cliente = $object;
     * @param $object Instance of CategoriaCliente
     */
    public function set_categoria_cliente(CategoriaCliente $object)
    {
        $this->categoria_cliente = $object;
        $this->categoria_cliente_id = $object->id;
    }

    /**
     * Method get_categoria_cliente
     * Sample of usage: $var->categoria_cliente->attribute;
     * @returns CategoriaCliente instance
     */
    public function get_categoria_cliente()
    {
    
        // loads the associated object
        if (empty($this->categoria_cliente))
            $this->categoria_cliente = new CategoriaCliente($this->categoria_cliente_id);
    
        // returns the associated object
        return $this->categoria_cliente;
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
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return Conta::getObjects( $criteria );
    }
    /**
     * Method getNegociacaos
     */
    public function getNegociacaosByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Negociacao::getObjects( $criteria );
    }
    /**
     * Method getNegociacaos
     */
    public function getNegociacaosByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return Negociacao::getObjects( $criteria );
    }
    /**
     * Method getNotaFiscals
     */
    public function getNotaFiscals()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return NotaFiscal::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendasByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendasByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendasByTransportadoras()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('transportadora_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }
    /**
     * Method getPessoaContatos
     */
    public function getPessoaContatos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return PessoaContato::getObjects( $criteria );
    }
    /**
     * Method getPessoaEnderecos
     */
    public function getPessoaEnderecos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return PessoaEndereco::getObjects( $criteria );
    }
    /**
     * Method getPessoaGrupos
     */
    public function getPessoaGrupos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return PessoaGrupo::getObjects( $criteria );
    }
    /**
     * Method getProdutos
     */
    public function getProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fornecedor_id', '=', $this->id));
        return Produto::getObjects( $criteria );
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
    
        $values = Conta::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
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
    
        $values = Conta::where('pessoa_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->nome}');
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
    
        $values = Conta::where('pessoa_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->nome}');
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
    
        $values = Conta::where('pessoa_id', '=', $this->id)->getIndexedArray('forma_pagamento_id','{forma_pagamento->nome}');
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
    
        $values = Conta::where('pessoa_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    public function set_negociacao_cliente_to_string($negociacao_cliente_to_string)
    {
        if(is_array($negociacao_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $negociacao_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_cliente_to_string = $negociacao_cliente_to_string;
        }

        $this->vdata['negociacao_cliente_to_string'] = $this->negociacao_cliente_to_string;
    }

    public function get_negociacao_cliente_to_string()
    {
        if(!empty($this->negociacao_cliente_to_string))
        {
            return $this->negociacao_cliente_to_string;
        }
    
        $values = Negociacao::where('vendedor_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_vendedor_to_string($negociacao_vendedor_to_string)
    {
        if(is_array($negociacao_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $negociacao_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_vendedor_to_string = $negociacao_vendedor_to_string;
        }

        $this->vdata['negociacao_vendedor_to_string'] = $this->negociacao_vendedor_to_string;
    }

    public function get_negociacao_vendedor_to_string()
    {
        if(!empty($this->negociacao_vendedor_to_string))
        {
            return $this->negociacao_vendedor_to_string;
        }
    
        $values = Negociacao::where('vendedor_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_origem_contato_to_string($negociacao_origem_contato_to_string)
    {
        if(is_array($negociacao_origem_contato_to_string))
        {
            $values = OrigemContato::where('id', 'in', $negociacao_origem_contato_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_origem_contato_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_origem_contato_to_string = $negociacao_origem_contato_to_string;
        }

        $this->vdata['negociacao_origem_contato_to_string'] = $this->negociacao_origem_contato_to_string;
    }

    public function get_negociacao_origem_contato_to_string()
    {
        if(!empty($this->negociacao_origem_contato_to_string))
        {
            return $this->negociacao_origem_contato_to_string;
        }
    
        $values = Negociacao::where('vendedor_id', '=', $this->id)->getIndexedArray('origem_contato_id','{origem_contato->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_etapa_negociacao_to_string($negociacao_etapa_negociacao_to_string)
    {
        if(is_array($negociacao_etapa_negociacao_to_string))
        {
            $values = EtapaNegociacao::where('id', 'in', $negociacao_etapa_negociacao_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_etapa_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_etapa_negociacao_to_string = $negociacao_etapa_negociacao_to_string;
        }

        $this->vdata['negociacao_etapa_negociacao_to_string'] = $this->negociacao_etapa_negociacao_to_string;
    }

    public function get_negociacao_etapa_negociacao_to_string()
    {
        if(!empty($this->negociacao_etapa_negociacao_to_string))
        {
            return $this->negociacao_etapa_negociacao_to_string;
        }
    
        $values = Negociacao::where('vendedor_id', '=', $this->id)->getIndexedArray('etapa_negociacao_id','{etapa_negociacao->nome}');
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
    
        $values = NotaFiscal::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = NotaFiscal::where('cliente_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
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
    
        $values = NotaFiscal::where('cliente_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_tipo_pedido_to_string($pedido_venda_tipo_pedido_to_string)
    {
        if(is_array($pedido_venda_tipo_pedido_to_string))
        {
            $values = TipoPedido::where('id', 'in', $pedido_venda_tipo_pedido_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_tipo_pedido_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_tipo_pedido_to_string = $pedido_venda_tipo_pedido_to_string;
        }

        $this->vdata['pedido_venda_tipo_pedido_to_string'] = $this->pedido_venda_tipo_pedido_to_string;
    }

    public function get_pedido_venda_tipo_pedido_to_string()
    {
        if(!empty($this->pedido_venda_tipo_pedido_to_string))
        {
            return $this->pedido_venda_tipo_pedido_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('tipo_pedido_id','{tipo_pedido->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_cliente_to_string($pedido_venda_cliente_to_string)
    {
        if(is_array($pedido_venda_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_cliente_to_string = $pedido_venda_cliente_to_string;
        }

        $this->vdata['pedido_venda_cliente_to_string'] = $this->pedido_venda_cliente_to_string;
    }

    public function get_pedido_venda_cliente_to_string()
    {
        if(!empty($this->pedido_venda_cliente_to_string))
        {
            return $this->pedido_venda_cliente_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_vendedor_to_string($pedido_venda_vendedor_to_string)
    {
        if(is_array($pedido_venda_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_vendedor_to_string = $pedido_venda_vendedor_to_string;
        }

        $this->vdata['pedido_venda_vendedor_to_string'] = $this->pedido_venda_vendedor_to_string;
    }

    public function get_pedido_venda_vendedor_to_string()
    {
        if(!empty($this->pedido_venda_vendedor_to_string))
        {
            return $this->pedido_venda_vendedor_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_estado_pedido_venda_to_string($pedido_venda_estado_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_estado_pedido_venda_to_string))
        {
            $values = EstadoPedidoVenda::where('id', 'in', $pedido_venda_estado_pedido_venda_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_estado_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_estado_pedido_venda_to_string = $pedido_venda_estado_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_estado_pedido_venda_to_string'] = $this->pedido_venda_estado_pedido_venda_to_string;
    }

    public function get_pedido_venda_estado_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_estado_pedido_venda_to_string))
        {
            return $this->pedido_venda_estado_pedido_venda_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_condicao_pagamento_to_string($pedido_venda_condicao_pagamento_to_string)
    {
        if(is_array($pedido_venda_condicao_pagamento_to_string))
        {
            $values = CondicaoPagamento::where('id', 'in', $pedido_venda_condicao_pagamento_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_condicao_pagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_condicao_pagamento_to_string = $pedido_venda_condicao_pagamento_to_string;
        }

        $this->vdata['pedido_venda_condicao_pagamento_to_string'] = $this->pedido_venda_condicao_pagamento_to_string;
    }

    public function get_pedido_venda_condicao_pagamento_to_string()
    {
        if(!empty($this->pedido_venda_condicao_pagamento_to_string))
        {
            return $this->pedido_venda_condicao_pagamento_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_transportadora_to_string($pedido_venda_transportadora_to_string)
    {
        if(is_array($pedido_venda_transportadora_to_string))
        {
            $values = Pessoa::where('id', 'in', $pedido_venda_transportadora_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_transportadora_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_transportadora_to_string = $pedido_venda_transportadora_to_string;
        }

        $this->vdata['pedido_venda_transportadora_to_string'] = $this->pedido_venda_transportadora_to_string;
    }

    public function get_pedido_venda_transportadora_to_string()
    {
        if(!empty($this->pedido_venda_transportadora_to_string))
        {
            return $this->pedido_venda_transportadora_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('transportadora_id','{transportadora->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_negociacao_to_string($pedido_venda_negociacao_to_string)
    {
        if(is_array($pedido_venda_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $pedido_venda_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_negociacao_to_string = $pedido_venda_negociacao_to_string;
        }

        $this->vdata['pedido_venda_negociacao_to_string'] = $this->pedido_venda_negociacao_to_string;
    }

    public function get_pedido_venda_negociacao_to_string()
    {
        if(!empty($this->pedido_venda_negociacao_to_string))
        {
            return $this->pedido_venda_negociacao_to_string;
        }
    
        $values = PedidoVenda::where('transportadora_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_pessoa_contato_pessoa_to_string($pessoa_contato_pessoa_to_string)
    {
        if(is_array($pessoa_contato_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $pessoa_contato_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_contato_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_contato_pessoa_to_string = $pessoa_contato_pessoa_to_string;
        }

        $this->vdata['pessoa_contato_pessoa_to_string'] = $this->pessoa_contato_pessoa_to_string;
    }

    public function get_pessoa_contato_pessoa_to_string()
    {
        if(!empty($this->pessoa_contato_pessoa_to_string))
        {
            return $this->pessoa_contato_pessoa_to_string;
        }
    
        $values = PessoaContato::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_endereco_pessoa_to_string($pessoa_endereco_pessoa_to_string)
    {
        if(is_array($pessoa_endereco_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $pessoa_endereco_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_endereco_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_endereco_pessoa_to_string = $pessoa_endereco_pessoa_to_string;
        }

        $this->vdata['pessoa_endereco_pessoa_to_string'] = $this->pessoa_endereco_pessoa_to_string;
    }

    public function get_pessoa_endereco_pessoa_to_string()
    {
        if(!empty($this->pessoa_endereco_pessoa_to_string))
        {
            return $this->pessoa_endereco_pessoa_to_string;
        }
    
        $values = PessoaEndereco::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_endereco_cidade_to_string($pessoa_endereco_cidade_to_string)
    {
        if(is_array($pessoa_endereco_cidade_to_string))
        {
            $values = Cidade::where('id', 'in', $pessoa_endereco_cidade_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_endereco_cidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_endereco_cidade_to_string = $pessoa_endereco_cidade_to_string;
        }

        $this->vdata['pessoa_endereco_cidade_to_string'] = $this->pessoa_endereco_cidade_to_string;
    }

    public function get_pessoa_endereco_cidade_to_string()
    {
        if(!empty($this->pessoa_endereco_cidade_to_string))
        {
            return $this->pessoa_endereco_cidade_to_string;
        }
    
        $values = PessoaEndereco::where('pessoa_id', '=', $this->id)->getIndexedArray('cidade_id','{cidade->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_grupo_pessoa_to_string($pessoa_grupo_pessoa_to_string)
    {
        if(is_array($pessoa_grupo_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $pessoa_grupo_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_grupo_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_grupo_pessoa_to_string = $pessoa_grupo_pessoa_to_string;
        }

        $this->vdata['pessoa_grupo_pessoa_to_string'] = $this->pessoa_grupo_pessoa_to_string;
    }

    public function get_pessoa_grupo_pessoa_to_string()
    {
        if(!empty($this->pessoa_grupo_pessoa_to_string))
        {
            return $this->pessoa_grupo_pessoa_to_string;
        }
    
        $values = PessoaGrupo::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_grupo_grupo_pessoa_to_string($pessoa_grupo_grupo_pessoa_to_string)
    {
        if(is_array($pessoa_grupo_grupo_pessoa_to_string))
        {
            $values = GrupoPessoa::where('id', 'in', $pessoa_grupo_grupo_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_grupo_grupo_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_grupo_grupo_pessoa_to_string = $pessoa_grupo_grupo_pessoa_to_string;
        }

        $this->vdata['pessoa_grupo_grupo_pessoa_to_string'] = $this->pessoa_grupo_grupo_pessoa_to_string;
    }

    public function get_pessoa_grupo_grupo_pessoa_to_string()
    {
        if(!empty($this->pessoa_grupo_grupo_pessoa_to_string))
        {
            return $this->pessoa_grupo_grupo_pessoa_to_string;
        }
    
        $values = PessoaGrupo::where('pessoa_id', '=', $this->id)->getIndexedArray('grupo_pessoa_id','{grupo_pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_produto_tipo_produto_to_string($produto_tipo_produto_to_string)
    {
        if(is_array($produto_tipo_produto_to_string))
        {
            $values = TipoProduto::where('id', 'in', $produto_tipo_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_tipo_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_tipo_produto_to_string = $produto_tipo_produto_to_string;
        }

        $this->vdata['produto_tipo_produto_to_string'] = $this->produto_tipo_produto_to_string;
    }

    public function get_produto_tipo_produto_to_string()
    {
        if(!empty($this->produto_tipo_produto_to_string))
        {
            return $this->produto_tipo_produto_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('tipo_produto_id','{tipo_produto->nome}');
        return implode(', ', $values);
    }

    public function set_produto_familia_produto_to_string($produto_familia_produto_to_string)
    {
        if(is_array($produto_familia_produto_to_string))
        {
            $values = FamiliaProduto::where('id', 'in', $produto_familia_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_familia_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_familia_produto_to_string = $produto_familia_produto_to_string;
        }

        $this->vdata['produto_familia_produto_to_string'] = $this->produto_familia_produto_to_string;
    }

    public function get_produto_familia_produto_to_string()
    {
        if(!empty($this->produto_familia_produto_to_string))
        {
            return $this->produto_familia_produto_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('familia_produto_id','{familia_produto->nome}');
        return implode(', ', $values);
    }

    public function set_produto_fornecedor_to_string($produto_fornecedor_to_string)
    {
        if(is_array($produto_fornecedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $produto_fornecedor_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_fornecedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_fornecedor_to_string = $produto_fornecedor_to_string;
        }

        $this->vdata['produto_fornecedor_to_string'] = $this->produto_fornecedor_to_string;
    }

    public function get_produto_fornecedor_to_string()
    {
        if(!empty($this->produto_fornecedor_to_string))
        {
            return $this->produto_fornecedor_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('fornecedor_id','{fornecedor->nome}');
        return implode(', ', $values);
    }

    public function set_produto_unidade_medida_to_string($produto_unidade_medida_to_string)
    {
        if(is_array($produto_unidade_medida_to_string))
        {
            $values = UnidadeMedida::where('id', 'in', $produto_unidade_medida_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_unidade_medida_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_unidade_medida_to_string = $produto_unidade_medida_to_string;
        }

        $this->vdata['produto_unidade_medida_to_string'] = $this->produto_unidade_medida_to_string;
    }

    public function get_produto_unidade_medida_to_string()
    {
        if(!empty($this->produto_unidade_medida_to_string))
        {
            return $this->produto_unidade_medida_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('unidade_medida_id','{unidade_medida->nome}');
        return implode(', ', $values);
    }

    public function set_produto_fabricante_to_string($produto_fabricante_to_string)
    {
        if(is_array($produto_fabricante_to_string))
        {
            $values = Fabricante::where('id', 'in', $produto_fabricante_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_fabricante_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_fabricante_to_string = $produto_fabricante_to_string;
        }

        $this->vdata['produto_fabricante_to_string'] = $this->produto_fabricante_to_string;
    }

    public function get_produto_fabricante_to_string()
    {
        if(!empty($this->produto_fabricante_to_string))
        {
            return $this->produto_fabricante_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('fabricante_id','{fabricante->nome}');
        return implode(', ', $values);
    }

    
}

