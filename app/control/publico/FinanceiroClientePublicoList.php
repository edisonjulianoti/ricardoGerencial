<?php

class FinanceiroClientePublicoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'minierp';
    private static $activeRecord = 'Conta';
    private static $primaryKey = 'id';
    private static $formName = 'form_ContaReceberList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    private $filtrarContasAtrasadas = false;
    private $filtrarContasAbertas = false;
    private $filtrarContasQuitadas = false;

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
        $this->form->setFormTitle("Buscar");
        $this->limit = 20;

        if(!TSession::getValue('cliente_logado'))
        {
            new TMessage('info', 'Permissão negada! ', new TAction(['LoginClienteForm', 'onShow']));
            return false;
        }

        $forma_pagamento_id = new TDBCombo('forma_pagamento_id', 'minierp', 'FormaPagamento', 'id', '{nome}','nome asc'  );
        $dt_vencimento = new TDate('dt_vencimento');
        $data_vencimento_final = new TDate('data_vencimento_final');
        $filtros_rapidos = new TRadioGroup('filtros_rapidos');


        $forma_pagamento_id->enableSearch();
        $filtros_rapidos->addItems(["atrasadas"=>"Atrasadas","abertas"=>"Abertas","quitadas"=>"Quitadas"]);
        $filtros_rapidos->setLayout('horizontal');
        $filtros_rapidos->setUseButton();
        $dt_vencimento->setMask('dd/mm/yyyy');
        $data_vencimento_final->setMask('dd/mm/yyyy');

        $dt_vencimento->setDatabaseMask('yyyy-mm-dd');
        $data_vencimento_final->setDatabaseMask('yyyy-mm-dd');

        $dt_vencimento->setSize(110);
        $filtros_rapidos->setSize(120);
        $forma_pagamento_id->setSize('100%');
        $data_vencimento_final->setSize(110);


        $row1 = $this->form->addFields([new TLabel("Forma de pagamento:", null, '14px', null, '100%'),$forma_pagamento_id],[new TLabel("Data de vencimento:", null, '14px', null, '100%'),$dt_vencimento,new TLabel("até", null, '14px', null),$data_vencimento_final]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Filtros rápidos:", null, '14px', null, '100%'),$filtros_rapidos]);
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

        $filterVar = TipoConta::RECEBER;
        $this->filter_criteria->add(new TFilter('tipo_conta_id', '=', $filterVar));
        $filterVar = TSession::getValue('cliente_id');
        $this->filter_criteria->add(new TFilter('pessoa_id', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_forma_pagamento_nome = new TDataGridColumn('forma_pagamento->nome', "Forma pgto", 'left');
        $column_dt_emissao_transformed = new TDataGridColumn('dt_emissao', "Data de emissão", 'center');
        $column_dt_vencimento_transformed = new TDataGridColumn('dt_vencimento', "Data vcto", 'center');
        $column_dt_pagamento_transformed = new TDataGridColumn('dt_pagamento', "Data pgto", 'center');
        $column_valor_transformed = new TDataGridColumn('valor', "Valor", 'center');
        $column_parcela = new TDataGridColumn('parcela', "Parcela", 'center');
        $column_status = new TDataGridColumn('status', "Status", 'center');

        $column_dt_emissao_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_dt_vencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_dt_pagamento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->datagrid->addColumn($column_forma_pagamento_nome);
        $this->datagrid->addColumn($column_dt_emissao_transformed);
        $this->datagrid->addColumn($column_dt_vencimento_transformed);
        $this->datagrid->addColumn($column_dt_pagamento_transformed);
        $this->datagrid->addColumn($column_valor_transformed);
        $this->datagrid->addColumn($column_parcela);
        $this->datagrid->addColumn($column_status);


        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Meu Financeiro");
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

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['FinanceiroClientePublicoList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['FinanceiroClientePublicoList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['FinanceiroClientePublicoList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_atrasadas = new TButton('button_button_atrasadas');
        $button_atrasadas->setAction(new TAction(['FinanceiroClientePublicoList', 'onFiltrarAtrasadas']), "Atrasadas");
        $button_atrasadas->addStyleClass('btn-default');
        $button_atrasadas->setImage('fas:money-bill-wave #F44336');

        $this->datagrid_form->addField($button_atrasadas);

        $button_abertas = new TButton('button_button_abertas');
        $button_abertas->setAction(new TAction(['FinanceiroClientePublicoList', 'onFiltrarAbertas']), "Abertas");
        $button_abertas->addStyleClass('btn-default');
        $button_abertas->setImage('fas:money-bill-wave #FFC107');

        $this->datagrid_form->addField($button_abertas);

        $button_quitadas = new TButton('button_button_quitadas');
        $button_quitadas->setAction(new TAction(['FinanceiroClientePublicoList', 'onFiltrarQuitadas']), "Quitadas");
        $button_quitadas->addStyleClass('btn-default');
        $button_quitadas->setImage('fas:money-bill-wave #4CAF50');

        $this->datagrid_form->addField($button_quitadas);

        $head_left_actions->add($button_atualizar);
        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_atrasadas);
        $head_left_actions->add($button_abertas);
        $head_left_actions->add($button_quitadas);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Público","Financeiro do cliente público"]));
        }

        $container->add($panel);

        parent::add($container);

    }

    public function onRefresh($param = null) 
    {
        $this->onReload([]);
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
            $page->setProperty('page-name', 'FinanceiroClientePublicoListSearch');
            $page->setProperty('page_name', 'FinanceiroClientePublicoListSearch');
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
    public function onFiltrarAtrasadas($param = null) 
    {
        try 
        {
            $this->filtrarContasAtrasadas = true;
            $this->onSearch([]);
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onFiltrarAbertas($param = null) 
    {
        try 
        {
            $this->filtrarContasAbertas = true;
            $this->onSearch([]);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onFiltrarQuitadas($param = null) 
    {
        try 
        {
            $this->filtrarContasQuitadas = true;
            $this->onSearch([]);

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

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->forma_pagamento_id) AND ( (is_scalar($data->forma_pagamento_id) AND $data->forma_pagamento_id !== '') OR (is_array($data->forma_pagamento_id) AND (!empty($data->forma_pagamento_id)) )) )
        {

            $filters[] = new TFilter('forma_pagamento_id', '=', $data->forma_pagamento_id);// create the filter 
        }

        if (isset($data->dt_vencimento) AND ( (is_scalar($data->dt_vencimento) AND $data->dt_vencimento !== '') OR (is_array($data->dt_vencimento) AND (!empty($data->dt_vencimento)) )) )
        {

            $filters[] = new TFilter('dt_vencimento', '>=', $data->dt_vencimento);// create the filter 
        }

        if (isset($data->data_vencimento_final) AND ( (is_scalar($data->data_vencimento_final) AND $data->data_vencimento_final !== '') OR (is_array($data->data_vencimento_final) AND (!empty($data->data_vencimento_final)) )) )
        {

            $filters[] = new TFilter('dt_vencimento', '<=', $data->data_vencimento_final);// create the filter 
        }

        if($this->filtrarContasAtrasadas || $data->filtros_rapidos == 'atrasadas')
        {
            $data->filtros_rapidos = 'atrasadas';
            $filters[] = new TFilter('dt_vencimento', '<', date('Y-m-d'));
            $filters[] = new TFilter('dt_pagamento', 'is', NULL);
        }
        elseif($this->filtrarContasQuitadas || $data->filtros_rapidos == 'quitadas')
        {
            $data->filtros_rapidos = 'quitadas';
            $filters[] = new TFilter('dt_pagamento', 'is not', NULL);
        }
        elseif($this->filtrarContasAbertas || $data->filtros_rapidos == 'abertas')
        {
            $data->filtros_rapidos = 'abertas';
            $filters[] = new TFilter('dt_vencimento', '>=', date('Y-m-d'));
            $filters[] = new TFilter('dt_pagamento', 'is', NULL);
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

            // creates a repository for Conta
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

                    if($object->dt_pagamento)
                    {
                        unset($object->builder_datagrid_check);
                    }

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

