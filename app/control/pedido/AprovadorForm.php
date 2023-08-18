<?php

class AprovadorForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'Aprovador';
    private static $primaryKey = 'id';
    private static $formName = 'form_AprovadorForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de aprovador");


        $id = new TEntry('id');
        $system_user_id = new TDBCombo('system_user_id', 'minierp', 'SystemUsers', 'id', '{name}','name asc'  );
        $estados_pedido_venda = new TDBCheckGroup('estados_pedido_venda', 'minierp', 'EstadoPedidoVenda', 'id', '{nome}','nome asc'  );

        $system_user_id->addValidation("Usuário", new TRequiredValidator()); 

        $id->setEditable(false);
        $system_user_id->enableSearch();
        $estados_pedido_venda->setLayout('horizontal');
        $estados_pedido_venda->setBreakItems(1);
        $id->setSize('100%');
        $system_user_id->setSize('100%');
        $estados_pedido_venda->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Usuário:", '#ff0000', '14px', null, '100%'),$system_user_id]);
        $row1->layout = [' col-sm-2',' col-sm-10'];

        $row2 = $this->form->addFields([new TFormSeparator("Estados disponíveis", '#333', '18', '#eee')]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([$estados_pedido_venda]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['AprovadorHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Aprovador(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $repository = EstadoPedidoVendaAprovador::where('aprovador_id', '=', $object->id);
            $repository->delete(); 

            if ($data->estados_pedido_venda) 
            {
                foreach ($data->estados_pedido_venda as $estados_pedido_venda_value) 
                {
                    $estado_pedido_venda_aprovador = new EstadoPedidoVendaAprovador;

                    $estado_pedido_venda_aprovador->estado_pedido_venda_id = $estados_pedido_venda_value;
                    $estado_pedido_venda_aprovador->aprovador_id = $object->id;
                    $estado_pedido_venda_aprovador->store();
                }
            }

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('AprovadorHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Aprovador($key); // instantiates the Active Record 

                $object->estados_pedido_venda = EstadoPedidoVendaAprovador::where('aprovador_id', '=', $object->id)->getIndexedArray('estado_pedido_venda_id', 'estado_pedido_venda_id');

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

}

