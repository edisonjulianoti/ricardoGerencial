<?php

class CepCache extends TRecord
{
    const TABLENAME  = 'cep_cache';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cep');
        parent::addAttribute('rua');
        parent::addAttribute('cidade');
        parent::addAttribute('bairro');
        parent::addAttribute('codigo_ibge');
        parent::addAttribute('uf');
        parent::addAttribute('cidade_id');
        parent::addAttribute('estado_id');
        parent::addAttribute('created_at');
            
    }

    
}

