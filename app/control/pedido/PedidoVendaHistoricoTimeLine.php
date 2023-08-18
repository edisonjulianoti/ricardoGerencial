<?php

class PedidoVendaHistoricoTimeLine extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'PedidoVendaHistorico';
    private static $primaryKey = 'id';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null )
    {
        try
        {
            parent::__construct();

            TTransaction::open(self::$database);

            if(!empty($param['target_container']))
            {
                $this->adianti_target_container = $param['target_container'];
            }

            $this->timeline = new TTimeline;
            $this->timeline->setItemDatabase(self::$database);
            $this->timelineCriteria = new TCriteria;

            if(!empty($param['key']))
        {
            TSession::setValue(__CLASS__.'load_filter_pedido_venda_id', $param['key']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_pedido_venda_id');
            $this->timelineCriteria->add(new TFilter('pedido_venda_id', '=', $filterVar));

            $limit = 0;

            $this->timelineCriteria->setProperty('limit', $limit);
            $this->timelineCriteria->setProperty('order', 'id asc');

            $objects = PedidoVendaHistorico::getObjects($this->timelineCriteria);

            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $object->estado_pedido_venda->nome = call_user_func(function($value, $object, $row)
                    {

                        return "<span class='label label-default' style='width:170px; background-color:{$object->estado_pedido_venda->cor}'> {$object->estado_pedido_venda->nome} <span>";

                    }, $object->estado_pedido_venda->nome, $object, null);

                    $id = $object->id;
                    $title = "{estado_pedido_venda->nome}";
                    $htmlTemplate = "<b>Aprovador</b> <br>
{aprovador->system_user->name} <br>
<b>Observações</b> <br>
 {obs}  ";
                    $date = $object->data_operacao;
                    $icon = 'fa:arrow-left bg-green';
                    $position = 'left';

                    if(empty($positionValue[$object->estado_pedido_venda_id]))
                    {
                        $lastPosition = (empty($lastPosition) || $lastPosition == 'right') ? 'left' : 'right';
                        $bg = ($lastPosition == 'left') ? 'bg-green' : 'bg-blue';

                        $positionValue[$object->estado_pedido_venda_id]['position'] = $lastPosition;
                        $positionValue[$object->estado_pedido_venda_id]['bg'] = $bg;
                        $position = $positionValue[$object->estado_pedido_venda_id]['position'];
                        $icon = "fa:arrow-{$lastPosition} {$bg}";
                    }
                    else
                    {
                        $position = $positionValue[$object->estado_pedido_venda_id]['position'];
                        $lastPosition = $position;
                        $icon = "fa:arrow-{$lastPosition} {$positionValue[$object->estado_pedido_venda_id]['bg']}";
                    }

                    $this->timeline->addItem($id, $title, $htmlTemplate, $date, $icon, $position, $object);

                }
            }

            $this->timeline->setUseBothSides();
            $this->timeline->setTimeDisplayMask('dd/mm/yyyy');
            $this->timeline->setFinalIcon( 'fas:flag-checkered #ffffff #de1414' );

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {    
                $container->add(TBreadCrumb::create(["Pedido","Linha do tempo de histórico de pedido de venda"]));
            }
            $container->add($this->timeline);

            TTransaction::close();

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

