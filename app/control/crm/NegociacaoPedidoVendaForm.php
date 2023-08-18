<?php

class NegociacaoPedidoVendaForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_NegociacaoPedidoVendaForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();
        parent::setSize(600, null);
        parent::setTitle("Dados complementares pedido de venda");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Dados complementares pedido de venda");

        $criteria_transportadora_id = new TCriteria();

        $filterVar = GrupoPessoa::TRANSPORTADORA;
        $criteria_transportadora_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $negociacao_id = new TEntry('negociacao_id');
        $tipo_pedido_id = new TDBCombo('tipo_pedido_id', 'minierp', 'TipoPedido', 'id', '{nome}','nome asc'  );
        $condicao_pagamento_id = new TDBCombo('condicao_pagamento_id', 'minierp', 'CondicaoPagamento', 'id', '{nome}','nome asc'  );
        $transportadora_id = new TDBCombo('transportadora_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_transportadora_id );


        $negociacao_id->setEditable(false);
        $negociacao_id->setValue($param["negociacao_id"] ?? "");
        $tipo_pedido_id->enableSearch();
        $transportadora_id->enableSearch();
        $condicao_pagamento_id->enableSearch();

        $negociacao_id->setSize('100%');
        $tipo_pedido_id->setSize('100%');
        $transportadora_id->setSize('100%');
        $condicao_pagamento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código da Negociação:", null, '14px', null, '100%'),$negociacao_id],[]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Tipo do pedido:", '#F44336', '14px', null, '100%'),$tipo_pedido_id],[new TLabel("Condição de pagamento", '#F44336', '14px', null, '100%'),$condicao_pagamento_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Transportadora:", '#F44336', '14px', null, '100%'),$transportadora_id],[]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_ongerarpedido = $this->form->addAction("Gerar pedido", new TAction([$this, 'onGerarPedido']), 'fas:cogs #ffffff');
        $this->btn_ongerarpedido = $btn_ongerarpedido;
        $btn_ongerarpedido->addStyleClass('btn-primary'); 

        parent::add($this->form);

    }

    public function onGerarPedido($param = null) 
    {
        try
        {
            $this->form->validate();
            $data = $this->form->getData();

            TTransaction::open('minierp');

            $negociacao = new Negociacao($data->negociacao_id);

            if($negociacao->etapa_negociacao_id != EtapaNegociacao::FINALIZADA)
            {
                throw new Exception('Não é possível gerar o pedido pois a negociação não está finalizada.');
            }

            $pedidoVenda = PedidoVenda::where('negociacao_id', '=', $negociacao->id)
                                      ->first();
            if(!$pedidoVenda)
            {
                $propriedadesNegociacao = new stdClass();
                $propriedadesNegociacao->tipo_pedido_id = $data->tipo_pedido_id;
                $propriedadesNegociacao->transportadora_id = $data->transportadora_id;
                $propriedadesNegociacao->condicao_pagamento_id = $data->condicao_pagamento_id;

                $pedidoVenda = PedidoVenda::createFromNegociacao($negociacao, $propriedadesNegociacao);
            }

            TTransaction::close();

            TWindow::closeWindow();

            new TMessage('info', 'Pedido gerado!', new TAction(['PedidoVendaForm', 'onEdit'], ['key'=>$pedidoVenda->id]));

            TScript::create('
                $("#btnGerarPedido").hide(); 
                $("#btnVisualizarPedido").show(); 
            ');
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

}

