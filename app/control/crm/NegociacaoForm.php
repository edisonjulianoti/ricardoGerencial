<?php

class NegociacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'Negociacao';
    private static $primaryKey = 'id';
    private static $formName = 'form_NegociacaoForm';

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
        $this->form->setFormTitle("Cadastro de negociação");

        $criteria_vendedor_id = new TCriteria();

        $filterVar = GrupoPessoa::VENDEDOR;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $id = new TEntry('id');
        $vendedor_id = new TDBCombo('vendedor_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $etapa_negociacao_id = new TDBCombo('etapa_negociacao_id', 'minierp', 'EtapaNegociacao', 'id', '{nome}','nome asc'  );
        $origem_contato_id = new TDBCombo('origem_contato_id', 'minierp', 'OrigemContato', 'id', '{nome}','nome asc'  );
        $data_inicio = new TDate('data_inicio');
        $data_fechamento_esperada = new TDate('data_fechamento_esperada');
        $cliente_id = new TSeekButton('cliente_id');
        $cliente_nome = new TEntry('cliente_nome');
        $cliente_documento = new TEntry('cliente_documento');
        $cliente_tipo_cliente_nome = new TEntry('cliente_tipo_cliente_nome');

        $vendedor_id->addValidation("vendedor", new TRequiredValidator()); 
        $etapa_negociacao_id->addValidation("Etapa", new TRequiredValidator()); 
        $origem_contato_id->addValidation("Origem do contato", new TRequiredValidator()); 
        $data_inicio->addValidation("Data de início", new TRequiredValidator()); 
        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 

        $data_inicio->setValue(date('d/m/Y'));
        $etapa_negociacao_id->setValue(EtapaNegociacao::PROSPECTAR);

        $data_inicio->setMask('dd/mm/yyyy');
        $data_fechamento_esperada->setMask('dd/mm/yyyy');

        $data_inicio->setDatabaseMask('yyyy-mm-dd');
        $data_fechamento_esperada->setDatabaseMask('yyyy-mm-dd');

        $vendedor_id->enableSearch();
        $origem_contato_id->enableSearch();
        $etapa_negociacao_id->enableSearch();

        $id->setEditable(false);
        $cliente_nome->setEditable(false);
        $cliente_documento->setEditable(false);
        $cliente_tipo_cliente_nome->setEditable(false);

        $id->setSize('100%');
        $cliente_id->setSize(100);
        $data_inicio->setSize(110);
        $vendedor_id->setSize('100%');
        $origem_contato_id->setSize('100%');
        $cliente_documento->setSize('100%');
        $etapa_negociacao_id->setSize('100%');
        $data_fechamento_esperada->setSize(110);
        $cliente_tipo_cliente_nome->setSize('100%');
        $cliente_nome->setSize('calc(100% - 120px)');

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $cliente_id_seekAction = new TAction(['ClienteSeekWindow', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'cliente_id', 'column'=>'{id}'],
            ['name'=> 'cliente_id', 'column'=>'{id}'],
            ['name'=> 'cliente_nome', 'column'=>'{nome}'],
            ['name'=> 'cliente_documento', 'column'=>'{documento}'],
            ['name'=> 'cliente_tipo_cliente_nome', 'column'=>'{tipo_cliente->nome}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $cliente_id_seekAction->setParameter('_seek_fields', $seekFields);
        $cliente_id_seekAction->setParameter('_seek_filters', $seekFilters);
        $cliente_id_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $cliente_id->setAction($cliente_id_seekAction);

        $row1 = $this->form->addContent([new TFormSeparator("Informações Gerais", '#333', '18', '#eee')]);
        $row2 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Vendedor:", '#ff0000', '14px', null, '100%'),$vendedor_id],[new TLabel("Etapa:", '#ff0000', '14px', null, '100%'),$etapa_negociacao_id]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Origem do contato:", '#ff0000', '14px', null, '100%'),$origem_contato_id],[new TLabel("Data de início:", '#ff0000', '14px', null, '100%'),$data_inicio],[new TLabel("Data esperada de fechamento:", null, '14px', null, '100%'),$data_fechamento_esperada]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addContent([new TFormSeparator("Informações do Cliente", '#333', '18', '#eee')]);
        $row5 = $this->form->addFields([new TLabel("Cliente:", '#ff0000', '14px', null, '100%'),$cliente_id,$cliente_nome],[new TLabel("Documento:", null, '14px', null),$cliente_documento],[new TLabel("Tipo do cliente:", null, '14px', null),$cliente_tipo_cliente_nome]);
        $row5->layout = ['col-sm-4',' col-sm-4',' col-sm-4'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['NegociacaoList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Negociacao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            if($data->id && !NegociacaoService::podeEditar($data->id))
            {
                throw new Exception('Não é possível editar esse registro!');
            }

            $object->store(); // save the object 

            if(!$data->id)
            {
                $negociacaoHistoricoEtapa = new NegociacaoHistoricoEtapa;
                $negociacaoHistoricoEtapa->etapa_negociacao_id = $object->etapa_negociacao_id;
                $negociacaoHistoricoEtapa->negociacao_id = $object->id;
                $negociacaoHistoricoEtapa->dt_etapa = date('Y-m-d H:i:s');
                $negociacaoHistoricoEtapa->store();
            }

            $this->fireEvents($object);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            if(!empty($object->id))
            {
                $loadPageParam["key"] = $object->id;
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('NegociacaoFormView', 'onShow', $loadPageParam); 

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

                $object = new Negociacao($key); // instantiates the Active Record 

                                $object->cliente_nome = $object->cliente->nome;
                $object->cliente_documento = $object->cliente->documento;
                $object->cliente_tipo_cliente_nome = $object->cliente->tipo_cliente->nome;

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->cliente_id))
            {
                $value = $object->cliente_id;

                $obj->cliente_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

}

