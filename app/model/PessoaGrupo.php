<?php

class PessoaGrupo extends TRecord
{
    const TABLENAME  = 'pessoa_grupo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $pessoa;
    private $grupo_pessoa;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pessoa_id');
        parent::addAttribute('grupo_pessoa_id');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_pessoa(Pessoa $object)
    {
        $this->pessoa = $object;
        $this->pessoa_id = $object->id;
    }

    /**
     * Method get_pessoa
     * Sample of usage: $var->pessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_pessoa()
    {
    
        // loads the associated object
        if (empty($this->pessoa))
            $this->pessoa = new Pessoa($this->pessoa_id);
    
        // returns the associated object
        return $this->pessoa;
    }
    /**
     * Method set_grupo_pessoa
     * Sample of usage: $var->grupo_pessoa = $object;
     * @param $object Instance of GrupoPessoa
     */
    public function set_grupo_pessoa(GrupoPessoa $object)
    {
        $this->grupo_pessoa = $object;
        $this->grupo_pessoa_id = $object->id;
    }

    /**
     * Method get_grupo_pessoa
     * Sample of usage: $var->grupo_pessoa->attribute;
     * @returns GrupoPessoa instance
     */
    public function get_grupo_pessoa()
    {
    
        // loads the associated object
        if (empty($this->grupo_pessoa))
            $this->grupo_pessoa = new GrupoPessoa($this->grupo_pessoa_id);
    
        // returns the associated object
        return $this->grupo_pessoa;
    }

    
}

