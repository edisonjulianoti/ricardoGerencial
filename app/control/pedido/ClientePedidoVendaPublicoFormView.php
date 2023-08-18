<?php

class ClientePedidoVendaPublicoFormView extends TPage
{
    protected $form; // form
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVenda';
    private static $primaryKey = 'id';
    private static $formName = 'formView_PedidoVenda';

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

        $pedido_venda = new PedidoVenda($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta de Pedio de Venda");

        $criteria_tdbarrowstep1 = new TCriteria();

        $filterVar = "T";
        $criteria_tdbarrowstep1->add(new TFilter('kanban', '=', $filterVar)); 

        if(!TSession::getValue('cliente_logado'))
        {
            new TMessage('info', 'Permissão negada! ', new TAction(['LoginClienteForm', 'onShow']));
            return false;
        }

        if($pedido_venda->cliente_id != TSession::getValue('cliente_id'))
        {
            new TMessage('info', 'Permissão negada!');
            return false;
        }

        $tdbarrowstep1 = new TDBArrowStep('tdbarrowstep1', 'minierp', 'EstadoPedidoVenda', 'id', '{nome}','ordem asc' , $criteria_tdbarrowstep1);
        $label2 = new TLabel("Id:", '', '14px', 'B', '100%');
        $text1 = new TTextDisplay($pedido_venda->id, '', '16px', '');
        $label4 = new TLabel("Criado em:", '', '14px', 'B', '100%');
        $text11 = new TTextDisplay(TDateTime::convertToMask($pedido_venda->created_at, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '16px', '');
        $label6 = new TLabel("Atualizado em:", '', '14px', 'B', '100%');
        $text12 = new TTextDisplay(TDateTime::convertToMask($pedido_venda->updated_at, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '16px', '');
        $label8 = new TLabel("Data do Pedido:", '', '14px', 'B', '100%');
        $text5 = new TTextDisplay(TDate::convertToMask($pedido_venda->dt_pedido, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label10 = new TLabel("Cliente:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($pedido_venda->cliente->nome, '', '16px', '');
        $label12 = new TLabel("Vendedor:", '', '14px', 'B', '100%');
        $text3 = new TTextDisplay($pedido_venda->vendedor->nome, '', '16px', '');
        $label16 = new TLabel("Frete:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay(number_format($pedido_venda->frete, '2', ',', '.'), '', '16px', '');
        $label18 = new TLabel("Valor total:", '', '14px', 'B', '100%');
        $text10 = new TTextDisplay(number_format($pedido_venda->valor_total, '2', ',', '.'), '', '16px', '');
        $label14 = new TLabel("Observações:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay($pedido_venda->obs, '', '16px', '');

        $tdbarrowstep1->setEditable(false);
        $tdbarrowstep1->setColorColumn('cor');
        $tdbarrowstep1->setFilledColor('#fd9308');
        $tdbarrowstep1->setFilledFontColor('#ffffff');
        $tdbarrowstep1->setUnfilledColor('#d3d3d3');
        $tdbarrowstep1->setUnfilledFontColor('#333333');
        $tdbarrowstep1->setWidth('100%');
        $tdbarrowstep1->setHeight('60');
        $tdbarrowstep1->setValue($pedido_venda->estado_pedido_venda_id);



        $row1 = $this->form->addFields([$tdbarrowstep1]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$label2,$text1],[$label4,$text11],[$label6,$text12],[$label8,$text5]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([$label10,$text2],[$label12,$text3],[$label16,$text7],[$label18,$text10]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $this->form->addFields([$label14,$text6]);
        $row4->layout = [' col-sm-12'];

        $this->pedido_venda_item_pedido_venda_id_list = new TQuickGrid;
        $this->pedido_venda_item_pedido_venda_id_list->disableHtmlConversion();
        $this->pedido_venda_item_pedido_venda_id_list->style = 'width:100%';
        $this->pedido_venda_item_pedido_venda_id_list->disableDefaultClick();

        $column_produto_familia_produto_nome = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Família", 'produto->familia_produto->nome', 'left');
        $column_produto_nome = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Produto", 'produto->nome', 'left');
        $column_quantidade = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Quantidade", 'quantidade', 'left');
        $column_valor_transformed = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Valor", 'valor', 'left');
        $column_desconto_transformed = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Desconto", 'desconto', 'left');
        $column_valor_total_transformed = $this->pedido_venda_item_pedido_venda_id_list->addQuickColumn("Valor total", 'valor_total', 'left');

        $column_valor_total_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_valor_total_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $this->pedido_venda_item_pedido_venda_id_list->createModel();

        $criteria_pedido_venda_item_pedido_venda_id = new TCriteria();
        $criteria_pedido_venda_item_pedido_venda_id->add(new TFilter('pedido_venda_id', '=', $pedido_venda->id));

        $criteria_pedido_venda_item_pedido_venda_id->setProperty('order', 'id desc');

        $pedido_venda_item_pedido_venda_id_items = PedidoVendaItem::getObjects($criteria_pedido_venda_item_pedido_venda_id);

        $this->pedido_venda_item_pedido_venda_id_list->addItems($pedido_venda_item_pedido_venda_id_items);

        $icon = new TImage('fas:boxes #2196F3');
        $title = new TTextDisplay("{$icon} PRODUTOS", '#333', '16px', '{$fontStyle}');

        $panel = new TPanelGroup($title, '#f5f5f5');
        $panel->class = 'panel panel-default formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->pedido_venda_item_pedido_venda_id_list));

        $this->form->addContent([$panel]);

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        TTransaction::close();
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ClientePedidoVendaPublicoFormView]');
        $style->width = '90% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

