<?php

class GrupoPessoa extends TRecord
{
    const TABLENAME  = 'grupo_pessoa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const FUNCIONARIO = '1';
    const VENDEDOR = '2';
    const CLIENTE = '3';
    const FORNECEDOR = '4';
    const TRANSPORTADORA = '7';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
    
    }

    /**
     * Method getPessoaGrupos
     */
    public function getPessoaGrupos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('grupo_pessoa_id', '=', $this->id));
        return PessoaGrupo::getObjects( $criteria );
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
    
        $values = PessoaGrupo::where('grupo_pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
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
    
        $values = PessoaGrupo::where('grupo_pessoa_id', '=', $this->id)->getIndexedArray('grupo_pessoa_id','{grupo_pessoa->nome}');
        return implode(', ', $values);
    }

}

