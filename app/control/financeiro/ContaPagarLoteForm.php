<?php

class ContaPagarLoteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ContaPagarLoteForm';

    use BuilderMasterDetailFieldListTrait;

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
        $this->form->setFormTitle("Cadastro de conta a pagar em lote");

        $criteria_pessoa_id = new TCriteria();
        $criteria_categoria_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_pessoa_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 
        $filterVar = TipoConta::PAGAR;
        $criteria_categoria_id->add(new TFilter('tipo_conta_id', '=', $filterVar)); 

        $pessoa_id = new TDBCombo('pessoa_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_pessoa_id );
        $categoria_id = new TDBCombo('categoria_id', 'minierp', 'Categoria', 'id', '{nome}','nome asc' , $criteria_categoria_id );
        $forma_pagamento_id = new TDBCombo('forma_pagamento_id', 'minierp', 'FormaPagamento', 'id', '{nome}','nome asc'  );
        $dt_vencimento_inicial = new TDate('dt_vencimento_inicial');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $tipo_geracao = new TCombo('tipo_geracao');
        $intervalo = new TCombo('intervalo');
        $quantidade_contas = new TSpinner('quantidade_contas');
        $button_gerar_contas = new TButton('button_gerar_contas');
        $conta_parcela = new TEntry('conta_parcela[]');
        $conta_dt_vencimento = new TDate('conta_dt_vencimento[]');
        $conta_valor = new TNumeric('conta_valor[]', '2', ',', '.' );
        $this->fieldList_contas = new TFieldList();

        $this->fieldList_contas->addField(new TLabel("Parcela", null, '14px', null), $conta_parcela, ['width' => '33%']);
        $this->fieldList_contas->addField(new TLabel("Vencimento", null, '14px', null), $conta_dt_vencimento, ['width' => '33%']);
        $this->fieldList_contas->addField(new TLabel("Valor", null, '14px', null), $conta_valor, ['width' => '33%']);

        $this->fieldList_contas->width = '100%';
        $this->fieldList_contas->name = 'fieldList_contas';
        $this->fieldList_contas->class .= ' table-responsive';

        $this->criteria_fieldList_contas = new TCriteria();

        $this->form->addField($conta_parcela);
        $this->form->addField($conta_dt_vencimento);
        $this->form->addField($conta_valor);

        $this->fieldList_contas->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $pessoa_id->addValidation("Fornecedor", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria", new TRequiredValidator()); 
        $forma_pagamento_id->addValidation("Forma de pagamento", new TRequiredValidator()); 
        $dt_vencimento_inicial->addValidation("Data de vencimento inicial", new TRequiredValidator()); 
        $valor->addValidation("Valor", new TRequiredValidator()); 
        $tipo_geracao->addValidation("Tipo de geração", new TRequiredValidator()); 
        $intervalo->addValidation("Intervalo", new TRequiredValidator()); 
        $quantidade_contas->addValidation("Quantidade de contas", new TRequiredValidator()); 

        $quantidade_contas->setRange(1, 2000, 1);
        $button_gerar_contas->setAction(new TAction([$this, 'onGerarContas']), "Gerar Contas");
        $button_gerar_contas->addStyleClass('btn-default');
        $button_gerar_contas->setImage('fas:cogs #009688');
        $conta_dt_vencimento->setMask('dd/mm/yyyy');
        $dt_vencimento_inicial->setMask('dd/mm/yyyy');

        $conta_dt_vencimento->setDatabaseMask('yyyy-mm-dd');
        $dt_vencimento_inicial->setDatabaseMask('yyyy-mm-dd');

        $tipo_geracao->addItems(["recorrencia"=>"Recorrência","parcelamento"=>"Parcelamento"]);
        $intervalo->addItems(["semanal"=>"Semanal","quinzenal"=>"Quinzenal","mensal"=>"Mensal"]);

        $pessoa_id->enableSearch();
        $intervalo->enableSearch();
        $categoria_id->enableSearch();
        $tipo_geracao->enableSearch();
        $forma_pagamento_id->enableSearch();

        $valor->setSize('100%');
        $pessoa_id->setSize('100%');
        $intervalo->setSize('100%');
        $conta_valor->setSize('100%');
        $categoria_id->setSize('100%');
        $tipo_geracao->setSize('100%');
        $conta_parcela->setSize('100%');
        $quantidade_contas->setSize(110);
        $forma_pagamento_id->setSize('100%');
        $dt_vencimento_inicial->setSize(110);
        $conta_dt_vencimento->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Fornecedor:", '#F44336', '14px', null, '100%'),$pessoa_id],[new TLabel("Categoria:", '#F44336', '14px', null, '100%'),$categoria_id],[new TLabel("Forma de pagamento:", '#F44336', '14px', null, '100%'),$forma_pagamento_id]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Data de vencimento inicial:", '#F44336', '14px', null, '100%'),$dt_vencimento_inicial],[new TLabel("Valor:", '#F44336', '14px', null, '100%'),$valor]);
        $row2->layout = [' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Tipo de geração:", '#F44336', '14px', null, '100%'),$tipo_geracao],[new TLabel("Intervalo:", '#F44336', '14px', null, '100%'),$intervalo],[new TLabel("Quantidade de contas:", '#F44336', '14px', null, '100%'),$quantidade_contas],[$button_gerar_contas]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $this->form->addFields([new TFormSeparator("Contas", '#333', '18', '#eee')]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$this->fieldList_contas]);
        $row5->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=ContaPagarLoteForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onGerarContas($param = null) 
    {
        try 
        {

            (new TRequiredValidator)->validate('Valor', $param['valor'] );
            (new TRequiredValidator)->validate('Data vencimento inicial', $param['dt_vencimento_inicial']);
            (new TRequiredValidator)->validate('Forma de pagamento', $param['forma_pagamento_id']);
            (new TRequiredValidator)->validate('Categoria', $param['categoria_id']);
            (new TRequiredValidator)->validate('Tipo de gerção', $param['tipo_geracao']);
            (new TRequiredValidator)->validate('Intervalo', $param['intervalo']);

            //popula as variáveis com os valores que vem por parâmetro 
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $forma_pagamento_id = $param['forma_pagamento_id'];
            $categoria_id = $param['categoria_id'];
            $dt_vencimento_inicial = TDate::date2us($param['dt_vencimento_inicial']);
            $quantidade_contas = $param['quantidade_contas'];
            $tipo_geracao = $param['tipo_geracao'];
            $intervalo = $param['intervalo'];

            // calcula o valor da parcela
            $valorParcela = $valor;
            if($tipo_geracao == 'parcelamento')
            {
                $valorParcela = $valor / $quantidade_contas;    
            }

            // transforma a data de vencimento em um objeto da classe DateTime
            $dt_vencimento = new DateTime($dt_vencimento_inicial);

            $data = new stdClass();
            $data->conta_valor = [];
            $data->conta_parcela = [];
            $data->conta_dt_vencimento = [];

            $parcela = 1;
            for($i = 0 ; $i < $quantidade_contas; $i++)
            {
                if($intervalo == 'semanal')
                {
                    $dt_vencimento->add(new DateInterval("P1W"));
                }
                elseif($intervalo == 'quinzenal')
                {
                    $dt_vencimento->add(new DateInterval("P15D"));
                }
                elseif($intervalo == 'mensal')
                {
                    $dt_vencimento->add(new DateInterval("P1M"));
                }

                // populando o array das propriedades do fieldlist
                $data->conta_parcela[] = $parcela;
                $data->conta_dt_vencimento[] = $dt_vencimento->format('d/m/Y');
                $data->conta_valor[] = number_format($valorParcela, 2, ',','.');

                if($tipo_geracao == 'parcelamento')
                {
                    $parcela++;
                }
            }

            // limpa o TFieldList
            // o primeiro parâmetro é o nome da variável definida para o TFieldList
            TFieldList::clearRows('fieldList_contas');
            // adicionamos as linhas novas
            // primeiro parâmetro é o nome da variável definida para o TFieldList
            TFieldList::addRows('fieldList_contas', $quantidade_contas - 1, 1);
            // enviando os dados para o field list
            TForm::sendData(self::$formName, $data, false, true, 500);

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
            $this->form->validate();
            $data = $this->form->getData();
            $fieldListContasData = $this->fieldList_contas->getPostData();

            if($fieldListContasData)
            {
                TTransaction::open('minierp');
                foreach($fieldListContasData as $contaData)
                {
                    $conta = new Conta();

                    $conta->tipo_conta_id = TipoConta::PAGAR;
                    $conta->pessoa_id = $data->pessoa_id;
                    $conta->forma_pagamento_id = $data->forma_pagamento_id;
                    $conta->categoria_id = $data->categoria_id;

                    $conta->valor = $contaData->conta_valor;
                    $conta->parcela = $contaData->conta_parcela;
                    $conta->dt_vencimento = $contaData->conta_dt_vencimento;

                    $conta->dt_emissao = date('Y-m-d');

                    $conta->store();
                }
                TTransaction::close();    

                new TMessage('info', 'Contas criadas!', new TAction(['ContaPagarList', 'onShow']));

                TScript::create("Template.closeRightPanel();");
            }

        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }

    }

    public function onShow($param = null)
    {               
        $this->fieldList_contas->addHeader();
        $this->fieldList_contas->addDetail( new stdClass );

        $this->fieldList_contas->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

}

