<?php

class PessoaContaReceberEmAbertoDocument extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/PessoaContaReceberEmAbertoDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $criteria_Conta_pessoa_id = new TCriteria();
            $criteria_Conta_pessoa_id->add(new TFilter('pessoa_id', '=', $param['key']));

            $criteria_Conta_pessoa_id->add(new TFilter('tipo_conta_id', '=', TipoConta::RECEBER));
            $criteria_Conta_pessoa_id->add(new TFilter('dt_pagamento', 'is', NULL));

            $objectsConta_pessoa_id = Conta::getObjects($criteria_Conta_pessoa_id);
            $html->setDetail('Conta.pessoa_id', $objectsConta_pessoa_id);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            $object->total = 0;

            if($objectsConta_pessoa_id)
            {
                foreach($objectsConta_pessoa_id as $conta)
                {
                    $object->total += $conta->valor;

                    $conta->dt_emissao = TDate::date2br($conta->dt_emissao);
                    $conta->dt_vencimento = TDate::date2br($conta->dt_vencimento);
                    $conta->valor = number_format($conta->valor, 2, ',', '.');
                }
            }

            $object->total = number_format($object->total, 2, ',', '.');

            $html->process();

            $html->saveAsPDF($document, $pageSize, 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

