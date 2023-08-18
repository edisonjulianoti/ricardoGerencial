<?php

class NegociacaoHistoricoEtapa extends TRecord
{
    const TABLENAME  = 'negociacao_historico_etapa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $negociacao;
    private $etapa_negociacao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('negociacao_id');
        parent::addAttribute('etapa_negociacao_id');
        parent::addAttribute('dt_etapa');
            
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
    /**
     * Method set_etapa_negociacao
     * Sample of usage: $var->etapa_negociacao = $object;
     * @param $object Instance of EtapaNegociacao
     */
    public function set_etapa_negociacao(EtapaNegociacao $object)
    {
        $this->etapa_negociacao = $object;
        $this->etapa_negociacao_id = $object->id;
    }

    /**
     * Method get_etapa_negociacao
     * Sample of usage: $var->etapa_negociacao->attribute;
     * @returns EtapaNegociacao instance
     */
    public function get_etapa_negociacao()
    {
    
        // loads the associated object
        if (empty($this->etapa_negociacao))
            $this->etapa_negociacao = new EtapaNegociacao($this->etapa_negociacao_id);
    
        // returns the associated object
        return $this->etapa_negociacao;
    }

    
}

