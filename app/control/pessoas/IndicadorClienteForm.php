<?php

class IndicadorClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_IndicadorClienteForm';

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
        $this->form->setFormTitle("");

        $criteria_quantidade_de_pedidos = new TCriteria();
        $criteria_total_vendas_pedido = new TCriteria();

        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_quantidade_de_pedidos->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 
        if(!empty($param['cliente_id']))
        {
            TSession::setValue(__CLASS__.'load_filter_cliente_id', $param['cliente_id']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_cliente_id');
        $criteria_quantidade_de_pedidos->add(new TFilter('pedido_venda.cliente_id', '=', $filterVar)); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_total_vendas_pedido->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 
        if(!empty($param['cliente_id']))
        {
            TSession::setValue(__CLASS__.'load_filter_cliente_id', $param['cliente_id']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_cliente_id');
        $criteria_total_vendas_pedido->add(new TFilter('pedido_venda.cliente_id', '=', $filterVar)); 

        $quantidade_de_pedidos = new BIndicator('quantidade_de_pedidos');
        $total_vendas_pedido = new BIndicator('total_vendas_pedido');

        $quantidade_de_pedidos->setDatabase('minierp');
        $quantidade_de_pedidos->setFieldValue("pedido_venda.id");
        $quantidade_de_pedidos->setModel('PedidoVenda');
        $quantidade_de_pedidos->setTotal('count');
        $quantidade_de_pedidos->setColors('#74B9FF', '#ffffff', '#0984E3', '#ffffff');
        $quantidade_de_pedidos->setTitle("QTD PEDIDOS", '#ffffff', '20', '');
        $quantidade_de_pedidos->setCriteria($criteria_quantidade_de_pedidos);
        $quantidade_de_pedidos->setIcon(new TImage('fas:shopping-basket #ffffff'));
        $quantidade_de_pedidos->setValueSize("20");
        $quantidade_de_pedidos->setValueColor("#ffffff", 'B');
        $quantidade_de_pedidos->setSize('100%', 95);
        $quantidade_de_pedidos->setLayout('horizontal', 'left');

        $total_vendas_pedido->setDatabase('minierp');
        $total_vendas_pedido->setFieldValue("pedido_venda.valor_total");
        $total_vendas_pedido->setModel('PedidoVenda');
        $total_vendas_pedido->setTransformerValue(function($value)
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
        });
        $total_vendas_pedido->setTotal('sum');
        $total_vendas_pedido->setColors('#2ECC71', '#FFFFFF', '#27AE60', '#FFFFFF');
        $total_vendas_pedido->setTitle("TOTAL R$ PEDIDOS", '#FFFFFF', '20', '');
        $total_vendas_pedido->setCriteria($criteria_total_vendas_pedido);
        $total_vendas_pedido->setIcon(new TImage('fas:money-bill-wave #FFFFFF'));
        $total_vendas_pedido->setValueSize("20");
        $total_vendas_pedido->setValueColor("#FFFFFF", 'B');
        $total_vendas_pedido->setSize('100%', 95);
        $total_vendas_pedido->setLayout('horizontal', 'left');

        $row1 = $this->form->addFields([$quantidade_de_pedidos],[$total_vendas_pedido]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $searchData = $this->form->getData();
        $this->form->setData($searchData);

        BChart::generate($quantidade_de_pedidos, $total_vendas_pedido);

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Pessoas","Indicadores de Cliente"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

