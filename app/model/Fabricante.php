<?php

class Fabricante extends TRecord
{
    const TABLENAME  = 'fabricante';
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
     * Method getProdutos
     */
    public function getProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fabricante_id', '=', $this->id));
        return Produto::getObjects( $criteria );
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
    
        $values = Produto::where('fabricante_id', '=', $this->id)->getIndexedArray('tipo_produto_id','{tipo_produto->nome}');
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
    
        $values = Produto::where('fabricante_id', '=', $this->id)->getIndexedArray('familia_produto_id','{familia_produto->nome}');
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
    
        $values = Produto::where('fabricante_id', '=', $this->id)->getIndexedArray('fornecedor_id','{fornecedor->nome}');
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
    
        $values = Produto::where('fabricante_id', '=', $this->id)->getIndexedArray('unidade_medida_id','{unidade_medida->nome}');
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
    
        $values = Produto::where('fabricante_id', '=', $this->id)->getIndexedArray('fabricante_id','{fabricante->nome}');
        return implode(', ', $values);
    }

    
}

