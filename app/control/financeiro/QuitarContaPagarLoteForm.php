<?php

class QuitarContaPagarLoteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_QuitarContaPagarLoteForm';

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
        $this->form->setFormTitle("Quitar contas a pagar em lote");

        $criteria_contas = new TCriteria();

        $filterVar = TSession::getValue('ContaPagarListbuilder_datagrid_check');
        $criteria_contas->add(new TFilter('id', 'in', $filterVar)); 

        $forma_pagamento_id = new TDBCombo('forma_pagamento_id', 'minierp', 'FormaPagamento', 'id', '{nome}','nome asc'  );
        $obs = new TText('obs');
        $contas = new TCheckList('contas');


        $forma_pagamento_id->enableSearch();
        $contas->setValue(TSession::getValue('ContaPagarListbuilder_datagrid_check'));
        $obs->setSize('100%', 70);
        $forma_pagamento_id->setSize('100%');

        $contas->setIdColumn('id');

        $column_contas_id = $contas->addColumn('id', "Id", 'center' , '20%');
        $column_contas_pessoa_nome = $contas->addColumn('pessoa->nome', "Fornecedor", 'left' , '20%');
        $column_contas_dt_vencimento_transformed = $contas->addColumn('dt_vencimento', "Vencimento", 'center' , '20%');
        $column_contas_parcela = $contas->addColumn('parcela', "Parcela", 'center' , '20%');
        $column_contas_valor_transformed = $contas->addColumn('valor', "Valor", 'center' , '20%');

        $column_contas_dt_vencimento_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_contas_valor_transformed->setTransformer(function($value, $object, $row) 
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
        });        

        $contas->setHeight(250);
        $contas->makeScrollable();

        $contas->fillWith('minierp', 'Conta', 'id', 'id asc' , $criteria_contas);


        $row1 = $this->form->addFields([new TLabel("Forma de pagamento:", null, '14px', null, '100%'),$forma_pagamento_id],[new TLabel("Observações:", null, '14px', null, '100%'),$obs]);
        $row1->layout = [' col-sm-4',' col-sm-8'];

        $row2 = $this->form->addFields([$contas]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar em lote", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=QuitarContaPagarLoteForm]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            $this->form->validate();

            $data = $this->form->getData();

            if($data->contas)
            {
                TTransaction::open('minierp');

                foreach($data->contas as $conta_id)
                {
                    $conta = new Conta($conta_id);

                    $conta->dt_pagamento = date('Y-m-d');
                    $conta->forma_pagamento_id = $data->forma_pagamento_id;
                    $conta->obs = $data->obs;

                    $conta->store();
                }

                TTransaction::close();

                TSession::setValue('ContaPagarListbuilder_datagrid_check', NULL);

                new TMessage('info', 'Contas quitadas com sucesso!', new TAction(['ContaPagarList', 'onShow']));

            }

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

