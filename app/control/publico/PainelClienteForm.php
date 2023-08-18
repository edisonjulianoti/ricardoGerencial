<?php

class PainelClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_PainelClienteForm';

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
        $this->form->setFormTitle("");

        if(!TSession::getValue('cliente_logado'))
        {
            new TMessage('info', 'Permissão negada! ', new TAction(['LoginClienteForm', 'onShow']));
            return false;
        }

        $h2 = new BElement('h2');
        $button_meus_pedidos = new TButton('button_meus_pedidos');
        $button_meu_financeiro = new TButton('button_meu_financeiro');
        $navegacao = new BPageContainer();


        $navegacao->setId('navegacao');
        $h2->setSize('100%', 80);
        $navegacao->setSize('100%');

        $button_meus_pedidos->addStyleClass('btn_links_area_cliente');
        $button_meu_financeiro->addStyleClass('btn_links_area_cliente');

        $button_meus_pedidos->setImage('fas:boxes #FFFFFF');
        $button_meu_financeiro->setImage('fas:money-bill-wave #FFFFFF');

        $navegacao->setAction(new TAction(['ClientePedidoVendaPublicoList', 'onShow']));
        $button_meus_pedidos->setAction(new TAction(['ClientePedidoVendaPublicoList', 'onShow'],["target_container" => "navegacao"]), "Meus Pedidos");
        $button_meu_financeiro->setAction(new TAction(['FinanceiroClientePublicoList', 'onShow'],["target_container" => "navegacao"]), "Meu Financeiro");

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $navegacao->add($loadingContainer);

        $this->h2 = $h2;
        $this->navegacao = $navegacao;

        $this->h2->add("Área do Cliente");
        $this->h2->style = 'text-align: center';

        $row1 = $this->form->addFields([$h2]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([],[$button_meus_pedidos],[$button_meu_financeiro]);
        $row2->layout = [' col-sm-2',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([$navegacao]);
        $row3->layout = [' col-sm-12'];

        // create the form actions

        $btn_onlogout = $this->form->addHeaderAction("Sair", new TAction([$this, 'onLogout']), 'fas:sign-out-alt #000000');
        $this->btn_onlogout = $btn_onlogout;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onLogout($param = null) 
    {
        try 
        {

            TSession::setValue('cliente_logado', false);
            TSession::setValue('cliente_id', null);

            TApplication::loadPage('LoginClienteForm', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

    } 

}

