<?php

class PedidoVendaKanbanView extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVenda';
    private static $primaryKey = 'id';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        try
        {
            parent::__construct();

            $kanban = new TKanban;
            $kanban->setItemDatabase(self::$database);

            $criteriaStage = new TCriteria();
            $criteriaItem = new TCriteria();

            $criteriaStage->setProperty('order', 'ordem asc');
            $criteriaItem->setProperty('order', 'id desc');

            $filterVar = "T";
            $criteriaStage->add(new TFilter('kanban', '=', $filterVar)); 

            TSession::setValue(__CLASS__.'load_filter_cliente_id', null);
            TSession::setValue(__CLASS__.'load_filter_vendedor_id', null);
            TSession::setValue(__CLASS__.'load_filter_ano', null);
            TSession::setValue(__CLASS__.'load_filter_mes', null);

            if(!empty($param['cliente_id']))
        {
            TSession::setValue(__CLASS__.'load_filter_cliente_id', $param['cliente_id']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_cliente_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('cliente_id', '=', $filterVar)); 
            }
            if(!empty($param['vendedor_id']))
        {
            TSession::setValue(__CLASS__.'load_filter_vendedor_id', $param['vendedor_id']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_vendedor_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('vendedor_id', '=', $filterVar)); 
            }
            if(!empty($param['ano']))
        {
            TSession::setValue(__CLASS__.'load_filter_ano', $param['ano']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_ano');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('ano', '=', $filterVar)); 
            }
            if(!empty($param['mes']))
        {
            TSession::setValue(__CLASS__.'load_filter_mes', $param['mes']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_mes');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('mes', '=', $filterVar)); 
            }

            TTransaction::open(self::$database);
            $stages = EstadoPedidoVenda::getObjects($criteriaStage);
            $items  = PedidoVenda::getObjects($criteriaItem);

            if($stages)
            {
                foreach ($stages as $key => $stage)
                {

                    $kanban->addStage($stage->id, "{nome}", $stage ,$stage->cor);

                }    
            }

            if($items)
            {
                foreach ($items as $key => $item)
                {

                    $item->dt_pedido = call_user_func(function($value, $object, $row) 
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
                    }, $item->dt_pedido, $item, null);

                    $item->valor_total = call_user_func(function($value, $object, $row) 
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
                    }, $item->valor_total, $item, null);

                    $kanban->addItem($item->id, $item->estado_pedido_venda_id, "Pedido #{id}", "<b>Data:</b> {dt_pedido}<br>
<b>Cliente:</b> {cliente->nome}<br>
<b>Vendedor:</b> {vendedor->nome}<br>
<b>Valor total:</b> R$ {valor_total}   ", $item->estado_pedido_venda->cor, $item);

                }    
            }

            $kanbanItemAction_PedidoVendaFormView_onShow = new TAction(['PedidoVendaFormView', 'onShow']);

            $kanban->addItemAction("Visualizar Pedido", $kanbanItemAction_PedidoVendaFormView_onShow, 'fas:search-plus #000000');

            //$kanban->setTemplatePath('app/resources/card.html');

            TTransaction::close();

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {
                $container->add(TBreadCrumb::create(["Pedido","PedidoVendaKanbanView"]));
            }
            $container->add($kanban);

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {

    } 

}

