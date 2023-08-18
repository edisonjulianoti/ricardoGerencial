<?php

class TipoAtividade extends TRecord
{
    const TABLENAME  = 'tipo_atividade';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cor');
        parent::addAttribute('icone');
    
    }

    /**
     * Method getNegociacaoAtividades
     */
    public function getNegociacaoAtividades()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_atividade_id', '=', $this->id));
        return NegociacaoAtividade::getObjects( $criteria );
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
    
        $values = NegociacaoAtividade::where('tipo_atividade_id', '=', $this->id)->getIndexedArray('tipo_atividade_id','{tipo_atividade->nome}');
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
    
        $values = NegociacaoAtividade::where('tipo_atividade_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->id}');
        return implode(', ', $values);
    }

    public function get_icone_formatado()
    {
        if($this->icone)
        {
            return "<i class='{$this->icone}'> </i>";
        }
    }

}

