<?php

class ReajustePrecoLoteProdutoList extends TPage
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
        $this->form->setFormTitle("Reajuste de preço em lote");
        $this->limit = 0;

        $criteria_fornecedor_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $familia_produto_id = new TDBCombo('familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $fabricante_id = new TDBCombo('fabricante_id', 'minierp', 'Fabricante', 'id', '{nome}','nome asc'  );
        $fornecedor_id = new TDBUniqueSearch('fornecedor_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_fornecedor_id );
        $percentual_reajuste = new TNumeric('percentual_reajuste', '2', ',', '.' );


        $fornecedor_id->setMinLength(2);
        $fornecedor_id->setMask('{nome} - {documento}');
        $fornecedor_id->setFilterColumns(["documento","nome"]);
        $fabricante_id->enableSearch();
        $tipo_produto_id->enableSearch();
        $familia_produto_id->enableSearch();

        $fabricante_id->setSize('100%');
        $fornecedor_id->setSize('100%');
        $tipo_produto_id->setSize('100%');
        $familia_produto_id->setSize('100%');
        $percentual_reajuste->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Tipo de produto:", null, '14px', null, '100%'),$tipo_produto_id],[new TLabel("Família de produto:", null, '14px', null, '100%'),$familia_produto_id],[new TLabel("Fabricante:", null, '14px', null, '100%'),$fabricante_id],[new TLabel("Fornecedor:", null, '14px', null, '100%'),$fornecedor_id]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Percentual de reajuste:", null, '14px', null, '100%'),$percentual_reajuste]);
        $row2->layout = ['col-sm-6'];

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

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_familia_produto_nome = new TDataGridColumn('familia_produto->nome', "Família de produto", 'left');
        $column_tipo_produto_nome = new TDataGridColumn('tipo_produto->nome', "Tipo de produto", 'left');
        $column_fornecedor_nome = new TDataGridColumn('fornecedor->nome', "Fornecedor", 'left');
        $column_fabricante_nome = new TDataGridColumn('fabricante->nome', "Fabricante", 'left');
        $column_qtde_estoque = new TDataGridColumn('qtde_estoque', "Qtde estoque", 'left');
        $column_preco_venda_transformed = new TDataGridColumn('preco_venda', "Preço venda", 'left');
        $column_preco_reajustado_transformed = new TDataGridColumn('preco_reajustado', "Preço reajustado", 'left');
        $column_data_ultimo_reajuste_preco_transformed = new TDataGridColumn('data_ultimo_reajuste_preco', "Ultimo reajuste preço", 'center');

        $column_preco_venda_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_preco_reajustado_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->builder_datagrid_check_all = new TCheckButton('builder_datagrid_check_all');
        $this->builder_datagrid_check_all->setIndexValue('on');
        $this->builder_datagrid_check_all->onclick = "Builder.checkAll(this)";
        $this->builder_datagrid_check_all->style = 'cursor:pointer';
        $this->builder_datagrid_check_all->setProperty('class', 'filled-in');
        $this->builder_datagrid_check_all->id = 'builder_datagrid_check_all';

        $label = new TLabel('');
        $label->style = 'margin:0';
        $label->class = 'checklist-label';
        $this->builder_datagrid_check_all->after($label);
        $label->for = 'builder_datagrid_check_all';

        $this->builder_datagrid_check = $this->datagrid->addColumn( new TDataGridColumn('builder_datagrid_check', $this->builder_datagrid_check_all, 'center',  '1%') );

        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_familia_produto_nome);
        $this->datagrid->addColumn($column_tipo_produto_nome);
        $this->datagrid->addColumn($column_fornecedor_nome);
        $this->datagrid->addColumn($column_fabricante_nome);
        $this->datagrid->addColumn($column_qtde_estoque);
        $this->datagrid->addColumn($column_preco_venda_transformed);
        $this->datagrid->addColumn($column_preco_reajustado_transformed);
        $this->datagrid->addColumn($column_data_ultimo_reajuste_preco_transformed);


        // create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

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

        $button_reajustes_precos = new TButton('button_button_reajustes_precos');
        $button_reajustes_precos->setAction(new TAction(['ReajustePrecoLoteProdutoList', 'onReajustePreco']), "Reajustes Preços");
        $button_reajustes_precos->addStyleClass('btn-default');
        $button_reajustes_precos->setImage('fas:money-bill-wave-alt #4CAF50');
        $button_reajustes_precos->getAction()->setParameter("percentual_reajuste", $param["percentual_reajuste"] ?? "");

        $this->datagrid_form->addField($button_reajustes_precos);

        $head_left_actions->add($button_reajustes_precos);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Estoque","Reajuste de preço em lote"]));
        }
        $container->add($this->form);

        $container->add($panel);

        parent::add($container);

    }

    public static function onReajustePreco($param = null) 
    {
        try 
        {

            if(!empty($param['percentual_reajuste']))
            {
                $percentual_reajuste = $param['percentual_reajuste'];

                if($param['builder_datagrid_check'])
                {
                    TTransaction::open(self::$database);
                    foreach($param['builder_datagrid_check'] as $produto_id)
                    {
                        $produto = Produto::find($produto_id);

                        if($produto)
                        {
                            // 1.500,00 => 1500.00
                            $percentual_reajuste = (double) str_replace(['.', ','],['', '.'], $param['percentual_reajuste']);

                            $produto->preco_venda = $produto->preco_venda * (1 + $percentual_reajuste / 100);
                            $produto->data_ultimo_reajuste_preco = date('Y-m-d H:i:s');
                            $produto->store();
                        }
                    }
                    TTransaction::close();

                    new TMessage('info', 'Preços ajustados.', new TAction(['ReajustePrecoLoteProdutoList', 'onShow']));

                }
                else
                {
                    throw new Exception('Escolha ao menos um produto para ter o preço reajustado');
                }
            }
            else
            {
                throw new Exception('O percentual de reajuste de preço não foi informado');
            }

            //</autoCode>
        }
        catch (Exception $e) 
        {
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

        if(!$data->percentual_reajuste)
        {
            new TMessage('error', 'O percentual de reajuste é obrigatório!');
            return false;
        }

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->tipo_produto_id) AND ( (is_scalar($data->tipo_produto_id) AND $data->tipo_produto_id !== '') OR (is_array($data->tipo_produto_id) AND (!empty($data->tipo_produto_id)) )) )
        {

            $filters[] = new TFilter('tipo_produto_id', '=', $data->tipo_produto_id);// create the filter 
        }

        if (isset($data->familia_produto_id) AND ( (is_scalar($data->familia_produto_id) AND $data->familia_produto_id !== '') OR (is_array($data->familia_produto_id) AND (!empty($data->familia_produto_id)) )) )
        {

            $filters[] = new TFilter('familia_produto_id', '=', $data->familia_produto_id);// create the filter 
        }

        if (isset($data->fabricante_id) AND ( (is_scalar($data->fabricante_id) AND $data->fabricante_id !== '') OR (is_array($data->fabricante_id) AND (!empty($data->fabricante_id)) )) )
        {

            $filters[] = new TFilter('fabricante_id', '=', $data->fabricante_id);// create the filter 
        }

        if (isset($data->fornecedor_id) AND ( (is_scalar($data->fornecedor_id) AND $data->fornecedor_id !== '') OR (is_array($data->fornecedor_id) AND (!empty($data->fornecedor_id)) )) )
        {

            $filters[] = new TFilter('fornecedor_id', '=', $data->fornecedor_id);// create the filter 
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
            if (empty($_REQUEST['method']) || ($_REQUEST['method'] == 'onShow'))
            {
                return;
            }
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

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $check = new TCheckButton('builder_datagrid_check[]');
                    $check->setIndexValue($object->id);
                    $check->onclick = 'event.stopPropagation();';
                    $object->builder_datagrid_check = $check;

                    if(!empty($_REQUEST['percentual_reajuste']))
                    {
                        $check->setValue($object->id);
                        $percentual_reajuste = (double) str_replace(['.', ','],['', '.'], $_REQUEST['percentual_reajuste']);

                        $object->preco_reajustado = $object->preco_venda * (1 + $percentual_reajuste / 100);    
                    }
                    else
                    {
                        $object->preco_reajustado = $object->preco_venda;
                    }

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

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

