<?php

class NegociacaoItemForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'NegociacaoItem';
    private static $primaryKey = 'id';
    private static $formName = 'form_NegociacaoItemForm';

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
        $this->form->setFormTitle("Cadastro de item de negociação");


        $id = new TEntry('id');
        $negociacao_id = new THidden('negociacao_id');
        $produto_tipo_produto_id = new TDBCombo('produto_tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $produto_id = new TCombo('produto_id');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $quantidade = new TNumeric('quantidade', '2', ',', '.' );
        $valor_total = new TNumeric('valor_total', '2', ',', '.' );

        $produto_tipo_produto_id->setChangeAction(new TAction([$this,'onChangeproduto_tipo_produto_id']));
        $produto_id->setChangeAction(new TAction([$this,'onChangeProduto']));

        $valor->setExitAction(new TAction([$this,'onExitValor']));
        $quantidade->setExitAction(new TAction([$this,'onExitQuantidade']));

        $produto_id->addValidation("Produto", new TRequiredValidator()); 

        $negociacao_id->setValue(TSession::getValue('negociacao_id'));
        $id->setEditable(false);
        $valor_total->setEditable(false);

        $produto_id->enableSearch();
        $produto_tipo_produto_id->enableSearch();

        $id->setSize(100);
        $valor->setSize('100%');
        $negociacao_id->setSize(200);
        $produto_id->setSize('100%');
        $quantidade->setSize('100%');
        $valor_total->setSize('100%');
        $produto_tipo_produto_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id,$negociacao_id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Tipo do produto:", '#FF0000', '14px', null, '100%'),$produto_tipo_produto_id],[new TLabel("Produto:", '#ff0000', '14px', null, '100%'),$produto_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Valor:", null, '14px', null, '100%'),$valor],[new TLabel("Quantidade:", null, '14px', null, '100%'),$quantidade]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Valor total:", null, '14px', null, '100%'),$valor_total]);
        $row4->layout = ['col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['NegociacaoItemHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

    public static function onChangeproduto_tipo_produto_id($param)
    {
        try
        {

            if (isset($param['produto_tipo_produto_id']) && $param['produto_tipo_produto_id'])
            { 
                $criteria = TCriteria::create(['tipo_produto_id' => $param['produto_tipo_produto_id']]);
                TDBCombo::reloadFromModel(self::$formName, 'produto_id', 'minierp', 'Produto', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'produto_id'); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    } 

    public static function onExitValor($param = null) 
    {
        try 
        {
            self::onExitQuantidade($param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onExitQuantidade($param = null) 
    {
        try 
        {

            if(!empty($param['quantidade']) && !empty($param['valor']))
            {
                $quantidade = (double) str_replace(',', '.', str_replace('.', '', $param['quantidade']));
                $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));

                $valor_total = $quantidade * $valor ;
                $object = new stdClass();
                $object->valor_total = number_format($valor_total, 2, ',', '.');
                TForm::sendData(self::$formName, $object);    
            }

            // -----

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onChangeProduto($param = null) 
    {
        try 
        {

            if(!empty($param['key']) && empty($param['id']))
            {
                // Código gerado pelo snippet: "Conexão com banco de dados"
                TTransaction::open('minierp');

                $produto = Produto::find( $param['key'] );

                TTransaction::close();

                // Código gerado pelo snippet: "Enviar dados para campo"
                $object = new stdClass();
                $object->valor = number_format($produto->preco_venda, 2, ',', '.');

                TForm::sendData(self::$formName, $object);

            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new NegociacaoItem(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->fireEvents($object);

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
            TApplication::loadPage('NegociacaoItemHeaderList', 'onShow', $loadPageParam); 

            $paramTimeline = [
                'target_container' => 'container_timeline',
                'negociacao_id' => $object->negociacao_id
            ];

            TApplication::loadPage('NegociacaoTimeline', 'onShow', $paramTimeline);

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

                $object = new NegociacaoItem($key); // instantiates the Active Record 

                                $object->produto_tipo_produto_id = $object->produto->tipo_produto_id;

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
            if(isset($object->produto_tipo_produto_id))
            {
                $value = $object->produto_tipo_produto_id;

                $obj->produto_tipo_produto_id = $value;
            }
            if(isset($object->produto_id))
            {
                $value = $object->produto_id;

                $obj->produto_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->produto->tipo_produto_id))
            {
                $value = $object->produto->tipo_produto_id;

                $obj->produto_tipo_produto_id = $value;
            }
            if(isset($object->produto_id))
            {
                $value = $object->produto_id;

                $obj->produto_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

}

