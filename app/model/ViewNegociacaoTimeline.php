<?php

class ViewNegociacaoTimeline extends TRecord
{
    const TABLENAME  = 'view_negociacao_timeline';
    const PRIMARYKEY = 'chave';
    const IDPOLICY   =  'max'; // {max, serial}

    private $negociacao_historico_etapa;
    private $negociacao_item;
    private $negociacao_atividade;
    private $negociacao_observacao;
    private $negociacao_arquivo;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('negociacao_id');
        parent::addAttribute('dt_historico');
        parent::addAttribute('tipo');
    
    }

    public function get_negociacao_historico_etapa()
    {
        if (! $this->negociacao_historico_etapa)
        {
            $this->negociacao_historico_etapa = NegociacaoHistoricoEtapa::find($this->chave);
        }
    
        return $this->negociacao_historico_etapa;
    }

    public function get_negociacao_item()
    {
        if (! $this->negociacao_item)
        {
            $this->negociacao_item = NegociacaoItem::find($this->chave);
        }
    
        return $this->negociacao_item;
    }

    public function get_negociacao_atividade()
    {
        if (! $this->negociacao_atividade)
        {
            $this->negociacao_atividade = NegociacaoAtividade::find($this->chave);
        }
    
        return $this->negociacao_atividade;
    }

    public function get_negociacao_observacao()
    {
        if (! $this->negociacao_observacao)
        {
            $this->negociacao_observacao = NegociacaoObservacao::find($this->chave);
        }
    
        return $this->negociacao_observacao;
    }

    public function get_negociacao_arquivo()
    {
        if (! $this->negociacao_arquivo)
        {
            $this->negociacao_arquivo = NegociacaoArquivo::find($this->chave);
        }
    
        return $this->negociacao_arquivo;
    }

    public function get_titulo()
    {
        if ($this->tipo == 'observacao')
        {
            return "<i style='margin-right: 5px;' class='far fa-sticky-note'></i>Observação {$this->chave}";
        }
        else if ($this->tipo == 'arquivo')
        {
            return "<i style='margin-right: 5px;' class='fas fa-file'></i>Arquivo {$this->chave}";
        }
        else if ($this->tipo == 'produto')
        {
            return "<i style='margin-right: 5px;' class='fas fa-box'></i>{$this->get_negociacao_item()->produto->nome}";
        }
        else if ($this->tipo == 'etapa')
        {
            return "<span style='margin-right: 5px; width: 30px; height: 15px; display: inline-block; border-radius: 3px; border: 1px solid #555; background: {$this->get_negociacao_historico_etapa()->etapa_negociacao->cor}'></span>{$this->get_negociacao_historico_etapa()->etapa_negociacao->nome}";
        }
        else if ($this->tipo == 'atividade')
        {
            return "<i class='{$this->get_negociacao_atividade()->tipo_atividade->icone}' style='color: {$this->get_negociacao_atividade()->tipo_atividade->cor}; margin-right: 5px; '></i>{$this->get_negociacao_atividade()->tipo_atividade->nome}";
        }
    }

    public function get_descricao()
    {
        $div = "";
    
        if ($this->tipo == 'observacao')
        {
            $nota = $this->get_negociacao_observacao();
        
        
            $div = "<b>Descrição: </b>{$nota->observacao}";
        }
        elseif ($this->tipo == 'arquivo')
        {
            $arquivo = $this->get_negociacao_arquivo();
        
        
            $action = new TAction(['NegociacaoArquivoHeaderList', 'downloadArquivo'], ['key'=>$arquivo->id]);

            $a = new TElement('a');
            $a->class = 'btn btn-link';
            $a->generator = 'adianti';
            $a->href = $action->serialize();
            $a->add($arquivo->nome_arquivo);
        
        
            $div = "{$a}";
        }
        else if ($this->tipo == 'produto')
        {
            $item = $this->get_negociacao_item();
        
            $qtde = number_format($item->quantidade, 2, ',', '.');
            $valor = number_format($item->valor, 2, ',', '.');
            $desconto = number_format($item->desconto, 2, ',', '.');
            $valor_total = number_format($item->valor_total, 2, ',', '.');
        
            $div = "<b>Quantidade: </b>{$qtde}<br/><b>Valor: </b>R$ {$valor}<br/><b>Desconto: </b>R$ {$desconto}<br/><b>Total: </b>R$ {$valor_total}<br/>";
        }
        else if ($this->tipo == 'etapa')
        {
            $div = "Negociação movimentada";
        }
        else if ($this->tipo == 'atividade')
        {
            $atividade = $this->get_negociacao_atividade();
        
            $descricao = $atividade->descricao;
            $observacao = $atividade->observacao;
        
            $ini = date('d/m/Y H:i', strtotime($atividade->horario_inicial));
            $fim = date('d/m/Y H:i', strtotime($atividade->horario_final));
        
            $div = "<b>Descrição: </b>{$descricao}<br/><b>Início: </b>{$ini}<br/><b>Fim: </b>{$fim}<br/>{$observacao}<br/>";
        }

        return $div;
    }

    
}

