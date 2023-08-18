<?php

class ClientePedidoVendaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVenda';
    private static $primaryKey = 'id';
    private static $formName = 'form_PedidoVendaList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de pedidos de venda");
        $this->limit = 20;

        $criteria_vendedor_id = new TCriteria();

        $filterVar = GrupoPessoa::VENDEDOR;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $cliente_id = new TSeekButton('cliente_id');
        $cliente_nome = new TEntry('cliente_nome');
        $vendedor_id = new TDBCombo('vendedor_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $estado_pedido_venda_id = new TDBCombo('estado_pedido_venda_id', 'minierp', 'EstadoPedidoVenda', 'id', '{nome}','nome asc'  );
        $dt_pedido = new TDate('dt_pedido');
        $data_fina_pedido = new TDate('data_fina_pedido');


        $cliente_nome->setEditable(false);
        $vendedor_id->enableSearch();
        $estado_pedido_venda_id->enableSearch();

        $dt_pedido->setMask('dd/mm/yyyy');
        $data_fina_pedido->setMask('dd/mm/yyyy');

        $dt_pedido->setDatabaseMask('yyyy-mm-dd');
        $data_fina_pedido->setDatabaseMask('yyyy-mm-dd');

        $dt_pedido->setSize(110);
        $cliente_id->setSize(110);
        $vendedor_id->setSize('100%');
        $data_fina_pedido->setSize(110);
        $estado_pedido_venda_id->setSize('100%');
        $cliente_nome->setSize('calc(100% - 130px)');


        $row1 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null, '100%'),$cliente_id,$cliente_nome],[new TLabel("Vendedor:", null, '14px', null, '100%'),$vendedor_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Estado de pedido:", null, '14px', null, '100%'),$estado_pedido_venda_id],[new TLabel("Data do pedido:", null, '14px', null, '100%'),$dt_pedido,new TLabel("até", null, '14px', null),$data_fina_pedido]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        $this->fireEvents( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        if(!empty($param['cliente_id']))
        {
            TSession::setValue(__CLASS__.'load_filter_cliente_id', $param['cliente_id']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_cliente_id');
        $this->filter_criteria->add(new TFilter('cliente_id', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_cliente_nome = new TDataGridColumn('cliente->nome', "Cliente", 'left');
        $column_vendedor_nome = new TDataGridColumn('vendedor->nome', "Vendedor", 'left');
        $column_dt_pedido_transformed = new TDataGridColumn('dt_pedido', "Data do Pedido", 'left');
        $column_valor_total_transformed = new TDataGridColumn('valor_total', "Valor total", 'left');
        $column_estado_pedido_venda_nome_transformed = new TDataGridColumn('estado_pedido_venda->nome', "Estado de pedido", 'left');

        $column_dt_pedido_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
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

        $column_estado_pedido_venda_nome_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            return "<span class='label label-default' style='width:170px; background-color:{$object->estado_pedido_venda->cor}'> {$object->estado_pedido_venda->nome} <span>";

        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_cliente_nome);
        $this->datagrid->addColumn($column_vendedor_nome);
        $this->datagrid->addColumn($column_dt_pedido_transformed);
        $this->datagrid->addColumn($column_valor_total_transformed);
        $this->datagrid->addColumn($column_estado_pedido_venda_nome_transformed);

        $action_onShow = new TDataGridAction(array('PedidoVendaFormView', 'onShow'));
        $action_onShow->setUseButton(false);
        $action_onShow->setButtonClass('btn btn-default btn-sm');
        $action_onShow->setLabel("Visualizar Pedido");
        $action_onShow->setImage('fas:search-plus #673AB7');
        $action_onShow->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onShow);

        $action_onEdit = new TDataGridAction(array('PedidoVendaForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('ClientePedidoVendaList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        $action_onGenerate = new TDataGridAction(array('PedidoVendaDocument', 'onGenerate'));
        $action_onGenerate->setUseButton(false);
        $action_onGenerate->setButtonClass('btn btn-default btn-sm');
        $action_onGenerate->setLabel("Documento");
        $action_onGenerate->setImage('far:file-pdf #000000');
        $action_onGenerate->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onGenerate);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['ClientePedidoVendaList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['ClientePedidoVendaList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['ClientePedidoVendaList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_atualizar);

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
        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Pedido","Pedidos de venda do cliente"]));
        }

        $container->add($panel);

        parent::add($container);

    }

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new PedidoVenda($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
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
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    public static function onShowCurtainFilters($param = null) 
    {
        try 
        {
            //code here

                        $filter = new self([]);

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';
            $btnClose->style = 'margin-right:10px;';
            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $filter->form->addHeaderWidget($btnClose);

            $page = new TPage();
            $page->setTargetContainer('adianti_right_panel');
            $page->setProperty('page-name', 'ClientePedidoVendaListSearch');
            $page->setProperty('page_name', 'ClientePedidoVendaListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClearFilters($param = null) 
    {
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    public function onRefresh($param = null) 
    {
        $this->onReload([]);
    }

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->cliente_id) AND ( (is_scalar($data->cliente_id) AND $data->cliente_id !== '') OR (is_array($data->cliente_id) AND (!empty($data->cliente_id)) )) )
        {

            $filters[] = new TFilter('cliente_id', '=', $data->cliente_id);// create the filter 
        }

        if (isset($data->vendedor_id) AND ( (is_scalar($data->vendedor_id) AND $data->vendedor_id !== '') OR (is_array($data->vendedor_id) AND (!empty($data->vendedor_id)) )) )
        {

            $filters[] = new TFilter('vendedor_id', '=', $data->vendedor_id);// create the filter 
        }

        if (isset($data->estado_pedido_venda_id) AND ( (is_scalar($data->estado_pedido_venda_id) AND $data->estado_pedido_venda_id !== '') OR (is_array($data->estado_pedido_venda_id) AND (!empty($data->estado_pedido_venda_id)) )) )
        {

            $filters[] = new TFilter('estado_pedido_venda_id', '=', $data->estado_pedido_venda_id);// create the filter 
        }

        if (isset($data->dt_pedido) AND ( (is_scalar($data->dt_pedido) AND $data->dt_pedido !== '') OR (is_array($data->dt_pedido) AND (!empty($data->dt_pedido)) )) )
        {

            $filters[] = new TFilter('dt_pedido', '>=', $data->dt_pedido);// create the filter 
        }

        if (isset($data->data_fina_pedido) AND ( (is_scalar($data->data_fina_pedido) AND $data->data_fina_pedido !== '') OR (is_array($data->data_fina_pedido) AND (!empty($data->data_fina_pedido)) )) )
        {

            $filters[] = new TFilter('dt_pedido', '<=', $data->data_fina_pedido);// create the filter 
        }

        $this->fireEvents($data);

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'minierp'
            TTransaction::open(self::$database);

            // creates a repository for PedidoVenda
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            //</blockLine><btnShowCurtainFiltersAutoCode>
            if(!empty($this->btnShowCurtainFilters) && empty($this->btnShowCurtainFiltersAdjusted))
            {
                $this->btnShowCurtainFiltersAdjusted = true;
                $this->btnShowCurtainFilters->style = 'position: relative';
                $countFilters = count($filters ?? []);
                $this->btnShowCurtainFilters->setLabel($this->btnShowCurtainFilters->getLabel(). "<span class='badge badge-success' style='position: absolute'>{$countFilters}<span>");
            }
            //</blockLine></btnShowCurtainFiltersAutoCode>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

}

