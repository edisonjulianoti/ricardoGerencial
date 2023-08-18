<?php

class EtapaNegociacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'EtapaNegociacao';
    private static $primaryKey = 'id';
    private static $formName = 'form_EtapaNegociacaoForm';

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
        $this->form->setFormTitle("Cadastro de etapa de negociação");


        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cor = new TColor('cor');
        $ordem = new TEntry('ordem');
        $kanban = new TRadioGroup('kanban');
        $permite_edicao = new TRadioGroup('permite_edicao');
        $permite_exclusao = new TRadioGroup('permite_exclusao');
        $roteiro = new THtmlEditor('roteiro');


        $id->setEditable(false);
        $kanban->addItems(["T"=>"Sim","F"=>"Não"]);
        $permite_edicao->addItems(["T"=>"Sim","F"=>"Não"]);
        $permite_exclusao->addItems(["T"=>"Sim","F"=>"Não"]);

        $kanban->setLayout('horizontal');
        $permite_edicao->setLayout('horizontal');
        $permite_exclusao->setLayout('horizontal');

        $kanban->setUseButton();
        $permite_edicao->setUseButton();
        $permite_exclusao->setUseButton();

        $id->setSize(100);
        $cor->setSize(100);
        $nome->setSize('100%');
        $ordem->setSize('100%');
        $kanban->setSize('100%');
        $roteiro->setSize('100%', 200);
        $permite_edicao->setSize('100%');
        $permite_exclusao->setSize('100%');



        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", null, '14px', null, '100%'),$nome]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Cor:", null, '14px', null, '100%'),$cor],[new TLabel("Ordem:", null, '14px', null, '100%'),$ordem]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Kanban:", null, '14px', null, '100%'),$kanban],[new TLabel("Permite edicao:", null, '14px', null, '100%'),$permite_edicao],[new TLabel("Permite exclusao:", null, '14px', null, '100%'),$permite_exclusao]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([new TLabel("Roteiro:", null, '14px', null, '100%'),$roteiro]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['EtapaNegociacaoHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new EtapaNegociacao(); // create an empty object 

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
            TApplication::loadPage('EtapaNegociacaoHeaderList', 'onShow', $loadPageParam); 

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

                $object = new EtapaNegociacao($key); // instantiates the Active Record 

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

