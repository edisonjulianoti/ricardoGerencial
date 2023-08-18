<?php

class ContaPagarFormView extends TPage
{
    protected $form; // form
    private static $database = 'minierp';
    private static $activeRecord = 'Conta';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Conta';

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

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $conta = new Conta($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta de conta a pagar");

        TSession::setValue('conta_pagar_form_view_conta_id', $conta->id);

        $label2 = new TLabel("Id:", '', '14px', 'B', '100%');
        $text1 = new TTextDisplay($conta->id, '', '16px', '');
        $label16 = new TLabel("Criado em:", '', '14px', 'B', '100%');
        $text14 = new TTextDisplay(TDateTime::convertToMask($conta->created_at, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '16px', '');
        $label18 = new TLabel("Status:", '', '14px', 'B', '100%');
        $text11 = new TTextDisplay($conta->status, '', '16px', '');
        $label4 = new TLabel("Pessoa:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($conta->pessoa->nome, '', '16px', '');
        $label6 = new TLabel("Categoria:", '', '14px', 'B', '100%');
        $text4 = new TTextDisplay($conta->categoria->nome, '', '16px', '');
        $label8 = new TLabel("Forma de pagamento:", '', '14px', 'B');
        $text5 = new TTextDisplay($conta->forma_pagamento->nome, '', '16px', '');
        $label10 = new TLabel("Data de emissão:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay(TDate::convertToMask($conta->dt_emissao, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label12 = new TLabel("Data de vencimento:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay(TDate::convertToMask($conta->dt_vencimento, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label14 = new TLabel("Data de pagamento:", '', '14px', 'B', '100%');
        $text8 = new TTextDisplay(TDate::convertToMask($conta->dt_pagamento, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '16px', '');
        $label20 = new TLabel("Valor:", '', '14px', 'B', '100%');
        $text9 = new TTextDisplay(number_format($conta->valor, '2', ',', '.'), '', '16px', '');
        $label22 = new TLabel("Parcela:", '', '14px', 'B', '100%');
        $text10 = new TTextDisplay($conta->parcela, '', '16px', '');
        $label24 = new TLabel("Obs:", '', '14px', 'B', '100%');
        $text13 = new TTextDisplay($conta->obs, '', '16px', '');
        $anexos = new BPageContainer();

        $anexos->setSize('100%');
        $anexos->setAction(new TAction(['ContaAnexoHeaderList', 'onShow'], ['conta_id' => $conta->id]));
        $anexos->setId('b62ec540014569');



        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $anexos->add($loadingContainer);

        $row1 = $this->form->addFields([$label2,$text1],[$label16,$text14],[$label18,$text11]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([$label4,$text2],[$label6,$text4],[$label8,$text5]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([$label10,$text7],[$label12,$text6],[$label14,$text8]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([$label20,$text9],[$label22,$text10],[$label24,$text13]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([$anexos]);
        $row5->layout = [' col-sm-12'];

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        TTransaction::close();
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ContaPagarFormView]');
        $style->width = '70% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

