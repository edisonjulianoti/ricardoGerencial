<?php

class LoginClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_LoginClienteForm';

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
        $this->form->setFormTitle("Área do Cliente - Faça o seu login");

        if(TSession::getValue('cliente_logado'))
        {
            TApplication::loadPage('PainelClienteForm', 'onShow');
            return true;
        }

        $login = new TEntry('login');
        $senha = new TPassword('senha');

        $login->addValidation("Login", new TRequiredValidator()); 
        $senha->addValidation("Senha", new TRequiredValidator()); 

        $login->setSize('100%');
        $senha->setSize('100%');

        $login->setInnerIcon(new TImage('fas:user #000000'), 'left');
        $senha->setInnerIcon(new TImage('fas:lock #000000'), 'left');

        $row1 = $this->form->addFields([new TLabel("Login", null, '14px', null, '100%'),$login]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Senha:", null, '14px', null, '100%'),$senha]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onlogin = $this->form->addAction("ENTRAR", new TAction([$this, 'onLogin']), ' #ffffff');
        $this->btn_onlogin = $btn_onlogin;
        $btn_onlogin->addStyleClass('btn_area_cliente'); 

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

    public function onLogin($param = null) 
    {
        try
        {
            $this->form->validate();

            $data = $this->form->getData();

            TTransaction::open('minierp');

            $pessoa = Pessoa::where('login', '=', $data->login)->where('senha', '=', md5($data->senha))->first();

            TTransaction::close();

            if(!$pessoa)
            {
                throw new Exception('Login ou senha incorretos!');
            }

            TSession::setValue('cliente_logado', true);
            TSession::setValue('cliente_id', $pessoa->id);

            TApplication::loadPage('PainelClienteForm', 'onShow');
        }
        catch (Exception $e)
        {
            TSession::setValue('cliente_logado', false);
            TSession::setValue('cliente_id', null);

            $this->form->setData($this->form->getData());
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

}

