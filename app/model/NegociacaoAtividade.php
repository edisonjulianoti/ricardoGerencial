<?php

class NegociacaoAtividade extends TRecord
{
    const TABLENAME  = 'negociacao_atividade';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'dt_atividade';

    private $negociacao;
    private $tipo_atividade;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_atividade_id');
        parent::addAttribute('negociacao_id');
        parent::addAttribute('descricao');
        parent::addAttribute('horario_inicial');
        parent::addAttribute('horario_final');
        parent::addAttribute('observacao');
        parent::addAttribute('dt_atividade');
            
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
     * Method set_tipo_atividade
     * Sample of usage: $var->tipo_atividade = $object;
     * @param $object Instance of TipoAtividade
     */
    public function set_tipo_atividade(TipoAtividade $object)
    {
        $this->tipo_atividade = $object;
        $this->tipo_atividade_id = $object->id;
    }

    /**
     * Method get_tipo_atividade
     * Sample of usage: $var->tipo_atividade->attribute;
     * @returns TipoAtividade instance
     */
    public function get_tipo_atividade()
    {
    
        // loads the associated object
        if (empty($this->tipo_atividade))
            $this->tipo_atividade = new TipoAtividade($this->tipo_atividade_id);
    
        // returns the associated object
        return $this->tipo_atividade;
    }

    
}

