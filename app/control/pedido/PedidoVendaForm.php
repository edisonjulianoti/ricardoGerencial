<?php

class PedidoVendaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVenda';
    private static $primaryKey = 'id';
    private static $formName = 'form_PedidoVendaForm';

    use BuilderMasterDetailTrait;

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

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de pedido de venda");

        $criteria_vendedor_id = new TCriteria();
        $criteria_transportadora_id = new TCriteria();

        $filterVar = GrupoPessoa::VENDEDOR;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 
        $filterVar = GrupoPessoa::TRANSPORTADORA;
        $criteria_transportadora_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        // aqui posso escrever

        $id = new TEntry('id');
        $dt_pedido = new TDate('dt_pedido');
        $vendedor_id = new TDBCombo('vendedor_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $cliente_id = new TSeekButton('cliente_id');
        $cliente_nome = new TEntry('cliente_nome');
        $condicao_pagamento_id = new TDBCombo('condicao_pagamento_id', 'minierp', 'CondicaoPagamento', 'id', '{nome}','nome asc'  );
        $tipo_pedido_id = new TDBCombo('tipo_pedido_id', 'minierp', 'TipoPedido', 'id', '{nome}','nome asc'  );
        $frete = new TNumeric('frete', '2', ',', '.' );
        $transportadora_id = new TDBCombo('transportadora_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_transportadora_id );
        $obs = new TText('obs');
        $pedido_venda_item_pedido_venda_produto_familia_produto_id = new TDBCombo('pedido_venda_item_pedido_venda_produto_familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $pedido_venda_item_pedido_venda_produto_id = new TCombo('pedido_venda_item_pedido_venda_produto_id');
        $pedido_venda_item_pedido_venda_id = new THidden('pedido_venda_item_pedido_venda_id');
        $pedido_venda_item_pedido_venda_valor = new TNumeric('pedido_venda_item_pedido_venda_valor', '2', ',', '.' );
        $pedido_venda_item_pedido_venda_quantidade = new TNumeric('pedido_venda_item_pedido_venda_quantidade', '2', ',', '.' );
        $pedido_venda_item_pedido_venda_desconto = new TNumeric('pedido_venda_item_pedido_venda_desconto', '2', ',', '.' );
        $button_adicionar_pedido_venda_item_pedido_venda = new TButton('button_adicionar_pedido_venda_item_pedido_venda');

        $pedido_venda_item_pedido_venda_produto_familia_produto_id->setChangeAction(new TAction([$this,'onChangepedido_venda_item_pedido_venda_produto_familia_produto_id']));
        $pedido_venda_item_pedido_venda_produto_id->setChangeAction(new TAction([$this,'onChangeProduto']));

        $vendedor_id->addValidation("Vendedor", new TRequiredValidator()); 
        $cliente_id->addValidation("cliente", new TRequiredValidator()); 

        $dt_pedido->setMask('dd/mm/yyyy');
        $dt_pedido->setDatabaseMask('yyyy-mm-dd');
        $button_adicionar_pedido_venda_item_pedido_venda->setAction(new TAction([$this, 'onAddDetailPedidoVendaItemPedidoVenda'],['static' => 1]), "Adicionar");
        $button_adicionar_pedido_venda_item_pedido_venda->addStyleClass('btn-default');
        $button_adicionar_pedido_venda_item_pedido_venda->setImage('fas:plus #2ecc71');
        $id->setEditable(false);
        $cliente_nome->setEditable(false);

        $vendedor_id->enableSearch();
        $tipo_pedido_id->enableSearch();
        $transportadora_id->enableSearch();
        $condicao_pagamento_id->enableSearch();
        $pedido_venda_item_pedido_venda_produto_id->enableSearch();
        $pedido_venda_item_pedido_venda_produto_familia_produto_id->enableSearch();

        $id->setSize(100);
        $frete->setSize('100%');
        $dt_pedido->setSize(110);
        $cliente_id->setSize(110);
        $obs->setSize('100%', 70);
        $vendedor_id->setSize('100%');
        $tipo_pedido_id->setSize('100%');
        $transportadora_id->setSize('100%');
        $condicao_pagamento_id->setSize('100%');
        $cliente_nome->setSize('calc(100% - 130px)');
        $pedido_venda_item_pedido_venda_id->setSize(200);
        $pedido_venda_item_pedido_venda_valor->setSize('100%');
        $pedido_venda_item_pedido_venda_desconto->setSize('100%');
        $pedido_venda_item_pedido_venda_produto_id->setSize('100%');
        $pedido_venda_item_pedido_venda_quantidade->setSize('100%');
        $pedido_venda_item_pedido_venda_produto_familia_produto_id->setSize('100%');



        $button_adicionar_pedido_venda_item_pedido_venda->id = '624f76ab37c43';

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $cliente_id_seekAction = new TAction(['ClienteSeekWindow', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'cliente_id', 'column'=>'{id}'],
            ['name'=> 'cliente_nome', 'column'=>'{nome}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $cliente_id_seekAction->setParameter('_seek_fields', $seekFields);
        $cliente_id_seekAction->setParameter('_seek_filters', $seekFilters);
        $cliente_id_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $cliente_id->setAction($cliente_id_seekAction);

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Data do pedido:", null, '14px', null, '100%'),$dt_pedido]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Vendedor:", '#ff0000', '14px', null, '100%'),$vendedor_id],[new TLabel("Cliente:", '#ff0000', '14px', null, '100%'),$cliente_id,$cliente_nome]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Condição de pagamento:", '#FF0000', '14px', null, '100%'),$condicao_pagamento_id],[new TLabel("Tipo do pedido:", '#FF0000', '14px', null, '100%'),$tipo_pedido_id]);
        $row3->layout = ['col-sm-6',' col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Frete:", null, '14px', null, '100%'),$frete],[new TLabel("Transportadora:", '#FF0000', '14px', null, '100%'),$transportadora_id]);
        $row4->layout = ['col-sm-6',' col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Obs:", null, '14px', null, '100%'),$obs]);
        $row5->layout = [' col-sm-12'];

        $tab_62caa82503358 = new BootstrapFormBuilder('tab_62caa82503358');
        $this->tab_62caa82503358 = $tab_62caa82503358;
        $tab_62caa82503358->setProperty('style', 'border:none; box-shadow:none;');

        $tab_62caa82503358->appendPage("Produtos");

        $tab_62caa82503358->addFields([new THidden('current_tab_tab_62caa82503358')]);
        $tab_62caa82503358->setTabFunction("$('[name=current_tab_tab_62caa82503358]').val($(this).attr('data-current_page'));");

        $this->detailFormPedidoVendaItemPedidoVenda = new BootstrapFormBuilder('detailFormPedidoVendaItemPedidoVenda');
        $this->detailFormPedidoVendaItemPedidoVenda->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormPedidoVendaItemPedidoVenda->setProperty('class', 'form-horizontal builder-detail-form');

        $row6 = $this->detailFormPedidoVendaItemPedidoVenda->addFields([new TLabel("Família do produto", null, '14px', null, '100%'),$pedido_venda_item_pedido_venda_produto_familia_produto_id],[]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->detailFormPedidoVendaItemPedidoVenda->addFields([new TLabel("Produto:", '#ff0000', '14px', null, '100%'),$pedido_venda_item_pedido_venda_produto_id,$pedido_venda_item_pedido_venda_id],[new TLabel("Valor:", null, '14px', null, '100%'),$pedido_venda_item_pedido_venda_valor]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->detailFormPedidoVendaItemPedidoVenda->addFields([new TLabel("Quantidade:", null, '14px', null, '100%'),$pedido_venda_item_pedido_venda_quantidade],[new TLabel("Desconto:", null, '14px', null, '100%'),$pedido_venda_item_pedido_venda_desconto]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->detailFormPedidoVendaItemPedidoVenda->addFields([$button_adicionar_pedido_venda_item_pedido_venda]);
        $row9->layout = [' col-sm-12'];

        $row10 = $this->detailFormPedidoVendaItemPedidoVenda->addFields([new THidden('pedido_venda_item_pedido_venda__row__id')]);
        $this->pedido_venda_item_pedido_venda_criteria = new TCriteria();

        $this->pedido_venda_item_pedido_venda_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->pedido_venda_item_pedido_venda_list->disableHtmlConversion();;
        $this->pedido_venda_item_pedido_venda_list->generateHiddenFields();
        $this->pedido_venda_item_pedido_venda_list->setId('pedido_venda_item_pedido_venda_list');

        $this->pedido_venda_item_pedido_venda_list->style = 'width:100%';
        $this->pedido_venda_item_pedido_venda_list->class .= ' table-bordered';

        $column_pedido_venda_item_pedido_venda_produto_nome = new TDataGridColumn('produto->nome', "Produto", 'left');
        $column_pedido_venda_item_pedido_venda_quantidade = new TDataGridColumn('quantidade', "Quantidade", 'left');
        $column_pedido_venda_item_pedido_venda_valor_transformed = new TDataGridColumn('valor', "Valor", 'left');
        $column_pedido_venda_item_pedido_venda_desconto_transformed = new TDataGridColumn('desconto', "Desconto", 'left');
        $column_calculated_1 = new TDataGridColumn('=( {quantidade} * ({valor} - {desconto} )  )', "Valor total", 'left');

        $column_pedido_venda_item_pedido_venda__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_pedido_venda_item_pedido_venda__row__data->setVisibility(false);

        $column_calculated_1->enableTotal('sum', 'R$', 2, ',', '.');

        $action_onEditDetailPedidoVendaItem = new TDataGridAction(array('PedidoVendaForm', 'onEditDetailPedidoVendaItem'));
        $action_onEditDetailPedidoVendaItem->setUseButton(false);
        $action_onEditDetailPedidoVendaItem->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailPedidoVendaItem->setLabel("Editar");
        $action_onEditDetailPedidoVendaItem->setImage('far:edit #478fca');
        $action_onEditDetailPedidoVendaItem->setFields(['__row__id', '__row__data']);

        $this->pedido_venda_item_pedido_venda_list->addAction($action_onEditDetailPedidoVendaItem);
        $action_onDeleteDetailPedidoVendaItem = new TDataGridAction(array('PedidoVendaForm', 'onDeleteDetailPedidoVendaItem'));
        $action_onDeleteDetailPedidoVendaItem->setUseButton(false);
        $action_onDeleteDetailPedidoVendaItem->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailPedidoVendaItem->setLabel("Excluir");
        $action_onDeleteDetailPedidoVendaItem->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailPedidoVendaItem->setFields(['__row__id', '__row__data']);

        $this->pedido_venda_item_pedido_venda_list->addAction($action_onDeleteDetailPedidoVendaItem);

        $this->pedido_venda_item_pedido_venda_list->addColumn($column_pedido_venda_item_pedido_venda_produto_nome);
        $this->pedido_venda_item_pedido_venda_list->addColumn($column_pedido_venda_item_pedido_venda_quantidade);
        $this->pedido_venda_item_pedido_venda_list->addColumn($column_pedido_venda_item_pedido_venda_valor_transformed);
        $this->pedido_venda_item_pedido_venda_list->addColumn($column_pedido_venda_item_pedido_venda_desconto_transformed);
        $this->pedido_venda_item_pedido_venda_list->addColumn($column_calculated_1);

        $this->pedido_venda_item_pedido_venda_list->addColumn($column_pedido_venda_item_pedido_venda__row__data);

        $this->pedido_venda_item_pedido_venda_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->pedido_venda_item_pedido_venda_list);
        $this->detailFormPedidoVendaItemPedidoVenda->addContent([$tableResponsiveDiv]);

        $column_pedido_venda_item_pedido_venda_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_pedido_venda_item_pedido_venda_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_calculated_1->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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
        });        $row11 = $tab_62caa82503358->addFields([$this->detailFormPedidoVendaItemPedidoVenda]);
        $row11->layout = [' col-sm-12'];

        $row12 = $this->form->addFields([$tab_62caa82503358]);
        $row12->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PedidoVendaList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=PedidoVendaForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public static function onChangepedido_venda_item_pedido_venda_produto_familia_produto_id($param)
    {
        try
        {

            if (isset($param['pedido_venda_item_pedido_venda_produto_familia_produto_id']) && $param['pedido_venda_item_pedido_venda_produto_familia_produto_id'])
            { 
                $criteria = TCriteria::create(['familia_produto_id' => $param['pedido_venda_item_pedido_venda_produto_familia_produto_id']]);
                $filterVar = [TipoProduto::PRODUTO, TipoProduto::MERCADORIA];
                $criteria->add(new TFilter('tipo_produto_id', 'in', $filterVar)); 
                TDBCombo::reloadFromModel(self::$formName, 'pedido_venda_item_pedido_venda_produto_id', 'minierp', 'Produto', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'pedido_venda_item_pedido_venda_produto_id'); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    } 

    public static function onChangeProduto($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Conexão com banco de dados"
            TTransaction::open('minierp');

            $produto = Produto::find($param['key']);

            if($produto)
            {
                // Código gerado pelo snippet: "Enviar dados para campo"
                $object = new stdClass();
                $object->pedido_venda_item_pedido_venda_valor = number_format($produto->preco_venda, '2', ',', '.');
                //$object->fieldName = 'insira o novo valor aqui'; //sample

                TForm::sendData(self::$formName, $object);
                // -----
            }

            TTransaction::close();
            // -----

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onAddDetailPedidoVendaItemPedidoVenda($param = null) 
    {
        try
        {
            $data = $this->form->getData();

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Produto", 'name'=>"pedido_venda_item_pedido_venda_produto_id", 'class'=>'TRequiredValidator', 'value'=>[]];
            foreach($requiredFields as $requiredField)
            {
                try
                {
                    (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                }
                catch(Exception $e)
                {
                    $errors[] = $e->getMessage() . '.';
                }
             }
             if(count($errors) > 0)
             {
                 throw new Exception(implode('<br>', $errors));
             }

            $__row__id = !empty($data->pedido_venda_item_pedido_venda__row__id) ? $data->pedido_venda_item_pedido_venda__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new PedidoVendaItem();
            $grid_data->__row__id = $__row__id;
            $grid_data->produto_familia_produto_id = $data->pedido_venda_item_pedido_venda_produto_familia_produto_id;
            $grid_data->produto_id = $data->pedido_venda_item_pedido_venda_produto_id;
            $grid_data->id = $data->pedido_venda_item_pedido_venda_id;
            $grid_data->valor = $data->pedido_venda_item_pedido_venda_valor;
            $grid_data->quantidade = $data->pedido_venda_item_pedido_venda_quantidade;
            $grid_data->desconto = $data->pedido_venda_item_pedido_venda_desconto;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['produto_familia_produto_id'] =  $param['pedido_venda_item_pedido_venda_produto_familia_produto_id'] ?? null;
            $__row__data['__display__']['produto_id'] =  $param['pedido_venda_item_pedido_venda_produto_id'] ?? null;
            $__row__data['__display__']['id'] =  $param['pedido_venda_item_pedido_venda_id'] ?? null;
            $__row__data['__display__']['valor'] =  $param['pedido_venda_item_pedido_venda_valor'] ?? null;
            $__row__data['__display__']['quantidade'] =  $param['pedido_venda_item_pedido_venda_quantidade'] ?? null;
            $__row__data['__display__']['desconto'] =  $param['pedido_venda_item_pedido_venda_desconto'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->pedido_venda_item_pedido_venda_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('pedido_venda_item_pedido_venda_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->pedido_venda_item_pedido_venda_produto_familia_produto_id = '';
            $data->pedido_venda_item_pedido_venda_produto_id = '';
            $data->pedido_venda_item_pedido_venda_id = '';
            $data->pedido_venda_item_pedido_venda_valor = '';
            $data->pedido_venda_item_pedido_venda_quantidade = '';
            $data->pedido_venda_item_pedido_venda_desconto = '';
            $data->pedido_venda_item_pedido_venda__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#624f76ab37c43');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onEditDetailPedidoVendaItem($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;

            $data = new stdClass;
            $data->pedido_venda_item_pedido_venda_produto_familia_produto_id = $__row__data->__display__->produto_familia_produto_id ?? null;
            $data->pedido_venda_item_pedido_venda_produto_id = $__row__data->__display__->produto_id ?? null;
            $data->pedido_venda_item_pedido_venda_id = $__row__data->__display__->id ?? null;
            $data->pedido_venda_item_pedido_venda_valor = $__row__data->__display__->valor ?? null;
            $data->pedido_venda_item_pedido_venda_quantidade = $__row__data->__display__->quantidade ?? null;
            $data->pedido_venda_item_pedido_venda_desconto = $__row__data->__display__->desconto ?? null;
            $data->pedido_venda_item_pedido_venda__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#624f76ab37c43');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editar</span>\");
               if(!element.attr('edit')){
                   element.attr('edit', base64_encode(element.html()));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onDeleteDetailPedidoVendaItem($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->pedido_venda_item_pedido_venda_produto_familia_produto_id = '';
            $data->pedido_venda_item_pedido_venda_produto_id = '';
            $data->pedido_venda_item_pedido_venda_id = '';
            $data->pedido_venda_item_pedido_venda_valor = '';
            $data->pedido_venda_item_pedido_venda_quantidade = '';
            $data->pedido_venda_item_pedido_venda_desconto = '';
            $data->pedido_venda_item_pedido_venda__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('pedido_venda_item_pedido_venda_list', $__row__data->__row__id);

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new PedidoVenda(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $pedidoNovo = false;

            if(!$data->id)
            {
                $pedidoNovo = true;
                $object->estado_pedido_venda_id = EstadoPedidoVenda::ELABORACAO;
            }

            $dt_pedido = new DateTime($data->dt_pedido);

            $object->mes = $dt_pedido->format('m');
            $object->ano = $dt_pedido->format('Y');

            $object->valor_total = 0;

            $object->store(); // save the object 

            $this->fireEvents($object);

            TForm::sendData(self::$formName, (object)['id' => $object->id]);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $pedido_venda_item_pedido_venda_items = $this->storeMasterDetailItems('PedidoVendaItem', 'pedido_venda_id', 'pedido_venda_item_pedido_venda', $object, $param['pedido_venda_item_pedido_venda_list___row__data'] ?? [], $this->form, $this->pedido_venda_item_pedido_venda_list, function($masterObject, $detailObject){ 

                if(!$detailObject->desconto)
                {
                    $detailObject->desconto = 0;
                }

                $detailObject->valor_total = ($detailObject->valor - $detailObject->desconto) * $detailObject->quantidade;
                $masterObject->valor_total += $detailObject->valor_total;

            }, $this->pedido_venda_item_pedido_venda_criteria); 

            $object->store();

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            if($pedidoNovo)
            {
                TTransaction::open(self::$database);

                PedidoVendaService::notificarAprovador($object);

                TTransaction::close();
            }

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('PedidoVendaList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode>  

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new PedidoVenda($key); // instantiates the Active Record 

                                $object->cliente_nome = $object->cliente->nome;

                $pedido_venda_item_pedido_venda_items = $this->loadMasterDetailItems('PedidoVendaItem', 'pedido_venda_id', 'pedido_venda_item_pedido_venda', $object, $this->form, $this->pedido_venda_item_pedido_venda_list, $this->pedido_venda_item_pedido_venda_criteria, function($masterObject, $detailObject, $objectItems){ 

                    $objectItems->pedido_venda_item_pedido_venda_produto_familia_produto_id = null;
                    if(isset($detailObject->produto->familia_produto_id) && $detailObject->produto->familia_produto_id)
                    {
                        $objectItems->__display__->produto_familia_produto_id = $detailObject->produto->familia_produto_id;
                    }

                    $objectItems->pedido_venda_item_pedido_venda_produto_id = null;
                    if(isset($detailObject->produto_id) && $detailObject->produto_id)
                    {
                        $objectItems->__display__->produto_id = $detailObject->produto_id;
                    }

                }); 

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->pedido_venda_item_pedido_venda_produto_familia_produto_id))
            {
                $value = $object->pedido_venda_item_pedido_venda_produto_familia_produto_id;

                $obj->pedido_venda_item_pedido_venda_produto_familia_produto_id = $value;
            }
            if(isset($object->pedido_venda_item_pedido_venda_produto_id))
            {
                $value = $object->pedido_venda_item_pedido_venda_produto_id;

                $obj->pedido_venda_item_pedido_venda_produto_id = $value;
            }
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->pedido_venda_item->pedido_venda->produto->familia_produto_id))
            {
                $value = $object->pedido_venda_item->pedido_venda->produto->familia_produto_id;

                $obj->pedido_venda_item_pedido_venda_produto_familia_produto_id = $value;
            }
            if(isset($object->pedido_venda_item->pedido_venda->produto_id))
            {
                $value = $object->pedido_venda_item->pedido_venda->produto_id;

                $obj->pedido_venda_item_pedido_venda_produto_id = $value;
            }
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

}

