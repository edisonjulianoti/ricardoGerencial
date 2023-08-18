<?php

class ProdutoQRCode extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_ProdutoQRCode';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Etiquetas de QrCode");

        $criteria_fornecedor_id = new TCriteria();

        $filterVar = GrupoPessoa::FORNECEDOR;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_pessoa_id = '{$filterVar}')")); 

        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'minierp', 'TipoProduto', 'id', '{nome}','nome asc'  );
        $familia_produto_id = new TDBCombo('familia_produto_id', 'minierp', 'FamiliaProduto', 'id', '{nome}','nome asc'  );
        $fornecedor_id = new TDBCombo('fornecedor_id', 'minierp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_fornecedor_id );
        $fabricante_id = new TDBCombo('fabricante_id', 'minierp', 'Fabricante', 'id', '{nome}','nome asc'  );

        $fornecedor_id->setSize('100%');
        $fabricante_id->setSize('100%');
        $tipo_produto_id->setSize('100%');
        $familia_produto_id->setSize('100%');

        $fornecedor_id->enableSearch();
        $fabricante_id->enableSearch();
        $tipo_produto_id->enableSearch();
        $familia_produto_id->enableSearch();


        $row1 = $this->form->addFields([new TLabel("Tipo de produto:", null, '14px', null, '100%'),$tipo_produto_id],[new TLabel("Família de produto:", null, '14px', null, '100%'),$familia_produto_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Fornecedor:", null, '14px', null, '100%'),$fornecedor_id],[new TLabel("Fabricante:", null, '14px', null, '100%'),$fabricante_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:cog #ffffff');
        $this->btn_ongenerate = $btn_ongenerate;
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Estoque","Etiquetas de QrCode"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $data = $this->form->getData();
            $criteria = new TCriteria();

            if (isset($data->tipo_produto_id) AND ( (is_scalar($data->tipo_produto_id) AND $data->tipo_produto_id !== '') OR (is_array($data->tipo_produto_id) AND (!empty($data->tipo_produto_id)) )) )
            {

                $criteria->add(new TFilter('tipo_produto_id', '=', $data->tipo_produto_id));
            }
            if (isset($data->familia_produto_id) AND ( (is_scalar($data->familia_produto_id) AND $data->familia_produto_id !== '') OR (is_array($data->familia_produto_id) AND (!empty($data->familia_produto_id)) )) )
            {

                $criteria->add(new TFilter('familia_produto_id', '=', $data->familia_produto_id));
            }
            if (isset($data->fornecedor_id) AND ( (is_scalar($data->fornecedor_id) AND $data->fornecedor_id !== '') OR (is_array($data->fornecedor_id) AND (!empty($data->fornecedor_id)) )) )
            {

                $criteria->add(new TFilter('fornecedor_id', '=', $data->fornecedor_id));
            }
            if (isset($data->fabricante_id) AND ( (is_scalar($data->fabricante_id) AND $data->fabricante_id !== '') OR (is_array($data->fabricante_id) AND (!empty($data->fabricante_id)) )) )
            {

                $criteria->add(new TFilter('fabricante_id', '=', $data->fabricante_id));
            }

            TSession::setValue(__CLASS__.'_filter_data', $data);

            $properties = [];

            $properties['leftMargin']    = 10; // Left margin
            $properties['topMargin']     = 10; // Top margin
            $properties['labelWidth']    = 64; // Label width in mm
            $properties['labelHeight']   = 28; // Label height in mm
            $properties['spaceBetween']  = 4;  // Space between labels
            $properties['rowsPerPage']   = 10;  // Label rows per page
            $properties['colsPerPage']   = 3;  // Label cols per page
            $properties['fontSize']      = 12; // Text font size
            $properties['barcodeHeight'] = 20; // Barcode Height
            $properties['imageMargin']   = 0;

            $label  = "<b>{nome}</b>
#qrcode#";

            $bcgen = new AdiantiBarcodeDocumentGenerator('p', 'A4');
            $bcgen->setProperties($properties);
            $bcgen->setLabelTemplate($label);

            $class = self::$activeRecord;

            $objects = $class::getObjects($criteria);

            if ($objects)
            {
                foreach ($objects as $object)
                {

                    $bcgen->addObject($object);
                }

                $filename = 'tmp/barcode_'.uniqid().'.pdf';

                $bcgen->setBarcodeContent(' {cod_barras} ');
                $bcgen->generate();
                $bcgen->save($filename);

                parent::openFile($filename);
                new TMessage('info', _t('QR Codes successfully generated'));
            }
            else
            {
                new TMessage('info', _t('No records found'));   
            }

            TTransaction::close();

            $this->form->setData($data);

        } 
        catch (Exception $e) 
        {
            $this->form->setData($data);

            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }


}

