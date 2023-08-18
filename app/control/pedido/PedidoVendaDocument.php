<?php

class PedidoVendaDocument extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVenda';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/PedidoVendaDocumentTemplate.html';

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

            $criteria_PedidoVendaItem_pedido_venda_id = new TCriteria();
            $criteria_PedidoVendaItem_pedido_venda_id->add(new TFilter('pedido_venda_id', '=', $param['key']));

            $objectsPedidoVendaItem_pedido_venda_id = PedidoVendaItem::getObjects($criteria_PedidoVendaItem_pedido_venda_id);
            $html->setDetail('PedidoVendaItem.pedido_venda_id', $objectsPedidoVendaItem_pedido_venda_id);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            $object->dt_pedido = TDate::date2br($object->dt_pedido);

            if($objectsPedidoVendaItem_pedido_venda_id)
            {
                foreach($objectsPedidoVendaItem_pedido_venda_id as $item)
                {
                    if(!$item->desconto)
                    {
                        $item->desconto = '0.00';
                    }
                }
            }

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

