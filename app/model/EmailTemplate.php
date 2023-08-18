<?php

class EmailTemplate extends TRecord
{
    const TABLENAME  = 'email_template';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'deleted_at';
    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    const ATUALIZACAO = '1';
    const PEDIDO_AGUARDANDO_APROVACAO = '2';
    const EMAIL_AUTOMATICO_PEDIDO_FROM_NEGOCIACAO = '3';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('mensagem');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
            
    }

    
}

