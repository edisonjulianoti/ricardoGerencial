<?php

class TrocarEstadoPedidoVendaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_TrocarEstadoPedidoVendaForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Trocar estado pedido de venda");

        $criteria_estado_pedido_venda_id = new TCriteria();

        $filterVar = "T";
        $criteria_estado_pedido_venda_id->add(new TFilter('kanban', '=', $filterVar)); 

        $pedido_venda_id = new TEntry('pedido_venda_id');
        $estado_pedido_venda_id = new TDBArrowStep('estado_pedido_venda_id', 'minierp', 'EstadoPedidoVenda', 'id', '{nome}','ordem asc' , $criteria_estado_pedido_venda_id );
        $codigo_rastreio = new TEntry('codigo_rastreio');
        $obs = new TText('obs');


        $pedido_venda_id->setValue($param['key']);
        $estado_pedido_venda_id->setColorColumn('cor');
        $estado_pedido_venda_id->setFilledColor('#fd9308');
        $estado_pedido_venda_id->setFilledFontColor('#ffffff');
        $estado_pedido_venda_id->setUnfilledColor('#d3d3d3');
        $estado_pedido_venda_id->setUnfilledFontColor('#333333');
        $pedido_venda_id->setEditable(false);
        $estado_pedido_venda_id->setEditable(false);

        $obs->setSize('100%', 160);
        $pedido_venda_id->setSize('100%');
        $codigo_rastreio->setSize('100%');
        $estado_pedido_venda_id->setSize('100%', 55);

        $row1 = $this->form->addFields([new TLabel("Código Pedido", null, '14px', null, '100%'),$pedido_venda_id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Próximo estado:", null, '14px', null, '100%'),$estado_pedido_venda_id]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Código de rastreio:", null, '14px', null, '100%'),$codigo_rastreio]);
        $row3->layout = [' col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Obsevações:", null, '14px', null, '100%'),$obs]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btnTrocarEstado = $this->form->addAction("Ação", new TAction([$this, 'onTrocarEstado']), 'fas:rocket #ffffff');
        $this->btnTrocarEstado = $btnTrocarEstado;
        $btnTrocarEstado->addStyleClass('btn-primary'); 

        $btnReprovar = $this->form->addAction("Reprovar", new TAction([$this, 'onReprovar']), 'fas:thumbs-down #F2EFEF');
        $this->btnReprovar = $btnReprovar;
        $btnReprovar->addStyleClass('btn-danger'); 

        $btnCancelar = $this->form->addAction("Cancelar", new TAction([$this, 'onCancelarPedido']), 'fas:times #E91E63');
        $this->btnCancelar = $btnCancelar;

        $btnFinalizar = $this->form->addAction("Finalizar", new TAction([$this, 'onFinalizar']), 'fas:flag-checkered #03A9F4');
        $this->btnFinalizar = $btnFinalizar;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=TrocarEstadoPedidoVendaForm]');
        $style->width = '70% !important';   
        $style->show(true);

    }

    public static function onTrocarEstado($param = null) 
    {
        try
        {

            TTransaction::open('minierp');

            $pedidoVenda = new PedidoVenda($param['pedido_venda_id']);

            if(empty($param['proximo_estado_pedido_venda_id']))
            {
                $proximoEstadoPedidoVenda = EstadoPedidoVenda::getProximoEstadoPedidoVenda($pedidoVenda->estado_pedido_venda_id);

                if(!$proximoEstadoPedidoVenda)
                {
                    throw new Exception('Próximo estado não encontrado!');
                }    
            }
            else
            {
                $proximoEstadoPedidoVenda = new EstadoPedidoVenda($param['proximo_estado_pedido_venda_id']);
            }

            $pedidoVenda->estado_pedido_venda_id = $proximoEstadoPedidoVenda->id;

            if(!empty($param['codigo_rastreio']))
            {
                $pedidoVenda->codigo_rastreio = $param['codigo_rastreio'];
            }

            $pedidoVenda->store();

            $pedidoVendaHistorico = new PedidoVendaHistorico();

            $aprovador = Aprovador::where('system_user_id', '=', TSession::getValue('userid'))->first();

            if(!$aprovador)
            {
                throw new Exception('Você não é um aprovador!');
            }

            $pedidoVendaHistorico->aprovador_id = $aprovador->id;
            $pedidoVendaHistorico->pedido_venda_id = $pedidoVenda->id;
            $pedidoVendaHistorico->estado_pedido_venda_id = $pedidoVenda->estado_pedido_venda_id;
            $pedidoVendaHistorico->obs = $param['obs'];
            $pedidoVendaHistorico->data_operacao = date('Y-m-d H:i:s');
            $pedidoVendaHistorico->store();

            TTransaction::close();

            TTransaction::open('minierp');

            PedidoVendaService::notificarAprovador($pedidoVenda);
            PedidoVendaService::notificarVendedorPedido($pedidoVenda);

            TTransaction::close();

            // Código gerado pelo snippet: "Mensagem Toast"
            TToast::show("success", "Registro salvo", "topRight", "fas:check-circle");
            // -----

            $pageParam = []; // ex.: = ['key' => 10]

            TApplication::loadPage('PedidoVendaPendenteList', 'onReload', $pageParam);

            TScript::create('Template.closeRightPanel()');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public static function onReprovar($param = null) 
    {
        try 
        {

            $param['proximo_estado_pedido_venda_id'] = EstadoPedidoVenda::REPROVADO;
            self::onTrocarEstado($param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onCancelarPedido($param = null) 
    {
        try 
        {

            $param['proximo_estado_pedido_venda_id'] = EstadoPedidoVenda::CANCELADO;
            self::onTrocarEstado($param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onFinalizar($param = null) 
    {
        try 
        {

            if(empty($param['codigo_rastreio']))
            {
                throw new Exception('O código de rastreio é obrigatório ');
            }

            $param['proximo_estado_pedido_venda_id'] = EstadoPedidoVenda::FINALIZADO;
            self::onTrocarEstado($param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        $this->btnReprovar->style = 'display:none';
        $this->btnCancelar->style = 'display:none';
        $this->btnFinalizar->style = 'display:none';

        BootstrapFormBuilder::hideField(self::$formName, 'codigo_rastreio');

        TTransaction::open('minierp');

        $pedidoVenda = new PedidoVenda($param['key']);

        $proximoEstadoPedidoVenda = EstadoPedidoVenda::getProximoEstadoPedidoVenda($pedidoVenda->estado_pedido_venda_id);

        $this->form->getField('estado_pedido_venda_id')->setValue($proximoEstadoPedidoVenda->id);

        if($pedidoVenda->estado_pedido_venda_id == EstadoPedidoVenda::ELABORACAO)
        {
            $this->form->setFormTitle("Validar Pedido");
            $this->btnTrocarEstado->setLabel("Validar Pedido");
        }
        elseif($pedidoVenda->estado_pedido_venda_id == EstadoPedidoVenda::ANALISE_COMERCIAL)
        {
            $this->form->setFormTitle("Aprovar análise comercial");
            $this->btnTrocarEstado->setLabel("Aprovar análise comercial");
        }
        elseif($pedidoVenda->estado_pedido_venda_id == EstadoPedidoVenda::ANALISE_FINANCEIRA)
        {
            $this->form->setFormTitle("Aprovar análise financeira");
            $this->btnTrocarEstado->setLabel("Aprovar análise financeira");
        }
        elseif($pedidoVenda->estado_pedido_venda_id == EstadoPedidoVenda::EM_PROCESSAMENTO)
        {
            $this->form->setFormTitle("Finalizar processamento");
            $this->btnTrocarEstado->setLabel("Finalizar processamento");
        }

        TTransaction::close();

    } 

    public  function onShowReprovar($param = null) 
    {
        try 
        {
            $this->btnTrocarEstado->style = 'display:none';
            $this->btnCancelar->style = 'display:none';
            $this->btnFinalizar->style = 'display:none';

            BootstrapFormBuilder::hideField(self::$formName, 'codigo_rastreio');
            BootstrapFormBuilder::hideField(self::$formName, 'estado_pedido_venda_id');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onShowCancelar($param = null) 
    {
        try 
        {
            $this->btnTrocarEstado->style = 'display:none';
            $this->btnReprovar->style = 'display:none';
            $this->btnFinalizar->style = 'display:none';

            BootstrapFormBuilder::hideField(self::$formName, 'codigo_rastreio');
            BootstrapFormBuilder::hideField(self::$formName, 'estado_pedido_venda_id');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onShowFinalizar($param = null) 
    {
        try 
        {
            $this->btnTrocarEstado->style = 'display:none';
            $this->btnReprovar->style = 'display:none';
            $this->btnCancelar->style = 'display:none';

            BootstrapFormBuilder::hideField(self::$formName, 'estado_pedido_venda_id');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

