<?php

class PedidoVendaKanbanFormView extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_PedidoVendaKanbanFormView';

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
        $this->form->setFormTitle("Kanban");

        $criteria_cliente_id = new TCriteria();
        $criteria_vendedor_id = new TCriteria();

        $filterVar = GrupoPessoa::CLIENTE;
        $criteria_cliente_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 
        $filterVar = GrupoPessoa::VENDEDOR;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $cliente_id = new TDBCombo('cliente_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_cliente_id );
        $vendedor_id = new TDBCombo('vendedor_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $mes = new TCombo('mes');
        $ano = new TCombo('ano');
        $button_buscar = new TButton('button_buscar');
        $kanban = new BPageContainer();


        $button_buscar->addStyleClass('btn-primary');
        $button_buscar->setImage('fas:search #EDE9E9');
        $kanban->setId('b628d6bf393bbe');
        $ano->addItems(TempoService::getAnos());
        $mes->addItems(TempoService::getMeses());

        $kanban->setAction(new TAction(['PedidoVendaKanbanView', 'onShow'], $param));
        $button_buscar->setAction(new TAction(['PedidoVendaKanbanFormView', 'onShow']), "Buscar");

        $mes->setValue($param['mes'] ?? null);
        $ano->setValue($param['ano'] ?? null);
        $cliente_id->setValue($param['cliente_id'] ?? null);
        $vendedor_id->setValue($param['vendedor_id'] ?? null);

        $mes->enableSearch();
        $ano->enableSearch();
        $cliente_id->enableSearch();
        $vendedor_id->enableSearch();

        $mes->setSize('100%');
        $ano->setSize('100%');
        $kanban->setSize('100%');
        $cliente_id->setSize('100%');
        $vendedor_id->setSize('100%');


        $this->kanban = $kanban;

        $row1 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null, '100%'),$cliente_id],[new TLabel("Vendedor:", null, '14px', null, '100%'),$vendedor_id],[new TLabel("Mês:", null, '14px', null, '100%'),$mes],[new TLabel("Ano:", null, '14px', null, '100%'),$ano],[$button_buscar]);
        $row1->layout = [' col-sm-3',' col-sm-3','col-sm-2','col-sm-2','col-sm-2'];

        $row2 = $this->form->addFields([$kanban]);
        $row2->layout = [' col-sm-12'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Pedido","Kanban"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

