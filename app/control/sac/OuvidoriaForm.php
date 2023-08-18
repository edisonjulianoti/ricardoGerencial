<?php

class OuvidoriaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'Ouvidoria';
    private static $primaryKey = 'id';
    private static $formName = 'form_OuvidoriaForm';

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
        $this->form->setFormTitle("Cadastro de ouvidoria");


        $id = new TEntry('id');
        $tipo_ouvidoria_id = new TDBCombo('tipo_ouvidoria_id', 'minierp', 'TipoOuvidoria', 'id', '{nome}','nome asc'  );
        $nome = new TEntry('nome');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        $mensagem = new TEntry('mensagem');
        $created_at = new TDateTime('created_at');
        $updated_at = new TDateTime('updated_at');
        $deleted_at = new TDateTime('deleted_at');

        $tipo_ouvidoria_id->addValidation("Tipo ouvidoria id", new TRequiredValidator()); 
        $mensagem->addValidation("Mensagem", new TRequiredValidator()); 

        $id->setEditable(false);
        $tipo_ouvidoria_id->enableSearch();
        $created_at->setMask('dd/mm/yyyy hh:ii');
        $updated_at->setMask('dd/mm/yyyy hh:ii');
        $deleted_at->setMask('dd/mm/yyyy hh:ii');

        $created_at->setDatabaseMask('yyyy-mm-dd hh:ii');
        $updated_at->setDatabaseMask('yyyy-mm-dd hh:ii');
        $deleted_at->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $nome->setSize('100%');
        $email->setSize('100%');
        $created_at->setSize(150);
        $updated_at->setSize(150);
        $deleted_at->setSize(150);
        $telefone->setSize('100%');
        $mensagem->setSize('100%');
        $tipo_ouvidoria_id->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Tipo ouvidoria id:", '#ff0000', '14px', null, '100%'),$tipo_ouvidoria_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Telefone:", null, '14px', null, '100%'),$telefone]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Email:", null, '14px', null, '100%'),$email],[new TLabel("Mensagem:", '#ff0000', '14px', null, '100%'),$mensagem]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Criado em:", null, '14px', null, '100%'),$created_at],[new TLabel("Atualizado em:", null, '14px', null, '100%'),$updated_at]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Excluído em:", null, '14px', null, '100%'),$deleted_at],[]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['OuvidoriaHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Ouvidoria(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

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
            TApplication::loadPage('OuvidoriaHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Ouvidoria($key); // instantiates the Active Record 

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

