<?php

class ProdutoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_ProdutoForm';

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Cadastro de produto");

        $criteria_fornecedor_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $foto = new TImageCropper('foto');
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cod_barras = new TEntry('cod_barras');
        $ativo = new TRadioGroup('ativo');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $familia_produto_id = new TDBCombo('familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $fornecedor_id = new TDBUniqueSearch('fornecedor_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_fornecedor_id );
        $fabricante_id = new TDBCombo('fabricante_id', 'minierp', 'Fabricante', 'id', '{nome}','nome asc'  );
        $preco_custo = new TNumeric('preco_custo', '2', ',', '.' );
        $preco_venda = new TNumeric('preco_venda', '2', ',', '.' );
        $largura = new TNumeric('largura', '2', ',', '.' );
        $altura = new TNumeric('altura', '2', ',', '.' );
        $unidade_medida_id = new TDBCombo('unidade_medida_id', 'minierp', 'UnidadeMedida', 'id', '{nome}','nome asc'  );
        $volume = new TNumeric('volume', '2', ',', '.' );
        $peso_liquido = new TNumeric('peso_liquido', '2', ',', '.' );
        $peso_bruto = new TNumeric('peso_bruto', '2', ',', '.' );
        $qtde_estoque = new TNumeric('qtde_estoque', '2', ',', '.' );
        $estoque_minimo = new TNumeric('estoque_minimo', '2', ',', '.' );
        $estoque_maximo = new TNumeric('estoque_maximo', '2', ',', '.' );
        $obs = new TText('obs');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $tipo_produto_id->addValidation("Tipo de produto", new TRequiredValidator()); 
        $familia_produto_id->addValidation("Família de produto", new TRequiredValidator()); 
        $fornecedor_id->addValidation("Fornecedor", new TRequiredValidator()); 
        $unidade_medida_id->addValidation("Unidade de medida", new TRequiredValidator()); 

        $foto->enableFileHandling();
        $foto->setAllowedExtensions(["jpg","jpeg","png","gif"]);
        $foto->setImagePlaceholder(new TImage("fas:file-upload #dde5ec"));
        $id->setEditable(false);
        $ativo->addItems(["T"=>"Sim","F"=>"Não"]);
        $ativo->setLayout('horizontal');
        $ativo->setValue('T');
        $ativo->setUseButton();
        $fornecedor_id->setMinLength(2);
        $fornecedor_id->setMask('{nome} - {documento}');
        $fornecedor_id->setFilterColumns(["documento","nome"]);
        $nome->setMaxLength(255);
        $cod_barras->setMaxLength(255);

        $tipo_produto_id->enableSearch();
        $unidade_medida_id->enableSearch();
        $familia_produto_id->enableSearch();

        $id->setSize('100%');
        $nome->setSize('100%');
        $ativo->setSize('100%');
        $foto->setSize(160, 160);
        $altura->setSize('100%');
        $volume->setSize('100%');
        $largura->setSize('100%');
        $peso_bruto->setSize(110);
        $obs->setSize('100%', 100);
        $cod_barras->setSize('100%');
        $preco_custo->setSize('100%');
        $preco_venda->setSize('100%');
        $peso_liquido->setSize('100%');
        $qtde_estoque->setSize('100%');
        $fornecedor_id->setSize('100%');
        $fabricante_id->setSize('100%');
        $estoque_minimo->setSize('100%');
        $estoque_maximo->setSize('100%');
        $tipo_produto_id->setSize('100%');
        $unidade_medida_id->setSize('100%');
        $familia_produto_id->setSize('100%');




        $row1 = $this->form->addContent([new TFormSeparator("Informações gerais", '#333', '18', '#eee')]);

        $bcontainer_62463e0849f16 = new BootstrapFormBuilder('bcontainer_62463e0849f16');
        $this->bcontainer_62463e0849f16 = $bcontainer_62463e0849f16;
        $bcontainer_62463e0849f16->setProperty('style', 'border:none; box-shadow:none;');
        $row2 = $bcontainer_62463e0849f16->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome]);
        $row2->layout = [' col-sm-6','col-sm-6'];

        $row3 = $bcontainer_62463e0849f16->addFields([new TLabel("Código de barras:", null, '14px', null, '100%'),$cod_barras],[new TLabel("Ativo:", null, '14px', null, '100%'),$ativo]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([$foto],[$bcontainer_62463e0849f16]);
        $row4->layout = [' col-sm-3',' col-sm-9'];

        $row5 = $this->form->addFields([new TLabel("Tipo de produto:", '#ff0000', '14px', null, '100%'),$tipo_produto_id],[new TLabel("Família de produto:", '#ff0000', '14px', null, '100%'),$familia_produto_id]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Fornecedor:", '#ff0000', '14px', null, '100%'),$fornecedor_id],[new TLabel("Fabricante:", null, '14px', null, '100%'),$fabricante_id]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addContent([new TFormSeparator("Preços", '#333', '18', '#eee')]);
        $row8 = $this->form->addFields([new TLabel("Preço de custo:", null, '14px', null, '100%'),$preco_custo],[new TLabel("Preço de venda", null, '14px', null, '100%'),$preco_venda]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->form->addContent([new TFormSeparator("Pesos e medidas", '#333', '18', '#eee')]);
        $row10 = $this->form->addFields([new TLabel("Largura:", null, '14px', null, '100%'),$largura],[new TLabel("Altura:", null, '14px', null, '100%'),$altura]);
        $row10->layout = ['col-sm-6','col-sm-6'];

        $row11 = $this->form->addFields([new TLabel("Unidade de medida:", '#ff0000', '14px', null, '100%'),$unidade_medida_id],[new TLabel("Volume:", null, '14px', null, '100%'),$volume]);
        $row11->layout = ['col-sm-6',' col-sm-6'];

        $row12 = $this->form->addFields([new TLabel("Peso líquido:", null, '14px', null, '100%'),$peso_liquido],[new TLabel("Peso bruto:", null, '14px', null, '100%'),$peso_bruto]);
        $row12->layout = ['col-sm-6','col-sm-6'];

        $row13 = $this->form->addContent([new TFormSeparator("Estoque", '#333', '18', '#eee')]);
        $row14 = $this->form->addFields([new TLabel("Quantidade de estoque:", null, '14px', null, '100%'),$qtde_estoque],[new TLabel("Estoque mínimo:", null, '14px', null, '100%'),$estoque_minimo],[new TLabel("Estoque máximo:", null, '14px', null, '100%'),$estoque_maximo]);
        $row14->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row15 = $this->form->addFields([new TLabel("Observações", null, '14px', null, '100%'),$obs]);
        $row15->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ProdutoList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=ProdutoForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Produto(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $foto_dir = 'app/fotos/produtos'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'foto', $foto_dir);
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
            TApplication::loadPage('ProdutoList', 'onShow', $loadPageParam); 

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

                $object = new Produto($key); // instantiates the Active Record 

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

