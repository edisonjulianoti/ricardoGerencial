<?php

class NegociacaoEmailForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_NegociacaoEmailForm';

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
        $this->form->setFormTitle("Envio de email negociação");

        $criteria_negociacoes_id = new TCriteria();

        $filterVar = self::getNegociacoesId($param);
        $criteria_negociacoes_id->add(new TFilter('id', 'in', $filterVar)); 

        $negociacoes_id = new TCheckList('negociacoes_id');
        $negociacao_id = new THidden('negociacao_id');
        $email_template_id = new TDBCombo('email_template_id', 'minierp', 'EmailTemplate', 'id', '{titulo}','titulo asc'  );
        $mensagem = new THtmlEditor('mensagem');

        $email_template_id->setChangeAction(new TAction([$this,'onChangeTemplateEmail']));

        $negociacoes_id->addValidation("Negociações", new TRequiredValidator()); 
        $email_template_id->addValidation("Template de email", new TRequiredValidator()); 

        $email_template_id->enableSearch();
        $negociacao_id->setValue($param["negociacao_id"] ?? "");
        $negociacoes_id->setValue(self::getNegociacoesId($param));

        $negociacao_id->setSize(200);
        $mensagem->setSize('100%', 160);
        $email_template_id->setSize('100%');

        $negociacoes_id->setIdColumn('id');

        $column_negociacoes_id_id = $negociacoes_id->addColumn('id', "Id", 'center' , '20%');
        $column_negociacoes_id_cliente_nome = $negociacoes_id->addColumn('cliente->nome', "Cliente", 'center' , '20%');
        $column_negociacoes_id_vendedor_nome = $negociacoes_id->addColumn('vendedor->nome', "vendedor", 'center' , '20%');
        $column_negociacoes_id_etapa_negociacao_nome = $negociacoes_id->addColumn('etapa_negociacao->nome', "Etapa", 'center' , '20%');
        $column_negociacoes_id_valor_total_transformed = $negociacoes_id->addColumn('valor_total', "Valor total", 'center' , '20%');

        $column_negociacoes_id_valor_total_transformed->setTransformer(function($value, $object, $row) 
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

        $negociacoes_id->setHeight(200);
        $negociacoes_id->makeScrollable();

        $negociacoes_id->fillWith('minierp', 'Negociacao', 'id', 'id desc' , $criteria_negociacoes_id);


        $row1 = $this->form->addFields([new TLabel("Negociações:", '#F44336', '14px', null, '100%'),$negociacoes_id,$negociacao_id]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Template de email:", '#F44336', '14px', null, '100%'),$email_template_id]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Mensagem:", '#F44336', '14px', null, '100%'),$mensagem]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onenviaremail = $this->form->addAction("Enviar", new TAction([$this, 'onEnviarEmail']), 'fas:rocket #ffffff');
        $this->btn_onenviaremail = $btn_onenviaremail;
        $btn_onenviaremail->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=NegociacaoEmailForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onChangeTemplateEmail($param = null) 
    {
        try 
        {

            if(!empty($param['key']))
            {
                TTransaction::open('minierp');

                $emailTemplate = new EmailTemplate($param['key']);

                TTransaction::close();

                $obj = new stdClass();
                $obj->mensagem = $emailTemplate->mensagem;

                TForm::sendData(self::$formName, $obj);

            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onEnviarEmail($param = null) 
    {

        try
        {
            $this->form->validate();
            $data = $this->form->getData();
            $mensagem = $data->mensagem;

            if($data->negociacoes_id)
            {
                TTransaction::open('minierp');
                $emailTemplate = new EmailTemplate($data->email_template_id);

                foreach($data->negociacoes_id as $negociacao_id)
                {
                    $negociacao = new Negociacao($negociacao_id);

                    $mensagem = str_replace('{nome}', $negociacao->cliente->nome, $mensagem);
                    $mensagem = str_replace('{id}', $negociacao->id, $mensagem);

                    $emailTemplate->titulo = str_replace('{nome}', $negociacao->cliente->nome, $emailTemplate->titulo);

                    if($negociacao->cliente->email)
                    {
                        MailService::send($negociacao->cliente->email, $emailTemplate->titulo, $mensagem,  'html');    
                    }

                }
                TTransaction::close();
            }

            $this->form->setData($data);

            new TMessage('info', 'Emails enviados!');

            // veio da listagem
            if(!$data->negociacao_id)
            {
                // limpa a variavel de sessao
                TSession::setValue('NegociacaoListbuilder_datagrid_check', null);

                TApplication::loadPage('NegociacaoList', 'onShow');
            }

            // fecha a cortina lateral
            TScript::create("Template.closeRightPanel();");

        }
        catch (Exception $e)
        {
            $data = $this->form->getData();
            $this->form->setData($data);
            new TMessage('error', $e->getMessage());
        }

    }

    public function onShow($param = null)
    {               

    } 

    public static function getNegociacoesId($param)
    {
        if(!empty($param['negociacao_id']))
        {
            return [ $param['negociacao_id'] ];
        }
        else if(TSession::getValue('NegociacaoListbuilder_datagrid_check'))
        {
            return TSession::getValue('NegociacaoListbuilder_datagrid_check');
        }

        return [-1];
    }

}

