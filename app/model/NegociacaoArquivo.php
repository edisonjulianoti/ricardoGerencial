<?php

class NegociacaoArquivo extends TRecord
{
    const TABLENAME  = 'negociacao_arquivo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $negociacao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('negociacao_id');
        parent::addAttribute('nome_arquivo');
        parent::addAttribute('conteudo_arquivo');
        parent::addAttribute('dt_arquivo');
            
    }

    /**
     * Method set_negociacao
     * Sample of usage: $var->negociacao = $object;
     * @param $object Instance of Negociacao
     */
    public function set_negociacao(Negociacao $object)
    {
        $this->negociacao = $object;
        $this->negociacao_id = $object->id;
    }

    /**
     * Method get_negociacao
     * Sample of usage: $var->negociacao->attribute;
     * @returns Negociacao instance
     */
    public function get_negociacao()
    {
    
        // loads the associated object
        if (empty($this->negociacao))
            $this->negociacao = new Negociacao($this->negociacao_id);
    
        // returns the associated object
        return $this->negociacao;
    }

    
}

