<?php

class Negociacao extends TRecord
{
    const TABLENAME  = 'negociacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $cliente;
    private $vendedor;
    private $origem_contato;
    private $etapa_negociacao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('vendedor_id');
        parent::addAttribute('origem_contato_id');
        parent::addAttribute('etapa_negociacao_id');
        parent::addAttribute('data_inicio');
        parent::addAttribute('data_fechamento');
        parent::addAttribute('data_fechamento_esperada');
        parent::addAttribute('valor_total');
        parent::addAttribute('ordem');
        parent::addAttribute('mes');
        parent::addAttribute('ano');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
        parent::addAttribute('email_novo_pedido_enviado');
            
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
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_vendedor(Pessoa $object)
    {
        $this->vendedor = $object;
        $this->vendedor_id = $object->id;
    }

    /**
     * Method get_vendedor
     * Sample of usage: $var->vendedor->attribute;
     * @returns Pessoa instance
     */
    public function get_vendedor()
    {
    
        // loads the associated object
        if (empty($this->vendedor))
            $this->vendedor = new Pessoa($this->vendedor_id);
    
        // returns the associated object
        return $this->vendedor;
    }
    /**
     * Method set_origem_contato
     * Sample of usage: $var->origem_contato = $object;
     * @param $object Instance of OrigemContato
     */
    public function set_origem_contato(OrigemContato $object)
    {
        $this->origem_contato = $object;
        $this->origem_contato_id = $object->id;
    }

    /**
     * Method get_origem_contato
     * Sample of usage: $var->origem_contato->attribute;
     * @returns OrigemContato instance
     */
    public function get_origem_contato()
    {
    
        // loads the associated object
        if (empty($this->origem_contato))
            $this->origem_contato = new OrigemContato($this->origem_contato_id);
    
        // returns the associated object
        return $this->origem_contato;
    }
    /**
     * Method set_etapa_negociacao
     * Sample of usage: $var->etapa_negociacao = $object;
     * @param $object Instance of EtapaNegociacao
     */
    public function set_etapa_negociacao(EtapaNegociacao $object)
    {
        $this->etapa_negociacao = $object;
        $this->etapa_negociacao_id = $object->id;
    }

    /**
     * Method get_etapa_negociacao
     * Sample of usage: $var->etapa_negociacao->attribute;
     * @returns EtapaNegociacao instance
     */
    public function get_etapa_negociacao()
    {
    
        // loads the associated object
        if (empty($this->etapa_negociacao))
            $this->etapa_negociacao = new EtapaNegociacao($this->etapa_negociacao_id);
    
        // returns the associated object
        return $this->etapa_negociacao;
    }

    /**
     * Method getNegociacaoArquivos
     */
    public function getNegociacaoArquivos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return NegociacaoArquivo::getObjects( $criteria );
    }
    /**
     * Method getNegociacaoAtividades
     */
    public function getNegociacaoAtividades()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return NegociacaoAtividade::getObjects( $criteria );
    }
    /**
     * Method getNegociacaoHistoricoEtapas
     */
    public function getNegociacaoHistoricoEtapas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return NegociacaoHistoricoEtapa::getObjects( $criteria );
    }
    /**
     * Method getNegociacaoItems
     */
    public function getNegociacaoItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return NegociacaoItem::getObjects( $criteria );
    }
    /**
     * Method getNegociacaoObservacaos
     */
    public function getNegociacaoObservacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return NegociacaoObservacao::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendas
     */
    public function getPedidoVendas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('negociacao_id', '=', $this->id));
        return PedidoVenda::getObjects( $criteria );
    }

    public function set_negociacao_arquivo_negociacao_to_string($negociacao_arquivo_negociacao_to_string)
    {
        if(is_array($negociacao_arquivo_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_arquivo_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->negociacao_arquivo_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_arquivo_negociacao_to_string = $negociacao_arquivo_negociacao_to_string;
        }

        $this->vdata['negociacao_arquivo_negociacao_to_string'] = $this->negociacao_arquivo_negociacao_to_string;
    }

    public function get_negociacao_arquivo_negociacao_to_string()
    {
        if(!empty($this->negociacao_arquivo_negociacao_to_string))
        {
            return $this->negociacao_arquivo_negociacao_to_string;
        }
    
        $values = NegociacaoArquivo::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_negociacao_atividade_tipo_atividade_to_string($negociacao_atividade_tipo_atividade_to_string)
    {
        if(is_array($negociacao_atividade_tipo_atividade_to_string))
        {
            $values = TipoAtividade::where('id', 'in', $negociacao_atividade_tipo_atividade_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_atividade_tipo_atividade_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_atividade_tipo_atividade_to_string = $negociacao_atividade_tipo_atividade_to_string;
        }

        $this->vdata['negociacao_atividade_tipo_atividade_to_string'] = $this->negociacao_atividade_tipo_atividade_to_string;
    }

    public function get_negociacao_atividade_tipo_atividade_to_string()
    {
        if(!empty($this->negociacao_atividade_tipo_atividade_to_string))
        {
            return $this->negociacao_atividade_tipo_atividade_to_string;
        }
    
        $values = NegociacaoAtividade::where('negociacao_id', '=', $this->id)->getIndexedArray('tipo_atividade_id','{tipo_atividade->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_atividade_negociacao_to_string($negociacao_atividade_negociacao_to_string)
    {
        if(is_array($negociacao_atividade_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_atividade_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->negociacao_atividade_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_atividade_negociacao_to_string = $negociacao_atividade_negociacao_to_string;
        }

        $this->vdata['negociacao_atividade_negociacao_to_string'] = $this->negociacao_atividade_negociacao_to_string;
    }

    public function get_negociacao_atividade_negociacao_to_string()
    {
        if(!empty($this->negociacao_atividade_negociacao_to_string))
        {
            return $this->negociacao_atividade_negociacao_to_string;
        }
    
        $values = NegociacaoAtividade::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_negociacao_historico_etapa_negociacao_to_string($negociacao_historico_etapa_negociacao_to_string)
    {
        if(is_array($negociacao_historico_etapa_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_historico_etapa_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->negociacao_historico_etapa_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_historico_etapa_negociacao_to_string = $negociacao_historico_etapa_negociacao_to_string;
        }

        $this->vdata['negociacao_historico_etapa_negociacao_to_string'] = $this->negociacao_historico_etapa_negociacao_to_string;
    }

    public function get_negociacao_historico_etapa_negociacao_to_string()
    {
        if(!empty($this->negociacao_historico_etapa_negociacao_to_string))
        {
            return $this->negociacao_historico_etapa_negociacao_to_string;
        }
    
        $values = NegociacaoHistoricoEtapa::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_negociacao_historico_etapa_etapa_negociacao_to_string($negociacao_historico_etapa_etapa_negociacao_to_string)
    {
        if(is_array($negociacao_historico_etapa_etapa_negociacao_to_string))
        {
            $values = EtapaNegociacao::where('id', 'in', $negociacao_historico_etapa_etapa_negociacao_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_historico_etapa_etapa_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_historico_etapa_etapa_negociacao_to_string = $negociacao_historico_etapa_etapa_negociacao_to_string;
        }

        $this->vdata['negociacao_historico_etapa_etapa_negociacao_to_string'] = $this->negociacao_historico_etapa_etapa_negociacao_to_string;
    }

    public function get_negociacao_historico_etapa_etapa_negociacao_to_string()
    {
        if(!empty($this->negociacao_historico_etapa_etapa_negociacao_to_string))
        {
            return $this->negociacao_historico_etapa_etapa_negociacao_to_string;
        }
    
        $values = NegociacaoHistoricoEtapa::where('negociacao_id', '=', $this->id)->getIndexedArray('etapa_negociacao_id','{etapa_negociacao->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_item_produto_to_string($negociacao_item_produto_to_string)
    {
        if(is_array($negociacao_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $negociacao_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_item_produto_to_string = $negociacao_item_produto_to_string;
        }

        $this->vdata['negociacao_item_produto_to_string'] = $this->negociacao_item_produto_to_string;
    }

    public function get_negociacao_item_produto_to_string()
    {
        if(!empty($this->negociacao_item_produto_to_string))
        {
            return $this->negociacao_item_produto_to_string;
        }
    
        $values = NegociacaoItem::where('negociacao_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_item_negociacao_to_string($negociacao_item_negociacao_to_string)
    {
        if(is_array($negociacao_item_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_item_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->negociacao_item_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_item_negociacao_to_string = $negociacao_item_negociacao_to_string;
        }

        $this->vdata['negociacao_item_negociacao_to_string'] = $this->negociacao_item_negociacao_to_string;
    }

    public function get_negociacao_item_negociacao_to_string()
    {
        if(!empty($this->negociacao_item_negociacao_to_string))
        {
            return $this->negociacao_item_negociacao_to_string;
        }
    
        $values = NegociacaoItem::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function set_negociacao_observacao_negociacao_to_string($negociacao_observacao_negociacao_to_string)
    {
        if(is_array($negociacao_observacao_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_observacao_negociacao_to_string)->getIndexedArray('id', 'id');
            $this->negociacao_observacao_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_observacao_negociacao_to_string = $negociacao_observacao_negociacao_to_string;
        }

        $this->vdata['negociacao_observacao_negociacao_to_string'] = $this->negociacao_observacao_negociacao_to_string;
    }

    public function get_negociacao_observacao_negociacao_to_string()
    {
        if(!empty($this->negociacao_observacao_negociacao_to_string))
        {
            return $this->negociacao_observacao_negociacao_to_string;
        }
    
        $values = NegociacaoObservacao::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('tipo_pedido_id','{tipo_pedido->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('estado_pedido_venda_id','{estado_pedido_venda->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('condicao_pagamento_id','{condicao_pagamento->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('transportadora_id','{transportadora->nome}');
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
    
        $values = PedidoVenda::where('negociacao_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    
}

