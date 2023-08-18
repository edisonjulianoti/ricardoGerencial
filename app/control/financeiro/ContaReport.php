<?php

class ContaReport extends TPage
{
    private $form; // form
    private $loaded;
    private static $database = 'minierp';
    private static $activeRecord = 'Conta';
    private static $primaryKey = 'id';
    private static $formName = 'form_ContaReport';

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Relatório de contas");

        $pessoa_id = new TDBUniqueSearch('pessoa_id', 'minierp', 'Pessoa', 'id', 'nome','nome asc'  );
        $tipo_conta_id = new TDBCombo('tipo_conta_id', 'minierp', 'TipoConta', 'id', '{nome}','nome asc'  );
        $categoria_id = new TDBCombo('categoria_id', 'minierp', 'Categoria', 'id', '{nome}','nome asc'  );
        $forma_pagamento_id = new TDBCombo('forma_pagamento_id', 'minierp', 'FormaPagamento', 'id', '{nome}','nome asc'  );
        $dt_vencimento = new TDate('dt_vencimento');
        $dt_vencimento_final = new TDate('dt_vencimento_final');
        $dt_emissao = new TDate('dt_emissao');
        $dt_emissao_final = new TDate('dt_emissao_final');
        $dt_pagamento = new TDate('dt_pagamento');
        $dt_pagamento_final = new TDate('dt_pagamento_final');

        $pessoa_id->setMinLength(2);
        $categoria_id->enableSearch();
        $tipo_conta_id->enableSearch();
        $forma_pagamento_id->enableSearch();

        $dt_emissao->setDatabaseMask('yyyy-mm-dd');
        $dt_pagamento->setDatabaseMask('yyyy-mm-dd');
        $dt_vencimento->setDatabaseMask('yyyy-mm-dd');
        $dt_emissao_final->setDatabaseMask('yyyy-mm-dd');
        $dt_pagamento_final->setDatabaseMask('yyyy-mm-dd');
        $dt_vencimento_final->setDatabaseMask('yyyy-mm-dd');

        $pessoa_id->setMask('{nome}');
        $dt_emissao->setMask('dd/mm/yyyy');
        $dt_pagamento->setMask('dd/mm/yyyy');
        $dt_vencimento->setMask('dd/mm/yyyy');
        $dt_emissao_final->setMask('dd/mm/yyyy');
        $dt_pagamento_final->setMask('dd/mm/yyyy');
        $dt_vencimento_final->setMask('dd/mm/yyyy');

        $dt_emissao->setSize(110);
        $pessoa_id->setSize('100%');
        $dt_pagamento->setSize(110);
        $dt_vencimento->setSize(110);
        $categoria_id->setSize('100%');
        $tipo_conta_id->setSize('100%');
        $dt_emissao_final->setSize(110);
        $dt_pagamento_final->setSize(110);
        $dt_vencimento_final->setSize(110);
        $forma_pagamento_id->setSize('100%');



        $row1 = $this->form->addFields([new TLabel("Pessoa (Cliente/Fornecedor):", null, '14px', null, '100%'),$pessoa_id],[new TLabel("Tipo da conta:", null, '14px', null, '100%'),$tipo_conta_id],[new TLabel("Categoria:", null, '14px', null, '100%'),$categoria_id],[new TLabel("Forma de pagamento:", null, '14px', null, '100%'),$forma_pagamento_id]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Data de vencimento:", null, '14px', null, '100%'),$dt_vencimento,new TLabel("até", null, '14px', null),$dt_vencimento_final],[new TLabel("Data de emissão:", null, '14px', null, '100%'),$dt_emissao,new TLabel("até", null, '14px', null),$dt_emissao_final],[new TLabel("Data de pagamento:", null, '14px', null, '100%'),$dt_pagamento,new TLabel("até", null, '14px', null),$dt_pagamento_final]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongeneratehtml = $this->form->addAction("Gerar HTML", new TAction([$this, 'onGenerateHtml']), 'far:file-code #ffffff');
        $this->btn_ongeneratehtml = $btn_ongeneratehtml;
        $btn_ongeneratehtml->addStyleClass('btn-primary'); 

        $btn_ongeneratepdf = $this->form->addAction("Gerar PDF", new TAction([$this, 'onGeneratePdf']), 'far:file-pdf #d44734');
        $this->btn_ongeneratepdf = $btn_ongeneratepdf;

        $btn_ongeneratexls = $this->form->addAction("Gerar XLS", new TAction([$this, 'onGenerateXls']), 'far:file-excel #00a65a');
        $this->btn_ongeneratexls = $btn_ongeneratexls;

        $btn_ongeneratertf = $this->form->addAction("Gerar RTF", new TAction([$this, 'onGenerateRtf']), 'far:file-alt #324bcc');
        $this->btn_ongeneratertf = $btn_ongeneratertf;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Financeiro","Relatório de contas"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerateHtml($param = null) 
    {
        $this->onGenerate('html');
    }

    public function onGeneratePdf($param = null) 
    {
        $this->onGenerate('pdf');
    }

    public function onGenerateXls($param = null) 
    {
        $this->onGenerate('xls');
    }

    public function onGenerateRtf($param = null) 
    {
        $this->onGenerate('rtf');
    }

    /**
     * Register the filter in the session
     */
    public function getFilters()
    {
        // get the search form data
        $data = $this->form->getData();

        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->pessoa_id) AND ( (is_scalar($data->pessoa_id) AND $data->pessoa_id !== '') OR (is_array($data->pessoa_id) AND (!empty($data->pessoa_id)) )) )
        {

            $filters[] = new TFilter('pessoa_id', '=', $data->pessoa_id);// create the filter 
        }
        if (isset($data->tipo_conta_id) AND ( (is_scalar($data->tipo_conta_id) AND $data->tipo_conta_id !== '') OR (is_array($data->tipo_conta_id) AND (!empty($data->tipo_conta_id)) )) )
        {

            $filters[] = new TFilter('tipo_conta_id', '=', $data->tipo_conta_id);// create the filter 
        }
        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }
        if (isset($data->forma_pagamento_id) AND ( (is_scalar($data->forma_pagamento_id) AND $data->forma_pagamento_id !== '') OR (is_array($data->forma_pagamento_id) AND (!empty($data->forma_pagamento_id)) )) )
        {

            $filters[] = new TFilter('forma_pagamento_id', '=', $data->forma_pagamento_id);// create the filter 
        }
        if (isset($data->dt_vencimento) AND ( (is_scalar($data->dt_vencimento) AND $data->dt_vencimento !== '') OR (is_array($data->dt_vencimento) AND (!empty($data->dt_vencimento)) )) )
        {

            $filters[] = new TFilter('dt_vencimento', '>=', $data->dt_vencimento);// create the filter 
        }
        if (isset($data->dt_vencimento_final) AND ( (is_scalar($data->dt_vencimento_final) AND $data->dt_vencimento_final !== '') OR (is_array($data->dt_vencimento_final) AND (!empty($data->dt_vencimento_final)) )) )
        {

            $filters[] = new TFilter('dt_vencimento', '<=', $data->dt_vencimento_final);// create the filter 
        }
        if (isset($data->dt_emissao) AND ( (is_scalar($data->dt_emissao) AND $data->dt_emissao !== '') OR (is_array($data->dt_emissao) AND (!empty($data->dt_emissao)) )) )
        {

            $filters[] = new TFilter('dt_emissao', '>=', $data->dt_emissao);// create the filter 
        }
        if (isset($data->dt_emissao_final) AND ( (is_scalar($data->dt_emissao_final) AND $data->dt_emissao_final !== '') OR (is_array($data->dt_emissao_final) AND (!empty($data->dt_emissao_final)) )) )
        {

            $filters[] = new TFilter('dt_emissao', '<=', $data->dt_emissao_final);// create the filter 
        }
        if (isset($data->dt_pagamento) AND ( (is_scalar($data->dt_pagamento) AND $data->dt_pagamento !== '') OR (is_array($data->dt_pagamento) AND (!empty($data->dt_pagamento)) )) )
        {

            $filters[] = new TFilter('dt_pagamento', '>=', $data->dt_pagamento);// create the filter 
        }
        if (isset($data->dt_pagamento_final) AND ( (is_scalar($data->dt_pagamento_final) AND $data->dt_pagamento_final !== '') OR (is_array($data->dt_pagamento_final) AND (!empty($data->dt_pagamento_final)) )) )
        {

            $filters[] = new TFilter('dt_pagamento', '<=', $data->dt_pagamento_final);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);

        return $filters;
    }

    public function onGenerate($format)
    {
        try
        {
            $filters = $this->getFilters();
            // open a transaction with database 'minierp'
            TTransaction::open(self::$database);
            $param = [];
            // creates a repository for Conta
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = new TCriteria;

            $criteria->setProperties($param);

            if ($filters)
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            if ($objects)
            {
                $widths = array(200,200,200,200,200,200,200,200,200);

                switch ($format)
                {
                    case 'html':
                        $tr = new TTableWriterHTML($widths);
                        break;
                    case 'xls':
                        $tr = new TTableWriterXLS($widths);
                        break;
                    case 'pdf':
                        $tr = new TTableWriterPDF($widths, 'L', 'A4');
                        break;
                    case 'rtf':
                        if (!class_exists('PHPRtfLite_Autoloader'))
                        {
                            PHPRtfLite::registerAutoloader();
                        }
                        $tr = new TTableWriterRTF($widths, 'L', 'A4');
                        break;
                }

                if (!empty($tr))
                {
                    // create the document styles
                    $tr->addStyle('title', 'Helvetica', '10', 'B',   '#000000', '#dbdbdb');
                    $tr->addStyle('datap', 'Arial', '10', '',    '#333333', '#f0f0f0');
                    $tr->addStyle('datai', 'Arial', '10', '',    '#333333', '#ffffff');
                    $tr->addStyle('header', 'Helvetica', '16', 'B',   '#5a5a5a', '#6B6B6B');
                    $tr->addStyle('footer', 'Helvetica', '10', 'B',  '#5a5a5a', '#A3A3A3');
                    $tr->addStyle('break', 'Helvetica', '10', 'B',  '#ffffff', '#9a9a9a');
                    $tr->addStyle('total', 'Helvetica', '10', 'I',  '#000000', '#c7c7c7');
                    $tr->addStyle('breakTotal', 'Helvetica', '10', 'I',  '#000000', '#c6c8d0');

                    // add titles row
                    $tr->addRow();
                    $tr->addCell("Pessoa", 'left', 'title');
                    $tr->addCell("Tipo", 'left', 'title');
                    $tr->addCell("Categoria", 'left', 'title');
                    $tr->addCell("Forma de pagamento", 'left', 'title');
                    $tr->addCell("Emissão", 'left', 'title');
                    $tr->addCell("Vencimento", 'left', 'title');
                    $tr->addCell("Pagamento", 'left', 'title');
                    $tr->addCell("Parcela", 'left', 'title');
                    $tr->addCell("Valor", 'left', 'title');

                    $grandTotal = [];
                    $breakTotal = [];
                    $breakValue = null;
                    $firstRow = true;

                    // controls the background filling
                    $colour = false;                
                    foreach ($objects as $object)
                    {
                        $style = $colour ? 'datap' : 'datai';

                        $firstRow = false;

                        $object->dt_emissao = call_user_func(function($value, $object, $row) 
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
                        }, $object->dt_emissao, $object, null);

                        $object->dt_vencimento = call_user_func(function($value, $object, $row) 
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
                        }, $object->dt_vencimento, $object, null);

                        $object->dt_pagamento = call_user_func(function($value, $object, $row) 
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
                        }, $object->dt_pagamento, $object, null);

                        $object->valor = call_user_func(function($value, $object, $row) 
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
                        }, $object->valor, $object, null);

                        $tr->addRow();

                        $tr->addCell($object->pessoa->nome, 'left', $style);
                        $tr->addCell($object->tipo_conta->nome, 'left', $style);
                        $tr->addCell($object->categoria->nome, 'left', $style);
                        $tr->addCell($object->forma_pagamento->nome, 'left', $style);
                        $tr->addCell($object->dt_emissao, 'left', $style);
                        $tr->addCell($object->dt_vencimento, 'left', $style);
                        $tr->addCell($object->dt_pagamento, 'left', $style);
                        $tr->addCell($object->parcela, 'left', $style);
                        $tr->addCell($object->valor, 'left', $style);

                        $colour = !$colour;

                    }

                    $file = 'report_'.uniqid().".{$format}";
                    // stores the file
                    if (!file_exists("app/output/{$file}") || is_writable("app/output/{$file}"))
                    {
                        $tr->save("app/output/{$file}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/{$file}");
                    }

                    parent::openFile("app/output/{$file}");

                    // shows the success message
                    new TMessage('info', _t('Report generated. Please, enable popups'));
                }
            }
            else
            {
                new TMessage('error', _t('No records found'));
            }

            // close the transaction
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
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

