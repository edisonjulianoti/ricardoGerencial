<?php

class NegociacaoFormView extends TPage
{
    protected $form; // form
    private static $database = 'minierp';
    private static $activeRecord = 'Negociacao';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Negociacao';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $negociacao = new Negociacao($param['key']);
        // define the form title
        $this->form->setFormTitle("Negociação #{$param['key']}");

        $transformed_negociacao_etapa_negociacao_nome = call_user_func(function($value, $object, $row)
        {

            if(!empty($object->etapa_negociacao_id))
            {
                return "<span class='label ' style='background-color:{$object->etapa_negociacao->cor}'>{$object->etapa_negociacao->nome}</span>";
            }

        }, $negociacao->etapa_negociacao->nome, $negociacao, null);

        $criteria_etapa_negociacao_id = new TCriteria();

        $filterVar = "T";
        $criteria_etapa_negociacao_id->add(new TFilter('kanban', '=', $filterVar)); 

        TSession::setValue('negociacao_id', $negociacao->id);

        $etapa_negociacao_id = new TDBArrowStep('etapa_negociacao_id', 'minierp', 'EtapaNegociacao', 'id', '{nome}','ordem asc' , $criteria_etapa_negociacao_id);
        $label2 = new TLabel("Cliente:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($negociacao->cliente->nome, '', '16px', '');
        $label4 = new TLabel("Vendedor:", '', '14px', 'B', '100%');
        $text3 = new TTextDisplay($negociacao->vendedor->nome, '', '16px', '');
        $label6 = new TLabel("Etapa:", '', '14px', 'B', '100%');
        $text5 = new TTextDisplay($transformed_negociacao_etapa_negociacao_nome, '', '16px', '');
        $label8 = new TLabel("Origem do contato:", '', '14px', 'B', '100%');
        $text4 = new TTextDisplay($negociacao->origem_contato->nome, '', '16px', '');
        $label10 = new TLabel("Valor total:", '', '14px', 'B', '100%');
        $text9 = new TTextDisplay(number_format($negociacao->valor_total, '2', ',', '.'), '', '16px', '');
        $label12 = new TLabel("Data de início:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay(TDate::convertToMask($negociacao->data_inicio, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label14 = new TLabel("Data esperada de fechamento:", '', '14px', 'B', '100%');
        $text8 = new TTextDisplay(TDate::convertToMask($negociacao->data_fechamento_esperada, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label16 = new TLabel("Data de fechamento:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay(TDate::convertToMask($negociacao->data_fechamento, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $timeline = new BPageContainer();
        $atividades = new BPageContainer();
        $arquivos = new BPageContainer();
        $observacoes = new BPageContainer();
        $bpagecontainer2 = new BPageContainer();

        $etapa_negociacao_id->setAction(new TAction([$this,'onChangeEtapa']));

        $etapa_negociacao_id->setColorColumn('cor');
        $etapa_negociacao_id->setFilledColor('#fd9308');
        $etapa_negociacao_id->setFilledFontColor('#ffffff');
        $etapa_negociacao_id->setUnfilledColor('#d3d3d3');
        $etapa_negociacao_id->setUnfilledFontColor('#333333');
        $etapa_negociacao_id->setWidth('100%');
        $etapa_negociacao_id->setHeight('60');
        $etapa_negociacao_id->setValue($negociacao->etapa_negociacao_id);
        $timeline->setSize('100%');
        $arquivos->setSize('100%');
        $atividades->setSize('100%');
        $observacoes->setSize('100%');
        $bpagecontainer2->setSize('100%');

        $timeline->setAction(new TAction(['NegociacaoTimeline', 'onShow'], ['negociacao_id' => $negociacao->id]));
        $arquivos->setAction(new TAction(['NegociacaoArquivoHeaderList', 'onShow'], ['negociacao_id' => $negociacao->id]));
        $bpagecontainer2->setAction(new TAction(['NegociacaoItemHeaderList', 'onShow'], ['negociacao_id' => $negociacao->id]));
        $observacoes->setAction(new TAction(['NegociacaoObservacaoHeaderList', 'onShow'], ['negociacao_id' => $negociacao->id]));
        $atividades->setAction(new TAction(['NegociacaoAtividadeCalendarFormView', 'onReload'], ['negociacao_id' => $negociacao->id]));

        $arquivos->setId('b633f68ef00a2c');
        $atividades->setId('b6347050b91e4a');
        $observacoes->setId('b633f66f653e7b');
        $timeline->setId('container_timeline');
        $bpagecontainer2->setId('b63210ffc61e57');


        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $timeline->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $atividades->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $arquivos->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $observacoes->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $bpagecontainer2->add($loadingContainer);

        $row1 = $this->form->addFields([$etapa_negociacao_id]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$label2,$text2],[$label4,$text3],[$label6,$text5],[$label8,$text4]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([$label10,$text9],[$label12,$text6],[$label14,$text8],[$label16,$text7]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $tab_63210fe87cb58 = new BootstrapFormBuilder('tab_63210fe87cb58');
        $this->tab_63210fe87cb58 = $tab_63210fe87cb58;
        $tab_63210fe87cb58->setProperty('style', 'border:none; box-shadow:none;');

        $tab_63210fe87cb58->appendPage("Atividades");

        $tab_63210fe87cb58->addFields([new THidden('current_tab_tab_63210fe87cb58')]);
        $tab_63210fe87cb58->setTabFunction("$('[name=current_tab_tab_63210fe87cb58]').val($(this).attr('data-current_page'));");

        $row4 = $tab_63210fe87cb58->addFields([$atividades]);
        $row4->layout = [' col-sm-12'];

        $tab_63210fe87cb58->appendPage("Arquivos");
        $row5 = $tab_63210fe87cb58->addFields([$arquivos]);
        $row5->layout = [' col-sm-12'];

        $tab_63210fe87cb58->appendPage("Observações");
        $row6 = $tab_63210fe87cb58->addFields([$observacoes]);
        $row6->layout = [' col-sm-12'];

        $tab_63210fe87cb58->appendPage("Produtos");
        $row7 = $tab_63210fe87cb58->addFields([$bpagecontainer2]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([$timeline],[$tab_63210fe87cb58]);
        $row8->layout = [' col-sm-4',' col-sm-8'];

        if(!empty($param['current_tab']))
        {
            $this->form->setCurrentPage($param['current_tab']);
        }

        if(!empty($param['current_tab_tab_63210fe87cb58']))
        {
            $this->tab_63210fe87cb58->setCurrentPage($param['current_tab_tab_63210fe87cb58']);
        }

        $btnNegociacaoEmailFormOnShowAction = new TAction(['NegociacaoEmailForm', 'onShow'],['negociacao_id'=>$negociacao->id]);
        $btnNegociacaoEmailFormOnShowLabel = new TLabel("Enviar email");

        $btnNegociacaoEmailFormOnShow = $this->form->addHeaderAction($btnNegociacaoEmailFormOnShowLabel, $btnNegociacaoEmailFormOnShowAction, 'far:envelope #F44336'); 
        $btnNegociacaoEmailFormOnShowLabel->setFontSize('12px'); 
        $btnNegociacaoEmailFormOnShowLabel->setFontColor('#333'); 

        $btnVisualizarPedidoAction = new TAction([$this, 'onVisualizarPedido'],['key'=>$negociacao->id]);
        $btnVisualizarPedidoLabel = new TLabel("Visualizar pedido");

        $btnVisualizarPedido = $this->form->addHeaderAction($btnVisualizarPedidoLabel, $btnVisualizarPedidoAction, 'fas:search-plus #00BCD4'); 
        $btnVisualizarPedidoLabel->setFontSize('12px'); 
        $btnVisualizarPedidoLabel->setFontColor('#333'); 

        $btnGerarPedidoAction = new TAction(['NegociacaoPedidoVendaForm', 'onShow'],['negociacao_id'=>$negociacao->id]);
        $btnGerarPedidoLabel = new TLabel("Gerar pedido");

        $btnGerarPedido = $this->form->addHeaderAction($btnGerarPedidoLabel, $btnGerarPedidoAction, 'fas:cogs #4CAF50'); 
        $btnGerarPedidoLabel->setFontSize('12px'); 
        $btnGerarPedidoLabel->setFontColor('#333'); 

        $btnEditarAction = new TAction(['NegociacaoForm', 'onEdit'],['key'=>$negociacao->id]);
        $btnEditarLabel = new TLabel("Editar");

        $btnEditar = $this->form->addHeaderAction($btnEditarLabel, $btnEditarAction, 'fas:edit #2196F3'); 
        $btnEditarLabel->setFontSize('14px'); 
        $btnEditarLabel->setFontColor('#333'); 

        $btnExcluirAction = new TAction([$this, 'onDelete'],['key'=>$negociacao->id]);
        $btnExcluirLabel = new TLabel("Excluír");

        $btnExcluir = $this->form->addHeaderAction($btnExcluirLabel, $btnExcluirAction, 'fas:trash-alt #F44336'); 
        $btnExcluirLabel->setFontSize('14px'); 
        $btnExcluirLabel->setFontColor('#333'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["CRM","Consulta de negociação"]));
        }
        $container->add($this->form);

        if(!NegociacaoService::podeEditar($negociacao->id))
        {
            $btnEditar->disabled = 1; // desabilita o botão
            //$btnEditar->style = 'display:none';
        }

        if(!NegociacaoService::podeExcluir($negociacao->id))
        {
            //$btnExcluir->disabled = 1; // desabilita o botão
            $btnExcluir->style = 'display:none';
        }

        if($negociacao->etapa_negociacao_id != EtapaNegociacao::FINALIZADA)
        {
            $btnGerarPedido->style = 'display:none';
            $btnVisualizarPedido->style = 'display:none';
        }
        else
        {
            $btnVisualizarPedido->style = 'display:none';
            $pedidoVenda = PedidoVenda::where('negociacao_id', '=', $negociacao->id)
                                      ->first();
            if($pedidoVenda)
            {
                $btnGerarPedido->style = 'display:none';
                $btnVisualizarPedido->style = 'display:block';
            }
        }

        $btnVisualizarPedido->id = 'btnVisualizarPedido';
        $btnGerarPedido->id = 'btnGerarPedido';

        TTransaction::close();
        parent::add($container);

    }

    public static function onChangeEtapa($param = null) 
    {
        try 
        {
            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $negociacao = new Negociacao(TSession::getValue('negociacao_id'));
                $negociacao->etapa_negociacao_id = $param['key'];
                $negociacao->store();

                $negociacaoHistoricoEtapa = new NegociacaoHistoricoEtapa();
                $negociacaoHistoricoEtapa->etapa_negociacao_id = $negociacao->etapa_negociacao_id;
                $negociacaoHistoricoEtapa->negociacao_id = $negociacao->id;
                $negociacaoHistoricoEtapa->dt_etapa = date('Y-m-d H:i:s');
                $negociacaoHistoricoEtapa->store();

                TTransaction::close();

                new TMessage('info', 'Etapa alterada com sucesso!', new TAction(['NegociacaoFormView', 'onShow'], ['key'=>$negociacao->id]));
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onVisualizarPedido($param = null) 
    {
        try 
        {

            TTransaction::open(self::$database);

            $pedidoVenda = PedidoVenda::where('negociacao_id', '=', $param['key'])
                                      ->first();
            TTransaction::close();

            if(!$pedidoVenda)
            {
                throw new Exception('Pedido não encontrado para a negociação');
            }

            $pageParam = ['key'=>$pedidoVenda->id];

            TApplication::loadPage('PedidoVendaFormView', 'onShow', $pageParam);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDelete($param = null) 
    {
        try 
        {

            if(isset($param['delete']) && $param['delete'] == 1)
            {
                try
                {
                    // get the paramseter $key
                    $key = TSession::getValue('negociacao_id');
                    // open a transaction with database
                    TTransaction::open(self::$database);

                    // instantiates object
                    $object = new Negociacao($key, FALSE); 

                    if(!NegociacaoService::podeExcluir($object->id))
                    {
                        throw new Exception('Não é possível excluir');
                    }

                    // deletes the object from the database
                    $object->delete();

                    // close the transaction
                    TTransaction::close();

                    new TMessage('info', 'Negociação deletada', new TAction(['NegociacaoList', 'onShow']));
                }
                catch (Exception $e) // in case of exception
                {
                    // shows the exception error message
                    new TMessage('error', $e->getMessage());
                    // undo all pending operations
                    TTransaction::rollback();
                }
            }
            else
            {
                // define the delete action
                $action = new TAction(array('NegociacaoFormView', 'onDelete'));
                $action->setParameters($param); // pass the key paramseter ahead
                $action->setParameter('delete', 1);
                // shows a dialog to the user
                new TQuestion('Você tem certeza que quer deletar?', $action);   
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {     

    }

}

