<?php

class BuscaKanbanNegociacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_BuscaKanbanNegociacaoForm';

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
        $this->form->setFormTitle("Kanban de negociações");

        $criteria_cliente_id = new TCriteria();
        $criteria_vendedor_id = new TCriteria();

        $filterVar = GrupoPessoa::CLIENTE;
        $criteria_cliente_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 
        $filterVar = GrupoPessoa::VENDEDOR;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $cliente_id = new TDBUniqueSearch('cliente_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_cliente_id );
        $vendedor_id = new TDBUniqueSearch('vendedor_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_vendedor_id );
        $origem_contato_id = new TDBCombo('origem_contato_id', 'minierp', 'OrigemContato', 'id', '{nome}','nome asc'  );
        $button_buscar = new TButton('button_buscar');
        $kanban = new BPageContainer();


        $origem_contato_id->enableSearch();
        $button_buscar->addStyleClass('btn-primary');
        $button_buscar->setImage('fas:search #F9F5F5');
        $kanban->setId('b635b12fd7c255');
        $cliente_id->setMinLength(2);
        $vendedor_id->setMinLength(2);

        $cliente_id->setMask('{nome}');
        $vendedor_id->setMask('{nome}');

        $cliente_id->setFilterColumns(["nome"]);
        $vendedor_id->setFilterColumns(["nome"]);

        $kanban->setAction(new TAction(['NegociacaoKanbanView', 'onShow'], $param));
        $button_buscar->setAction(new TAction(['BuscaKanbanNegociacaoForm', 'onShow']), "Buscar");

        $cliente_id->setValue($param["cliente_id"] ?? "");
        $vendedor_id->setValue($param["vendedor_id"] ?? "");
        $origem_contato_id->setValue($param["origem_contato_id"] ?? "");

        $kanban->setSize('100%');
        $cliente_id->setSize('100%');
        $vendedor_id->setSize('100%');
        $origem_contato_id->setSize('100%');

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $kanban->add($loadingContainer);

        $this->kanban = $kanban;

        $row1 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null, '100%'),$cliente_id],[new TLabel("Vendedor:", null, '14px', null),$vendedor_id],[new TLabel("Origem do contato:", null, '14px', null, '100%'),$origem_contato_id],[new TLabel(" ", null, '14px', null, '100%'),$button_buscar]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([$kanban]);
        $row2->layout = [' col-sm-12'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["CRM","Kanban"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

