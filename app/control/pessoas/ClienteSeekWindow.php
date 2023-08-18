<?php

class ClienteSeekWindow extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'minierp';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'id';
    private static $formName = 'form_ClienteSeekWindow';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    use BuilderSeekWindowTrait;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        parent::setSize(0.8, null);
        parent::setTitle("Janela de busca de clientes");
        parent::setProperty('class', 'window_modal');

        $param['_seek_window_id'] = $this->getId();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 10;

        // define the form title
        $this->form->setFormTitle("Janela de busca de clientes");

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $documento = new TEntry('documento');
        $email = new TEntry('email');

        $nome->setMaxLength(500);
        $email->setMaxLength(255);
        $documento->setMaxLength(20);

        $id->setSize('100%');
        $nome->setSize('100%');
        $email->setSize('100%');
        $documento->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Documento:", null, '14px', null, '100%'),$documento],[new TLabel("Email:", null, '14px', null, '100%'),$email]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $this->setSeekParameters($btn_onsearch->getAction(), $param);

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = $this->getSeekFiltersCriteria($param);

        $filterVar = GrupoPessoa::CLIENTE;
        $this->filter_criteria->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')"));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_documento = new TDataGridColumn('documento', "Documento", 'left');
        $column_email = new TDataGridColumn('email', "Email", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $this->setSeekParameters($order_id, $param);
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_documento);
        $this->datagrid->addColumn($column_email);

        $action_onSelect = new TDataGridAction(array('ClienteSeekWindow', 'onSelect'));
        $action_onSelect->setUseButton(true);
        $action_onSelect->setButtonClass('btn btn-default btn-sm');
        $action_onSelect->setLabel("Selecionar");
        $action_onSelect->setImage('far:hand-pointer #44bd32');
        $action_onSelect->setField(self::$primaryKey);
        $this->setSeekParameters($action_onSelect, $param);

        $this->datagrid->addAction($action_onSelect);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $navigationAction = new TAction(array($this, 'onReload'));
        $this->setSeekParameters($navigationAction, $param);
        $this->pageNavigation->setAction($navigationAction);
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        parent::add($this->form);
        parent::add($panel);

    }

    public static function onSelect($param = null) 
    { 
        try 
        {   
            $seekFields = self::getSeekFields($param);
            $formData = new stdClass();

            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $repository = new TRepository(self::$activeRecord);

                $criteria = self::getSeekFiltersCriteria($param);

            $filterVar = GrupoPessoa::CLIENTE;
            $criteria->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')"));

                $criteria->add(new TFilter('id', '=', $param['key']));
                $objects = $repository->load($criteria);

                if($objects)
                {
                    $object = end($objects);
                    if($seekFields)
                    {
                        foreach ($seekFields as $seek_field) 
                        {

                            $formData->{"{$seek_field['name']}"} = $object->render("{$seek_field['column']}");
                        }
                    }
                }
                elseif($seekFields)
                {
                    foreach ($seekFields as $seek_field) 
                    {
                        $formData->{"{$seek_field['name']}"} = '';
                    }   
                }
                TTransaction::close();
            }
            else
            {
                if($seekFields)
                {
                    foreach ($seekFields as $seek_field) 
                    {
                        $formData->{"{$seek_field['name']}"} = '';
                    }   
                }
            }

            TForm::sendData($param['_form_name'], $formData);

            if(!empty($param['_seek_window_id']))
            {
                TWindow::closeWindow($param['_seek_window_id']);
            }
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
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }

        if (isset($data->documento) AND ( (is_scalar($data->documento) AND $data->documento !== '') OR (is_array($data->documento) AND (!empty($data->documento)) )) )
        {

            $filters[] = new TFilter('documento', 'like', "%{$data->documento}%");// create the filter 
        }

        if (isset($data->email) AND ( (is_scalar($data->email) AND $data->email !== '') OR (is_array($data->email) AND (!empty($data->email)) )) )
        {

            $filters[] = new TFilter('email', 'like', "%{$data->email}%");// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            AdiantiCoreApplication::loadPage($class, 'onReload', ['offset' => 0, 'first_page' => 1]);
        }
        else
        {
            $this->onReload(['offset' => 0, 'first_page' => 1]);
        }
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

            // creates a repository for Pessoa
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
                    // add the object inside the datagrid

                    $this->datagrid->addItem($object);

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

