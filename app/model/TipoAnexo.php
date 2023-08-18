<?php

class TipoAnexo extends TRecord
{
    const TABLENAME  = 'tipo_anexo';
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
     * Method getContaAnexos
     */
    public function getContaAnexos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_anexo_id', '=', $this->id));
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
    
        $values = ContaAnexo::where('tipo_anexo_id', '=', $this->id)->getIndexedArray('conta_id','{conta->id}');
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
    
        $values = ContaAnexo::where('tipo_anexo_id', '=', $this->id)->getIndexedArray('tipo_anexo_id','{tipo_anexo->nome}');
        return implode(', ', $values);
    }

    
}

