<?php

class ProdutoCardList extends TPage
{
    private $form; // form
    private $cardView; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'minierp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_ProdutoCardList';
    private $showMethods = ['onReload', 'onSearch'];

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Cards de Produtos");

        $criteria_fornecedor_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $nome = new TEntry('nome');
        $cod_barras = new TEntry('cod_barras');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $familia_produto_id = new TDBCombo('familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $fornecedor_id = new TDBUniqueSearch('fornecedor_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_fornecedor_id );
        $fabricante_id = new TDBCombo('fabricante_id', 'minierp', 'Fabricante', 'id', '{nome}','nome asc'  );

        $fornecedor_id->setMinLength(0);
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



        $row1 = $this->form->addFields([new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Código de barras", null, '14px', null, '100%'),$cod_barras],[new TLabel("Tipo de produto:", null, '14px', null, '100%'),$tipo_produto_id],[new TLabel("Família de produto:", null, '14px', null, '100%'),$familia_produto_id]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Fornecedor:", null, '14px', null, '100%'),$fornecedor_id],[new TLabel("Fabricante:", null, '14px', null, '100%'),$fabricante_id]);
        $row2->layout = [' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $startHidden = true;

        if(TSession::getValue('ProdutoCardList_expand_start_hidden') === false)
        {
            $startHidden = false;
        }
        elseif(TSession::getValue('ProdutoCardList_expand_start_hidden') === true)
        {
            $startHidden = true; 
        }
        $expandButton = $this->form->addExpandButton("Expandir", 'fas:expand #000000', $startHidden);
        $expandButton->addStyleClass('btn-default');
        $expandButton->setAction(new TAction([$this, 'onExpandForm'], ['static'=>1]), "Expandir");
        $this->form->addField($expandButton);

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['ProdutoForm', 'onShow']), 'fas:plus #69aa46');
        $this->btn_onshow = $btn_onshow;

        $this->cardView = new TCardView;

        $this->cardView->setContentHeight(170);
        $this->cardView->setTitleTemplate('#{id} - {nome}');
        $this->cardView->setItemTemplate("<div class=\"media\">
  <img style='width: 100px;'src=\"{foto}\" class=\"mr-3\">
  <div class=\"media-body\">
    <h5 class=\"mt-0\">Preço de venda</h5>
    <p> {preco_venda}</p>
  </div>
</div> ");

        $this->cardView->setItemDatabase(self::$database);

        $this->filter_criteria = new TCriteria;

        $action_ProdutoForm_onEdit = new TAction(['ProdutoForm', 'onEdit'], ['key'=> '{id}']);

        $this->cardView->addAction($action_ProdutoForm_onEdit, "Editar", 'far:edit #478fca', null, "Editar", false); 

        $action_ProdutoCardList_onDelete = new TAction(['ProdutoCardList', 'onDelete'], ['key'=> '{id}']);

        $this->cardView->addAction($action_ProdutoCardList_onDelete, "Excluir", 'fas:trash-alt #dd5a43', null, "Excluir", false); 

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));

        $panel = new TPanelGroup;
        $panel->add($this->cardView);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Estoque","Cards de Produtos"]));
        $container->add($this->form);
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
                $object = new Produto($key, FALSE); 

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

        $param = array();
        $param['offset']     = 0;
        $param['first_page'] = 1;

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload($param);
    }

    public function onReload($param = NULL)
    {
        try
        {

            // open a transaction with database 'minierp'
            TTransaction::open(self::$database);

            // creates a repository for Produto
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

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
            $criteria->setProperty('limit', $limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->cardView->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $object->preco_venda = call_user_func(function($value, $object, $row) 
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
                    }, $object->preco_venda, $object, null);

                    $this->cardView->addItem($object);

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

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

    public static function onExpandForm($param = null)
    {
        try
        {
            $startHidden = true;

            if(TSession::getValue('ProdutoCardList_expand_start_hidden') === false)
            {
                TSession::setValue('ProdutoCardList_expand_start_hidden', true);
            }
            elseif(TSession::getValue('ProdutoCardList_expand_start_hidden') === true)
            {
                TSession::setValue('ProdutoCardList_expand_start_hidden', false);
            }
            else
            {
                TSession::setValue('ProdutoCardList_expand_start_hidden', !$startHidden);
            }

        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

}

