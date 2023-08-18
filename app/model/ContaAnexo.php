<?php

class ContaAnexo extends TRecord
{
    const TABLENAME  = 'conta_anexo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $conta;
    private $tipo_anexo;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('conta_id');
        parent::addAttribute('tipo_anexo_id');
        parent::addAttribute('descricao');
        parent::addAttribute('arquivo');
            
    }

    /**
     * Method set_conta
     * Sample of usage: $var->conta = $object;
     * @param $object Instance of Conta
     */
    public function set_conta(Conta $object)
    {
        $this->conta = $object;
        $this->conta_id = $object->id;
    }

    /**
     * Method get_conta
     * Sample of usage: $var->conta->attribute;
     * @returns Conta instance
     */
    public function get_conta()
    {
    
        // loads the associated object
        if (empty($this->conta))
            $this->conta = new Conta($this->conta_id);
    
        // returns the associated object
        return $this->conta;
    }
    /**
     * Method set_tipo_anexo
     * Sample of usage: $var->tipo_anexo = $object;
     * @param $object Instance of TipoAnexo
     */
    public function set_tipo_anexo(TipoAnexo $object)
    {
        $this->tipo_anexo = $object;
        $this->tipo_anexo_id = $object->id;
    }

    /**
     * Method get_tipo_anexo
     * Sample of usage: $var->tipo_anexo->attribute;
     * @returns TipoAnexo instance
     */
    public function get_tipo_anexo()
    {
    
        // loads the associated object
        if (empty($this->tipo_anexo))
            $this->tipo_anexo = new TipoAnexo($this->tipo_anexo_id);
    
        // returns the associated object
        return $this->tipo_anexo;
    }

    
}

