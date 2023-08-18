<?php

class Produto extends TRecord
{
    const TABLENAME  = 'produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_produto;
    private $familia_produto;
    private $fabricante;
    private $unidade_medida;
    private $fornecedor;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_produto_id');
        parent::addAttribute('familia_produto_id');
        parent::addAttribute('fornecedor_id');
        parent::addAttribute('unidade_medida_id');
        parent::addAttribute('fabricante_id');
        parent::addAttribute('nome');
        parent::addAttribute('cod_barras');
        parent::addAttribute('preco_venda');
        parent::addAttribute('preco_custo');
        parent::addAttribute('peso_liquido');
        parent::addAttribute('peso_bruto');
        parent::addAttribute('largura');
        parent::addAttribute('altura');
        parent::addAttribute('volume');
        parent::addAttribute('estoque_minimo');
        parent::addAttribute('qtde_estoque');
        parent::addAttribute('estoque_maximo');
        parent::addAttribute('obs');
        parent::addAttribute('ativo');
        parent::addAttribute('foto');
        parent::addAttribute('data_ultimo_reajuste_preco');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
            
    }

    /**
     * Method set_tipo_produto
     * Sample of usage: $var->tipo_produto = $object;
     * @param $object Instance of TipoProduto
     */
    public function set_tipo_produto(TipoProduto $object)
    {
        $this->tipo_produto = $object;
        $this->tipo_produto_id = $object->id;
    }

    /**
     * Method get_tipo_produto
     * Sample of usage: $var->tipo_produto->attribute;
     * @returns TipoProduto instance
     */
    public function get_tipo_produto()
    {
    
        // loads the associated object
        if (empty($this->tipo_produto))
            $this->tipo_produto = new TipoProduto($this->tipo_produto_id);
    
        // returns the associated object
        return $this->tipo_produto;
    }
    /**
     * Method set_familia_produto
     * Sample of usage: $var->familia_produto = $object;
     * @param $object Instance of FamiliaProduto
     */
    public function set_familia_produto(FamiliaProduto $object)
    {
        $this->familia_produto = $object;
        $this->familia_produto_id = $object->id;
    }

    /**
     * Method get_familia_produto
     * Sample of usage: $var->familia_produto->attribute;
     * @returns FamiliaProduto instance
     */
    public function get_familia_produto()
    {
    
        // loads the associated object
        if (empty($this->familia_produto))
            $this->familia_produto = new FamiliaProduto($this->familia_produto_id);
    
        // returns the associated object
        return $this->familia_produto;
    }
    /**
     * Method set_fabricante
     * Sample of usage: $var->fabricante = $object;
     * @param $object Instance of Fabricante
     */
    public function set_fabricante(Fabricante $object)
    {
        $this->fabricante = $object;
        $this->fabricante_id = $object->id;
    }

    /**
     * Method get_fabricante
     * Sample of usage: $var->fabricante->attribute;
     * @returns Fabricante instance
     */
    public function get_fabricante()
    {
    
        // loads the associated object
        if (empty($this->fabricante))
            $this->fabricante = new Fabricante($this->fabricante_id);
    
        // returns the associated object
        return $this->fabricante;
    }
    /**
     * Method set_unidade_medida
     * Sample of usage: $var->unidade_medida = $object;
     * @param $object Instance of UnidadeMedida
     */
    public function set_unidade_medida(UnidadeMedida $object)
    {
        $this->unidade_medida = $object;
        $this->unidade_medida_id = $object->id;
    }

    /**
     * Method get_unidade_medida
     * Sample of usage: $var->unidade_medida->attribute;
     * @returns UnidadeMedida instance
     */
    public function get_unidade_medida()
    {
    
        // loads the associated object
        if (empty($this->unidade_medida))
            $this->unidade_medida = new UnidadeMedida($this->unidade_medida_id);
    
        // returns the associated object
        return $this->unidade_medida;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fornecedor(Pessoa $object)
    {
        $this->fornecedor = $object;
        $this->fornecedor_id = $object->id;
    }

    /**
     * Method get_fornecedor
     * Sample of usage: $var->fornecedor->attribute;
     * @returns Pessoa instance
     */
    public function get_fornecedor()
    {
    
        // loads the associated object
        if (empty($this->fornecedor))
            $this->fornecedor = new Pessoa($this->fornecedor_id);
    
        // returns the associated object
        return $this->fornecedor;
    }

    /**
     * Method getNegociacaoItems
     */
    public function getNegociacaoItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return NegociacaoItem::getObjects( $criteria );
    }
    /**
     * Method getNotaFiscalItems
     */
    public function getNotaFiscalItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return NotaFiscalItem::getObjects( $criteria );
    }
    /**
     * Method getPedidoVendaItems
     */
    public function getPedidoVendaItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return PedidoVendaItem::getObjects( $criteria );
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
    
        $values = NegociacaoItem::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
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
    
        $values = NegociacaoItem::where('produto_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
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
    
        $values = NotaFiscalItem::where('produto_id', '=', $this->id)->getIndexedArray('pedido_venda_item_id','{pedido_venda_item->id}');
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
    
        $values = NotaFiscalItem::where('produto_id', '=', $this->id)->getIndexedArray('nota_fiscal_id','{nota_fiscal->id}');
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
    
        $values = NotaFiscalItem::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_item_pedido_venda_to_string($pedido_venda_item_pedido_venda_to_string)
    {
        if(is_array($pedido_venda_item_pedido_venda_to_string))
        {
            $values = PedidoVenda::where('id', 'in', $pedido_venda_item_pedido_venda_to_string)->getIndexedArray('id', 'id');
            $this->pedido_venda_item_pedido_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_item_pedido_venda_to_string = $pedido_venda_item_pedido_venda_to_string;
        }

        $this->vdata['pedido_venda_item_pedido_venda_to_string'] = $this->pedido_venda_item_pedido_venda_to_string;
    }

    public function get_pedido_venda_item_pedido_venda_to_string()
    {
        if(!empty($this->pedido_venda_item_pedido_venda_to_string))
        {
            return $this->pedido_venda_item_pedido_venda_to_string;
        }
    
        $values = PedidoVendaItem::where('produto_id', '=', $this->id)->getIndexedArray('pedido_venda_id','{pedido_venda->id}');
        return implode(', ', $values);
    }

    public function set_pedido_venda_item_produto_to_string($pedido_venda_item_produto_to_string)
    {
        if(is_array($pedido_venda_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $pedido_venda_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->pedido_venda_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->pedido_venda_item_produto_to_string = $pedido_venda_item_produto_to_string;
        }

        $this->vdata['pedido_venda_item_produto_to_string'] = $this->pedido_venda_item_produto_to_string;
    }

    public function get_pedido_venda_item_produto_to_string()
    {
        if(!empty($this->pedido_venda_item_produto_to_string))
        {
            return $this->pedido_venda_item_produto_to_string;
        }
    
        $values = PedidoVendaItem::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    
}

