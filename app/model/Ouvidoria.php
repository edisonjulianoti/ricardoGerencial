<?php

class Ouvidoria extends TRecord
{
    const TABLENAME  = 'ouvidoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_ouvidoria;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_ouvidoria_id');
        parent::addAttribute('nome');
        parent::addAttribute('telefone');
        parent::addAttribute('email');
        parent::addAttribute('mensagem');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
            
    }

    /**
     * Method set_tipo_ouvidoria
     * Sample of usage: $var->tipo_ouvidoria = $object;
     * @param $object Instance of TipoOuvidoria
     */
    public function set_tipo_ouvidoria(TipoOuvidoria $object)
    {
        $this->tipo_ouvidoria = $object;
        $this->tipo_ouvidoria_id = $object->id;
    }

    /**
     * Method get_tipo_ouvidoria
     * Sample of usage: $var->tipo_ouvidoria->attribute;
     * @returns TipoOuvidoria instance
     */
    public function get_tipo_ouvidoria()
    {
    
        // loads the associated object
        if (empty($this->tipo_ouvidoria))
            $this->tipo_ouvidoria = new TipoOuvidoria($this->tipo_ouvidoria_id);
    
        // returns the associated object
        return $this->tipo_ouvidoria;
    }

    
}

