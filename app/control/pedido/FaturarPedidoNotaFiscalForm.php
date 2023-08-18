<?php

class FaturarPedidoNotaFiscalForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'NotaFiscal';
    private static $primaryKey = 'id';
    private static $formName = 'form_FaturarPedidoNotaFiscalForm';

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
        $this->form->setFormTitle("Faturar a partir do pedido");


        $id = new TEntry('id');
        $pedido_venda_id = new TEntry('pedido_venda_id');
        $data_emissao = new TDate('data_emissao');
        $cliente_id = new TDBCombo('cliente_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc'  );
        $condicao_pagamento_id = new TDBCombo('condicao_pagamento_id', 'minierp', 'CondicaoPagamento', 'id', '{nome}','nome asc'  );
        $obs = new TText('obs');
        $nota_fiscal_item_nota_fiscal_produto_id = new TDBCombo('nota_fiscal_item_nota_fiscal_produto_id', 'minierp', 'Produto', 'id', '{nome}','nome asc'  );
        $nota_fiscal_item_nota_fiscal_id = new THidden('nota_fiscal_item_nota_fiscal_id');
        $nota_fiscal_item_nota_fiscal_quantidade = new TNumeric('nota_fiscal_item_nota_fiscal_quantidade', '2', ',', '.' );
        $nota_fiscal_item_nota_fiscal_valor = new TNumeric('nota_fiscal_item_nota_fiscal_valor', '2', ',', '.' );
        $nota_fiscal_item_nota_fiscal_desconto = new TNumeric('nota_fiscal_item_nota_fiscal_desconto', '2', ',', '.' );
        $nota_fiscal_item_nota_fiscal_valor_total = new TNumeric('nota_fiscal_item_nota_fiscal_valor_total', '2', ',', '.' );
        $button_adicionar_nota_fiscal_item_nota_fiscal = new TButton('button_adicionar_nota_fiscal_item_nota_fiscal');

        $pedido_venda_id->addValidation("Código do pedido de venda", new TRequiredValidator()); 
        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 
        $condicao_pagamento_id->addValidation("Condicao pagamento id", new TRequiredValidator()); 

        $data_emissao->setMask('dd/mm/yyyy');
        $data_emissao->setValue(date('d/m/Y'));
        $data_emissao->setDatabaseMask('yyyy-mm-dd');
        $button_adicionar_nota_fiscal_item_nota_fiscal->setAction(new TAction([$this, 'onAddDetailNotaFiscalItemNotaFiscal'],['static' => 1]), "Adicionar");
        $button_adicionar_nota_fiscal_item_nota_fiscal->addStyleClass('btn-default');
        $button_adicionar_nota_fiscal_item_nota_fiscal->setImage('fas:plus #2ecc71');
        $id->setEditable(false);
        $pedido_venda_id->setEditable(false);

        $cliente_id->enableSearch();
        $condicao_pagamento_id->enableSearch();
        $nota_fiscal_item_nota_fiscal_produto_id->enableSearch();

        $id->setSize('100%');
        $obs->setSize('100%', 90);
        $data_emissao->setSize(110);
        $cliente_id->setSize('100%');
        $pedido_venda_id->setSize('100%');
        $condicao_pagamento_id->setSize('100%');
        $nota_fiscal_item_nota_fiscal_id->setSize(200);
        $nota_fiscal_item_nota_fiscal_valor->setSize('100%');
        $nota_fiscal_item_nota_fiscal_quantidade->setSize(110);
        $nota_fiscal_item_nota_fiscal_desconto->setSize('100%');
        $nota_fiscal_item_nota_fiscal_produto_id->setSize('100%');
        $nota_fiscal_item_nota_fiscal_valor_total->setSize('100%');



        $button_adicionar_nota_fiscal_item_nota_fiscal->id = '62688ebdf0667';

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Cód. Pedido Venda", null, '14px', null, '100%'),$pedido_venda_id],[new TLabel("Data da emissão:", null, '14px', null, '100%'),$data_emissao]);
        $row1->layout = [' col-sm-3',' col-sm-3','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Cliente:", '#ff0000', '14px', null, '100%'),$cliente_id],[new TLabel("Condição de pagamento", '#ff0000', '14px', null, '100%'),$condicao_pagamento_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Obs:", null, '14px', null, '100%'),$obs]);
        $row3->layout = [' col-sm-12'];

        $this->detailFormNotaFiscalItemNotaFiscal = new BootstrapFormBuilder('detailFormNotaFiscalItemNotaFiscal');
        $this->detailFormNotaFiscalItemNotaFiscal->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormNotaFiscalItemNotaFiscal->setProperty('class', 'form-horizontal builder-detail-form');

        $row4 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([new TFormSeparator("Produtos", '#333', '18', '#eee')]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([new TLabel("Produto:", '#ff0000', '14px', null, '100%'),$nota_fiscal_item_nota_fiscal_produto_id,$nota_fiscal_item_nota_fiscal_id],[new TLabel("Quantidade:", null, '14px', null, '100%'),$nota_fiscal_item_nota_fiscal_quantidade]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([new TLabel("Valor:", null, '14px', null, '100%'),$nota_fiscal_item_nota_fiscal_valor],[new TLabel("Desconto:", null, '14px', null, '100%'),$nota_fiscal_item_nota_fiscal_desconto]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([new TLabel("Valor total:", null, '14px', null, '100%'),$nota_fiscal_item_nota_fiscal_valor_total],[]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([$button_adicionar_nota_fiscal_item_nota_fiscal]);
        $row8->layout = [' col-sm-12'];

        $row9 = $this->detailFormNotaFiscalItemNotaFiscal->addFields([new THidden('nota_fiscal_item_nota_fiscal__row__id')]);
        $this->nota_fiscal_item_nota_fiscal_criteria = new TCriteria();

        $this->nota_fiscal_item_nota_fiscal_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->nota_fiscal_item_nota_fiscal_list->disableHtmlConversion();;
        $this->nota_fiscal_item_nota_fiscal_list->generateHiddenFields();
        $this->nota_fiscal_item_nota_fiscal_list->setId('nota_fiscal_item_nota_fiscal_list');

        $this->nota_fiscal_item_nota_fiscal_list->style = 'width:100%';
        $this->nota_fiscal_item_nota_fiscal_list->class .= ' table-bordered';

        $column_nota_fiscal_item_nota_fiscal_produto_nome = new TDataGridColumn('produto->nome', "Produto", 'left');
        $column_nota_fiscal_item_nota_fiscal_quantidade = new TDataGridColumn('quantidade', "Quantidade", 'left');
        $column_nota_fiscal_item_nota_fiscal_valor = new TDataGridColumn('valor', "Valor", 'left');
        $column_nota_fiscal_item_nota_fiscal_desconto = new TDataGridColumn('desconto', "Desconto", 'left');
        $column_nota_fiscal_item_nota_fiscal_valor_total = new TDataGridColumn('valor_total', "Valor total", 'left');

        $column_nota_fiscal_item_nota_fiscal__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_nota_fiscal_item_nota_fiscal__row__data->setVisibility(false);

        $action_onEditDetailNotaFiscalItem = new TDataGridAction(array('FaturarPedidoNotaFiscalForm', 'onEditDetailNotaFiscalItem'));
        $action_onEditDetailNotaFiscalItem->setUseButton(false);
        $action_onEditDetailNotaFiscalItem->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailNotaFiscalItem->setLabel("Editar");
        $action_onEditDetailNotaFiscalItem->setImage('far:edit #478fca');
        $action_onEditDetailNotaFiscalItem->setFields(['__row__id', '__row__data']);

        $this->nota_fiscal_item_nota_fiscal_list->addAction($action_onEditDetailNotaFiscalItem);
        $action_onDeleteDetailNotaFiscalItem = new TDataGridAction(array('FaturarPedidoNotaFiscalForm', 'onDeleteDetailNotaFiscalItem'));
        $action_onDeleteDetailNotaFiscalItem->setUseButton(false);
        $action_onDeleteDetailNotaFiscalItem->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailNotaFiscalItem->setLabel("Excluir");
        $action_onDeleteDetailNotaFiscalItem->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailNotaFiscalItem->setFields(['__row__id', '__row__data']);

        $this->nota_fiscal_item_nota_fiscal_list->addAction($action_onDeleteDetailNotaFiscalItem);

        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal_produto_nome);
        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal_quantidade);
        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal_valor);
        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal_desconto);
        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal_valor_total);

        $this->nota_fiscal_item_nota_fiscal_list->addColumn($column_nota_fiscal_item_nota_fiscal__row__data);

        $this->nota_fiscal_item_nota_fiscal_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->nota_fiscal_item_nota_fiscal_list);
        $this->detailFormNotaFiscalItemNotaFiscal->addContent([$tableResponsiveDiv]);
        $row10 = $this->form->addFields([$this->detailFormNotaFiscalItemNotaFiscal]);
        $row10->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=FaturarPedidoNotaFiscalForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public  function onAddDetailNotaFiscalItemNotaFiscal($param = null) 
    {
        try
        {
            $data = $this->form->getData();

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Produto id", 'name'=>"nota_fiscal_item_nota_fiscal_produto_id", 'class'=>'TRequiredValidator', 'value'=>[]];
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

            $__row__id = !empty($data->nota_fiscal_item_nota_fiscal__row__id) ? $data->nota_fiscal_item_nota_fiscal__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new NotaFiscalItem();
            $grid_data->__row__id = $__row__id;
            $grid_data->produto_id = $data->nota_fiscal_item_nota_fiscal_produto_id;
            $grid_data->id = $data->nota_fiscal_item_nota_fiscal_id;
            $grid_data->quantidade = $data->nota_fiscal_item_nota_fiscal_quantidade;
            $grid_data->valor = $data->nota_fiscal_item_nota_fiscal_valor;
            $grid_data->desconto = $data->nota_fiscal_item_nota_fiscal_desconto;
            $grid_data->valor_total = $data->nota_fiscal_item_nota_fiscal_valor_total;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['produto_id'] =  $param['nota_fiscal_item_nota_fiscal_produto_id'] ?? null;
            $__row__data['__display__']['id'] =  $param['nota_fiscal_item_nota_fiscal_id'] ?? null;
            $__row__data['__display__']['quantidade'] =  $param['nota_fiscal_item_nota_fiscal_quantidade'] ?? null;
            $__row__data['__display__']['valor'] =  $param['nota_fiscal_item_nota_fiscal_valor'] ?? null;
            $__row__data['__display__']['desconto'] =  $param['nota_fiscal_item_nota_fiscal_desconto'] ?? null;
            $__row__data['__display__']['valor_total'] =  $param['nota_fiscal_item_nota_fiscal_valor_total'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->nota_fiscal_item_nota_fiscal_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('nota_fiscal_item_nota_fiscal_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->nota_fiscal_item_nota_fiscal_produto_id = '';
            $data->nota_fiscal_item_nota_fiscal_id = '';
            $data->nota_fiscal_item_nota_fiscal_quantidade = '';
            $data->nota_fiscal_item_nota_fiscal_valor = '';
            $data->nota_fiscal_item_nota_fiscal_desconto = '';
            $data->nota_fiscal_item_nota_fiscal_valor_total = '';
            $data->nota_fiscal_item_nota_fiscal__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#62688ebdf0667');
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

    public static function onEditDetailNotaFiscalItem($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;

            $data = new stdClass;
            $data->nota_fiscal_item_nota_fiscal_produto_id = $__row__data->__display__->produto_id ?? null;
            $data->nota_fiscal_item_nota_fiscal_id = $__row__data->__display__->id ?? null;
            $data->nota_fiscal_item_nota_fiscal_quantidade = $__row__data->__display__->quantidade ?? null;
            $data->nota_fiscal_item_nota_fiscal_valor = $__row__data->__display__->valor ?? null;
            $data->nota_fiscal_item_nota_fiscal_desconto = $__row__data->__display__->desconto ?? null;
            $data->nota_fiscal_item_nota_fiscal_valor_total = $__row__data->__display__->valor_total ?? null;
            $data->nota_fiscal_item_nota_fiscal__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#62688ebdf0667');
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
    public static function onDeleteDetailNotaFiscalItem($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->nota_fiscal_item_nota_fiscal_produto_id = '';
            $data->nota_fiscal_item_nota_fiscal_id = '';
            $data->nota_fiscal_item_nota_fiscal_quantidade = '';
            $data->nota_fiscal_item_nota_fiscal_valor = '';
            $data->nota_fiscal_item_nota_fiscal_desconto = '';
            $data->nota_fiscal_item_nota_fiscal_valor_total = '';
            $data->nota_fiscal_item_nota_fiscal__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('nota_fiscal_item_nota_fiscal_list', $__row__data->__row__id);

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

            $object = new NotaFiscal(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            TForm::sendData(self::$formName, (object)['id' => $object->id]);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $nota_fiscal_item_nota_fiscal_items = $this->storeMasterDetailItems('NotaFiscalItem', 'nota_fiscal_id', 'nota_fiscal_item_nota_fiscal', $object, $param['nota_fiscal_item_nota_fiscal_list___row__data'] ?? [], $this->form, $this->nota_fiscal_item_nota_fiscal_list, function($masterObject, $detailObject){ 

                //code here

            }, $this->nota_fiscal_item_nota_fiscal_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data

            if($object->pedido_venda_id && $object->pedido_venda->estado_pedido_venda_id == EstadoPedidoVenda::EM_FATURAMENTO)
            {
                $proximoEstadoPedidoVenda = EstadoPedidoVenda::getProximoEstadoPedidoVenda($object->pedido_venda->estado_pedido_venda_id);

                if(!$proximoEstadoPedidoVenda)
                {
                    throw new Exception('Próximo estado não encontrado!');
                }

                $object->pedido_venda->estado_pedido_venda_id = $proximoEstadoPedidoVenda->id;
                $object->pedido_venda->store();
            }

            TTransaction::close(); // close the transaction

            TTransaction::open('minierp');

            PedidoVendaService::notificarAprovador($object->pedido_venda);
            PedidoVendaService::notificarVendedorPedido($object->pedido_venda);

            TTransaction::close();

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('PedidoVendaPendenteList', 'onShow', $loadPageParam); 

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

                $object = new NotaFiscal($key); // instantiates the Active Record 

                $nota_fiscal_item_nota_fiscal_items = $this->loadMasterDetailItems('NotaFiscalItem', 'nota_fiscal_id', 'nota_fiscal_item_nota_fiscal', $object, $this->form, $this->nota_fiscal_item_nota_fiscal_list, $this->nota_fiscal_item_nota_fiscal_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

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

    public  function onShowFormPedidoPendente($param = null) 
    {
        try 
        {

            TTransaction::open(self::$database);

            $pedidoVenda = new PedidoVenda($param['key']);

            $notaFiscal = NotaFiscal::where('pedido_venda_id', '=', $pedidoVenda->id)->first();

            if(!$notaFiscal)
            {
                $notaFiscal = NotaFiscal::createFromPedidoVenda($pedidoVenda);    
            }

            TTransaction::close();

            $this->onEdit(['key' => $notaFiscal->id]);

        }
        catch (Exception $e) 
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());    
        }
    }

}

