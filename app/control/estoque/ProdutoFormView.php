<?php

class ProdutoFormView extends TPage
{
    protected $form; // form
    private static $database = 'minierp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Produto';

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

        $produto = new Produto($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta de produto");

        $transformed_produto_ativo = call_user_func(function($value, $object, $row)
        {

            if($value === 'T' || $value === true || $value === 't' || $value === 's')
            {
                return '<span class="label label-success">Sim</span>';
            }

            return '<span class="label label-danger">Não</span>';

        }, $produto->ativo, $produto, null);

        $foto_produto = new TImage($produto->foto);
        $label_id = new TLabel("Id:", '', '14px', 'B', '100%');
        $text1 = new TTextDisplay($produto->id, '', '16px', '');
        $label_nome = new TLabel("Nome:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay($produto->nome, '', '16px', '');
        $label_ativo = new TLabel("Ativo:", '', '14px', 'B', '100%');
        $text20 = new TTextDisplay($transformed_produto_ativo, '', '16px', '');
        $label_tipo_produto = new TLabel("Tipo de produto:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($produto->tipo_produto->nome, '', '16px', '');
        $label_familia = new TLabel("Família de produto:", '', '14px', 'B', '100%');
        $text3 = new TTextDisplay($produto->familia_produto->nome, '', '16px', '');
        $label_fornecedor = new TLabel("Fornecedor:", '', '14px', 'B', '100%');
        $text4 = new TTextDisplay($produto->fornecedor->nome, '', '16px', '');
        $label_fabricante = new TLabel("Fabricante:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay($produto->fabricante->nome, '', '16px', '');
        $label_obs = new TLabel("Observações", '', '14px', 'B', '100%');
        $text19 = new TTextDisplay($produto->obs, '', '16px', '');
        $label_preco_venda = new TLabel("Preço de venda:", '', '14px', 'B', '100%');
        $text9 = new TTextDisplay(number_format($produto->preco_venda, '2', ',', '.'), '', '16px', '');
        $label_preco_custo = new TLabel("Preço de custo:", '', '14px', 'B', '100%');
        $text10 = new TTextDisplay(number_format($produto->preco_custo, '2', ',', '.'), '', '16px', '');
        $label_peso_liquido = new TLabel("Peso liquido:", '', '14px', 'B', '100%');
        $text11 = new TTextDisplay(number_format($produto->peso_liquido, '2', ',', '.'), '', '16px', '');
        $label_peso_bruto = new TLabel("Peso bruto:", '', '14px', 'B', '100%');
        $text12 = new TTextDisplay(number_format($produto->peso_bruto, '2', ',', '.'), '', '16px', '');
        $label_volume = new TLabel("Volume:", '', '14px', 'B', '100%');
        $text15 = new TTextDisplay(number_format($produto->volume, '2', ',', '.'), '', '16px', '');
        $label_unidade = new TLabel("Unidade de medida:", '', '14px', 'B');
        $text5 = new TTextDisplay($produto->unidade_medida->nome, '', '16px', '');
        $label_largura = new TLabel("Largura:", '', '14px', 'B', '100%');
        $text13 = new TTextDisplay(number_format($produto->largura, '2', ',', '.'), '', '16px', '');
        $label_altura = new TLabel("Altura:", '', '14px', 'B', '100%');
        $text14 = new TTextDisplay(number_format($produto->altura, '2', ',', '.'), '', '16px', '');
        $label34 = new TLabel("Quantidade em estoque", '', '14px', 'B', '100%');
        $text17 = new TTextDisplay(number_format($produto->qtde_estoque, '2', ',', '.'), '', '16px', '');
        $label36 = new TLabel("Estoque mínimo:", '', '14px', 'B', '100%');
        $text16 = new TTextDisplay(number_format($produto->estoque_minimo, '2', ',', '.'), '', '16px', '');
        $label38 = new TLabel("Estoque máximo:", '', '14px', 'B', '100%');
        $text18 = new TTextDisplay(number_format($produto->estoque_maximo, '2', ',', '.'), '', '16px', '');
        $label40 = new TLabel("Número código barras:", '', '14px', 'B', '100%');
        $text8 = new TTextDisplay($produto->cod_barras, '', '16px', '');
        $label42 = new TLabel("Código de barrras:", '', '14px', 'B', '100%');
        $codigo_barras = new BElement('img');
        $label44 = new TLabel("QrCdode:", '', '14px', 'B', '100%');
        $qrcode = new BElement('img');





        $qrcode->width = '100%';
        $qrcode->height = '80px';
        $foto_produto->width = '80px';
        $foto_produto->height = '80px';
        $codigo_barras->width = '100%';
        $codigo_barras->height = '80px';

        $this->codigo_barras = $codigo_barras;
        $this->qrcode = $qrcode;

        $barcode_file = ProdutoService::gerarBarcode($produto->id);
        if($barcode_file)
        {
            $this->codigo_barras->src = 'download.php?file='.$barcode_file;
        }

        $qr_code_file = ProdutoService::gerarQrCode($produto->id);

        if($qr_code_file)
        {
            $this->qrcode->src = 'download.php?file='.$qr_code_file;    
        }

        $row1 = $this->form->addFields([$foto_produto],[$label_id,$text1],[$label_nome,$text7],[$label_ativo,$text20]);
        $row1->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([$label_tipo_produto,$text2],[$label_familia,$text3],[$label_fornecedor,$text4],[$label_fabricante,$text6]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([$label_obs,$text19]);
        $row3->layout = [' col-sm-12'];

        $tab_63b4b8b0bd3f0 = new BootstrapFormBuilder('tab_63b4b8b0bd3f0');
        $this->tab_63b4b8b0bd3f0 = $tab_63b4b8b0bd3f0;
        $tab_63b4b8b0bd3f0->setProperty('style', 'border:none; box-shadow:none;');

        $tab_63b4b8b0bd3f0->appendPage("Preços");

        $tab_63b4b8b0bd3f0->addFields([new THidden('current_tab_tab_63b4b8b0bd3f0')]);
        $tab_63b4b8b0bd3f0->setTabFunction("$('[name=current_tab_tab_63b4b8b0bd3f0]').val($(this).attr('data-current_page'));");

        $row4 = $tab_63b4b8b0bd3f0->addFields([$label_preco_venda,$text9],[$label_preco_custo,$text10]);
        $row4->layout = ['col-sm-3','col-sm-3'];

        $tab_63b4b8b0bd3f0->appendPage("Pesos e medidas");
        $row5 = $tab_63b4b8b0bd3f0->addFields([$label_peso_liquido,$text11],[$label_peso_bruto,$text12],[$label_volume,$text15],[$label_unidade,$text5]);
        $row5->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row6 = $tab_63b4b8b0bd3f0->addFields([$label_largura,$text13],[$label_altura,$text14],[]);
        $row6->layout = ['col-sm-3','col-sm-3', 'col-sm-6'];

        $tab_63b4b8b0bd3f0->appendPage("Estoque");
        $row7 = $tab_63b4b8b0bd3f0->addFields([$label34,$text17],[$label36,$text16],[$label38,$text18]);
        $row7->layout = ['col-sm-3','col-sm-3',' col-sm-3'];

        $tab_63b4b8b0bd3f0->appendPage("QrCode / Código de barras");
        $row8 = $tab_63b4b8b0bd3f0->addFields([$label40,$text8]);
        $row8->layout = [' col-sm-12'];

        $row9 = $tab_63b4b8b0bd3f0->addFields([$label42,$codigo_barras],[$label44,$qrcode]);
        $row9->layout = [' col-sm-6','col-sm-6'];

        $row10 = $this->form->addFields([$tab_63b4b8b0bd3f0]);
        $row10->layout = [' col-sm-12'];

        if(!empty($param['current_tab']))
        {
            $this->form->setCurrentPage($param['current_tab']);
        }

        if(!empty($param['current_tab_tab_63b4b8b0bd3f0']))
        {
            $this->tab_63b4b8b0bd3f0->setCurrentPage($param['current_tab_tab_63b4b8b0bd3f0']);
        }

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

        $style = new TStyle('right-panel > .container-part[page-name=ProdutoFormView]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

