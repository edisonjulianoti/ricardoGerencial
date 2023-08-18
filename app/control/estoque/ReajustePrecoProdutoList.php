<?php

class ReajustePrecoProdutoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'minierp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_ProdutoList';
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
        $this->form->setFormTitle("Busca");
        $this->limit = 20;

        $criteria_fornecedor_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $nome = new TEntry('nome');
        $cod_barras = new TEntry('cod_barras');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $familia_produto_id = new TDBCombo('familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $fornecedor_id = new TDBUniqueSearch('fornecedor_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_fornecedor_id );
        $fabricante_id = new TDBCombo('fabricante_id', 'minierp', 'Fabricante', 'id', '{nome}','nome asc'  );


        $fornecedor_id->setMinLength(2);
        $fornecedor_id->setMask('{nome} - {documento}');
        $fornecedor_id->setFilterColumns(["documento","nome"]);
        $nome->setMaxLength(255);
        $cod_barras->setMaxLength(255);

        $fabricante_id->enableSearch();
        $tipo_produto_id->enableSearch();
        $familia_produto_id->enableSearch();

        $nome->setSize('100%');
        $cod_barras->setSize('100%');
        $fornecedor_id->setSize('100%');
        $fabricante_id->setSize('100%');
        $tipo_produto_id->setSize('100%');
        $familia_produto_id->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Código de barras:", null, '14px', null, '100%'),$cod_barras]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Tipo de produto:", null, '14px', null, '100%'),$tipo_produto_id],[new TLabel("Família de produto:", null, '14px', null, '100%'),$familia_produto_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Fornecedor:", null, '14px', null, '100%'),$fornecedor_id],[new TLabel("Fabricante:", null, '14px', null, '100%'),$fabricante_id]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

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

        $filterVar = "T";
        $this->filter_criteria->add(new TFilter('ativo', '=', $filterVar));

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_familia_produto_nome = new TDataGridColumn('familia_produto->nome', "Família de produto", 'left');
        $column_tipo_produto_nome = new TDataGridColumn('tipo_produto->nome', "Tipo de produto", 'left');
        $column_fornecedor_nome = new TDataGridColumn('fornecedor->nome', "Fornecedor", 'left');
        $column_fabricante_nome = new TDataGridColumn('fabricante->nome', "Fabricante", 'left');
        $column_qtde_estoque = new TDataGridColumn('qtde_estoque', "Qtde estoque", 'left');
        $column_preco_venda = new TDataGridColumn('preco_venda', "Preço venda", 'left');
        $column_data_ultimo_reajuste_preco_transformed = new TDataGridColumn('data_ultimo_reajuste_preco', "Ultimo reajuste preço", 'center');

        $column_data_ultimo_reajuste_preco_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y H:i');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });        

        $column_preco_venda->setTransformer( function($value, $object, $row) {

            $pk = $object->getPrimaryKey();

            $preco_venda = new TNumeric($object->$pk.'_'.'preco_venda', '2', ',', '.' );
            $preco_venda->setSize('100%');

            $preco_venda->setFormName(self::$formName);
            $preco_venda->setValue($value);
            $action = new TAction( [$this, 'onSaveInline'] );
            $action->setParameter('column', 'preco_venda');
            $action->setParameter('_builder_field_options', base64_encode(serialize([
                'thousandSeparator' => '.',
                'decimalSeparator' => ',',
                'component' => 'TNumeric'
            ])));

            $preco_venda->setExitAction( $action );

            return $preco_venda;
        });

        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_familia_produto_nome);
        $this->datagrid->addColumn($column_tipo_produto_nome);
        $this->datagrid->addColumn($column_fornecedor_nome);
        $this->datagrid->addColumn($column_fabricante_nome);
        $this->datagrid->addColumn($column_qtde_estoque);
        $this->datagrid->addColumn($column_preco_venda);
        $this->datagrid->addColumn($column_data_ultimo_reajuste_preco_transformed);


        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Reajuste de preço de produto");
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
        $btnShowCurtainFilters->setAction(new TAction(['ReajustePrecoProdutoList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['ReajustePrecoProdutoList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['ReajustePrecoProdutoList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_atualizar);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Estoque","Reajuste de preço individual"]));
        }

        $container->add($panel);

        parent::add($container);

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
            $page->setProperty('page-name', 'ReajustePrecoProdutoListSearch');
            $page->setProperty('page_name', 'ReajustePrecoProdutoListSearch');
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

    public static function onSaveInline($param)
    {
        $name   = $param['_field_name'];
        $value  = $param['_field_value'];
        $column = $param['column'];
        $parts  = explode('_', $name);
        $id     = $parts[0];

        if(!empty($param['_builder_field_options']))
        {
            $field_options = unserialize(base64_decode($param['_builder_field_options']));
            if(!empty($field_options['component']) && $field_options['component'] == 'TDate' && !empty($value) && $field_options['viewMask'] != $field_options['databaseMask'])
            {
                $value = TDate::convertToMask($value, $field_options['viewMask'], $field_options['databaseMask']);
            }
            elseif(!empty($field_options['component']) && $field_options['component'] == 'TDateTime' && !empty($value) && $field_options['viewMask'] != $field_options['databaseMask'])
            {
                $value = TDateTime::convertToMask($value, $field_options['viewMask'], $field_options['databaseMask']);
            }
            elseif(!empty($field_options['component']) && $field_options['component'] == 'TNumeric' && !empty($value))
            {
                $value = str_replace( $field_options['thousandSeparator'], '', $value);
                $value = str_replace( $field_options['decimalSeparator'], '.', $value);
            }
        }

        try
        {
            // open transaction
            TTransaction::open(self::$database);
            $class = self::$activeRecord;

            $object = $class::find($id);
            if ($object)
            {
                $object->$column = $value;

                if($column == 'preco_venda')
                {
                    $object->data_ultimo_reajuste_preco = date('Y-m-d H:i:s');
                }

                $object->store();

            }

            // close transaction
            TTransaction::close();
        }
        catch (Exception $e)
        {
            // show the exception message
            new TMessage('error', $e->getMessage());
        }
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

        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }

        if (isset($data->cod_barras) AND ( (is_scalar($data->cod_barras) AND $data->cod_barras !== '') OR (is_array($data->cod_barras) AND (!empty($data->cod_barras)) )) )
        {

            $filters[] = new TFilter('cod_barras', 'like', "%{$data->cod_barras}%");// create the filter 
        }

        if (isset($data->tipo_produto_id) AND ( (is_scalar($data->tipo_produto_id) AND $data->tipo_produto_id !== '') OR (is_array($data->tipo_produto_id) AND (!empty($data->tipo_produto_id)) )) )
        {

            $filters[] = new TFilter('tipo_produto_id', '=', $data->tipo_produto_id);// create the filter 
        }

        if (isset($data->familia_produto_id) AND ( (is_scalar($data->familia_produto_id) AND $data->familia_produto_id !== '') OR (is_array($data->familia_produto_id) AND (!empty($data->familia_produto_id)) )) )
        {

            $filters[] = new TFilter('familia_produto_id', '=', $data->familia_produto_id);// create the filter 
        }

        if (isset($data->fornecedor_id) AND ( (is_scalar($data->fornecedor_id) AND $data->fornecedor_id !== '') OR (is_array($data->fornecedor_id) AND (!empty($data->fornecedor_id)) )) )
        {

            $filters[] = new TFilter('fornecedor_id', '=', $data->fornecedor_id);// create the filter 
        }

        if (isset($data->fabricante_id) AND ( (is_scalar($data->fabricante_id) AND $data->fabricante_id !== '') OR (is_array($data->fabricante_id) AND (!empty($data->fabricante_id)) )) )
        {

            $filters[] = new TFilter('fabricante_id', '=', $data->fabricante_id);// create the filter 
        }

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

            // creates a repository for Produto
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

