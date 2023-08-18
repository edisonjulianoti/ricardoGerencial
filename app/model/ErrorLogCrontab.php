<?php

class ErrorLogCrontab extends TRecord
{
    const TABLENAME  = 'error_log_crontab';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('classe');
        parent::addAttribute('metodo');
        parent::addAttribute('mensagem');
        parent::addAttribute('created_at');
            
    }

    
}

