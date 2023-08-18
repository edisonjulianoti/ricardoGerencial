<?php

class TipoOuvidoria extends TRecord
{
    const TABLENAME  = 'tipo_ouvidoria';
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
     * Method getOuvidorias
     */
    public function getOuvidorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_ouvidoria_id', '=', $this->id));
        return Ouvidoria::getObjects( $criteria );
    }

    public function set_ouvidoria_tipo_ouvidoria_to_string($ouvidoria_tipo_ouvidoria_to_string)
    {
        if(is_array($ouvidoria_tipo_ouvidoria_to_string))
        {
            $values = TipoOuvidoria::where('id', 'in', $ouvidoria_tipo_ouvidoria_to_string)->getIndexedArray('nome', 'nome');
            $this->ouvidoria_tipo_ouvidoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->ouvidoria_tipo_ouvidoria_to_string = $ouvidoria_tipo_ouvidoria_to_string;
        }

        $this->vdata['ouvidoria_tipo_ouvidoria_to_string'] = $this->ouvidoria_tipo_ouvidoria_to_string;
    }

    public function get_ouvidoria_tipo_ouvidoria_to_string()
    {
        if(!empty($this->ouvidoria_tipo_ouvidoria_to_string))
        {
            return $this->ouvidoria_tipo_ouvidoria_to_string;
        }
    
        $values = Ouvidoria::where('tipo_ouvidoria_id', '=', $this->id)->getIndexedArray('tipo_ouvidoria_id','{tipo_ouvidoria->nome}');
        return implode(', ', $values);
    }

    
}

