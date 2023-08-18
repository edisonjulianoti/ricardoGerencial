<?php

class DashboardPedidoVenda extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_DashboardPedidoVenda';

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
        $this->form->setFormTitle("Dashboard");

        $criteria_pedidos_em_elaboracao = new TCriteria();
        $criteria_pedidos_em_analise_comercial = new TCriteria();
        $criteria_pedidos_em_anlise_de_credito = new TCriteria();
        $criteria_pedidos_em_processamento = new TCriteria();
        $criteria_pedidos_em_faturamento = new TCriteria();
        $criteria_pedidos_aguardando_entrega = new TCriteria();
        $criteria_pedidos_finalizados = new TCriteria();
        $criteria_pedidos_cancelados = new TCriteria();
        $criteria_total_de_vendas_por_mes = new TCriteria();
        $criteria_total_de_vendas_por_dia = new TCriteria();
        $criteria_total_por_produto = new TCriteria();
        $criteria_total_familia_produto = new TCriteria();
        $criteria_pedidos = new TCriteria();
        $criteria_total_por_cliente = new TCriteria();

        $filterVar = EstadoPedidoVenda::ELABORACAO;
        $criteria_pedidos_em_elaboracao->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::ANALISE_COMERCIAL;
        $criteria_pedidos_em_analise_comercial->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::ANALISE_FINANCEIRA;
        $criteria_pedidos_em_anlise_de_credito->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::EM_PROCESSAMENTO;
        $criteria_pedidos_em_processamento->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::EM_FATURAMENTO;
        $criteria_pedidos_em_faturamento->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::AGUARDANDO_ENTREGA;
        $criteria_pedidos_aguardando_entrega->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::FINALIZADO;
        $criteria_pedidos_finalizados->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = EstadoPedidoVenda::CANCELADO;
        $criteria_pedidos_cancelados->add(new TFilter('pedido_venda.estado_pedido_venda_id', '=', $filterVar)); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_total_de_vendas_por_mes->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_total_de_vendas_por_dia->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
            $filterVar = is_array($filterVar) ? "'".implode("','", $filterVar)."'" : $filterVar;
        $criteria_total_por_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE estado_pedido_venda_id not in ({$filterVar}))")); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
            $filterVar = is_array($filterVar) ? "'".implode("','", $filterVar)."'" : $filterVar;
        $criteria_total_familia_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE estado_pedido_venda_id not in ({$filterVar}))")); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_pedidos->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 
        $filterVar = [EstadoPedidoVenda::REPROVADO, EstadoPedidoVenda::CANCELADO];
        $criteria_total_por_cliente->add(new TFilter('pedido_venda.estado_pedido_venda_id', 'not in', $filterVar)); 

        $mes = new TCombo('mes');
        $ano = new TCombo('ano');
        $button_buscar = new TButton('button_buscar');
        $pedidos_em_elaboracao = new BIndicator('pedidos_em_elaboracao');
        $pedidos_em_analise_comercial = new BIndicator('pedidos_em_analise_comercial');
        $pedidos_em_anlise_de_credito = new BIndicator('pedidos_em_anlise_de_credito');
        $pedidos_em_processamento = new BIndicator('pedidos_em_processamento');
        $pedidos_em_faturamento = new BIndicator('pedidos_em_faturamento');
        $pedidos_aguardando_entrega = new BIndicator('pedidos_aguardando_entrega');
        $pedidos_finalizados = new BIndicator('pedidos_finalizados');
        $pedidos_cancelados = new BIndicator('pedidos_cancelados');
        $total_de_vendas_por_mes = new BBarChart('total_de_vendas_por_mes');
        $total_de_vendas_por_dia = new BLineChart('total_de_vendas_por_dia');
        $total_por_produto = new BPieChart('total_por_produto');
        $total_familia_produto = new BDonutChart('total_familia_produto');
        $pedidos = new BTableChart('pedidos');
        $total_por_cliente = new BTableChart('total_por_cliente');


        $button_buscar->setAction(new TAction(['DashboardPedidoVenda', 'onShow']), "Buscar");
        $button_buscar->addStyleClass('btn-primary');
        $button_buscar->setImage('fas:search #FFFFFF');
        $mes->setSize('100%');
        $ano->setSize('100%');

        $ano->addItems(TempoService::getAnos());
        $mes->addItems(TempoService::getMeses());

        $mes->setValue($param['mes'] ?? date('m'));
        $ano->setValue($param['ano'] ?? date('Y'));

        $mes->enableSearch();
        $ano->enableSearch();


        $pedidos_em_elaboracao->setDatabase('minierp');
        $pedidos_em_elaboracao->setFieldValue("pedido_venda.valor_total");
        $pedidos_em_elaboracao->setModel('PedidoVenda');
        $pedidos_em_elaboracao->setTransformerValue(function($value)
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
        $pedidos_em_elaboracao->setTotal('sum');
        $pedidos_em_elaboracao->setColors('#81ECEC', '#ffffff', '#00CEC9', '#ffffff');
        $pedidos_em_elaboracao->setTitle("elaboração", '#ffffff', '20', '');
        $pedidos_em_elaboracao->setCriteria($criteria_pedidos_em_elaboracao);
        $pedidos_em_elaboracao->setIcon(new TImage('fas:shopping-basket #ffffff'));
        $pedidos_em_elaboracao->setValueSize("20");
        $pedidos_em_elaboracao->setValueColor("#ffffff", 'B');
        $pedidos_em_elaboracao->setSize('100%', 95);
        $pedidos_em_elaboracao->setLayout('horizontal', 'left');

        $pedidos_em_analise_comercial->setDatabase('minierp');
        $pedidos_em_analise_comercial->setFieldValue("pedido_venda.valor_total");
        $pedidos_em_analise_comercial->setModel('PedidoVenda');
        $pedidos_em_analise_comercial->setTransformerValue(function($value)
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
        $pedidos_em_analise_comercial->setTotal('sum');
        $pedidos_em_analise_comercial->setColors('#FF9FF3', '#FFFFFF', '#F368E0', '#FFFFFF');
        $pedidos_em_analise_comercial->setTitle("análise comercial", '#FFFFFF', '20', '');
        $pedidos_em_analise_comercial->setCriteria($criteria_pedidos_em_analise_comercial);
        $pedidos_em_analise_comercial->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_em_analise_comercial->setValueSize("20");
        $pedidos_em_analise_comercial->setValueColor("#FFFFFF", 'B');
        $pedidos_em_analise_comercial->setSize('100%', 95);
        $pedidos_em_analise_comercial->setLayout('horizontal', 'left');

        $pedidos_em_anlise_de_credito->setDatabase('minierp');
        $pedidos_em_anlise_de_credito->setFieldValue("pedido_venda.valor_total");
        $pedidos_em_anlise_de_credito->setModel('PedidoVenda');
        $pedidos_em_anlise_de_credito->setTransformerValue(function($value)
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
        $pedidos_em_anlise_de_credito->setTotal('sum');
        $pedidos_em_anlise_de_credito->setColors('#FECA57', '#FFFFFF', '#FF9F43', '#FFFFFF');
        $pedidos_em_anlise_de_credito->setTitle("análise de crédito", '#FFFFFF', '20', '');
        $pedidos_em_anlise_de_credito->setCriteria($criteria_pedidos_em_anlise_de_credito);
        $pedidos_em_anlise_de_credito->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_em_anlise_de_credito->setValueSize("20");
        $pedidos_em_anlise_de_credito->setValueColor("#FFFFFF", 'B');
        $pedidos_em_anlise_de_credito->setSize('100%', 95);
        $pedidos_em_anlise_de_credito->setLayout('horizontal', 'left');

        $pedidos_em_processamento->setDatabase('minierp');
        $pedidos_em_processamento->setFieldValue("pedido_venda.valor_total");
        $pedidos_em_processamento->setModel('PedidoVenda');
        $pedidos_em_processamento->setTransformerValue(function($value)
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
        $pedidos_em_processamento->setTotal('sum');
        $pedidos_em_processamento->setColors('#54A0FF', '#FFFFFF', '#2E86DE', '#FFFFFF');
        $pedidos_em_processamento->setTitle("em processamento", '#FFFFFF', '20', '');
        $pedidos_em_processamento->setCriteria($criteria_pedidos_em_processamento);
        $pedidos_em_processamento->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_em_processamento->setValueSize("20");
        $pedidos_em_processamento->setValueColor("#FFFFFF", 'B');
        $pedidos_em_processamento->setSize('100%', 95);
        $pedidos_em_processamento->setLayout('horizontal', 'left');

        $pedidos_em_faturamento->setDatabase('minierp');
        $pedidos_em_faturamento->setFieldValue("pedido_venda.valor_total");
        $pedidos_em_faturamento->setModel('PedidoVenda');
        $pedidos_em_faturamento->setTransformerValue(function($value)
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
        $pedidos_em_faturamento->setTotal('sum');
        $pedidos_em_faturamento->setColors('#9B59B6', '#FFFFFF', '#8E44AD', '#FFFFFF');
        $pedidos_em_faturamento->setTitle("faturamento", '#FFFFFF', '20', '');
        $pedidos_em_faturamento->setCriteria($criteria_pedidos_em_faturamento);
        $pedidos_em_faturamento->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_em_faturamento->setValueSize("20");
        $pedidos_em_faturamento->setValueColor("#FFFFFF", 'B');
        $pedidos_em_faturamento->setSize('100%', 95);
        $pedidos_em_faturamento->setLayout('horizontal', 'left');

        $pedidos_aguardando_entrega->setDatabase('minierp');
        $pedidos_aguardando_entrega->setFieldValue("pedido_venda.valor_total");
        $pedidos_aguardando_entrega->setModel('PedidoVenda');
        $pedidos_aguardando_entrega->setTransformerValue(function($value)
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
        $pedidos_aguardando_entrega->setTotal('sum');
        $pedidos_aguardando_entrega->setColors('#F39C12', '#FFFFFF', '#F1C40F', '#FFFFFF');
        $pedidos_aguardando_entrega->setTitle("aguardando entrega", '#FFFFFF', '20', '');
        $pedidos_aguardando_entrega->setCriteria($criteria_pedidos_aguardando_entrega);
        $pedidos_aguardando_entrega->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_aguardando_entrega->setValueSize("20");
        $pedidos_aguardando_entrega->setValueColor("#FFFFFF", 'B');
        $pedidos_aguardando_entrega->setSize('100%', 95);
        $pedidos_aguardando_entrega->setLayout('horizontal', 'left');

        $pedidos_finalizados->setDatabase('minierp');
        $pedidos_finalizados->setFieldValue("pedido_venda.valor_total");
        $pedidos_finalizados->setModel('PedidoVenda');
        $pedidos_finalizados->setTransformerValue(function($value)
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
        $pedidos_finalizados->setTotal('sum');
        $pedidos_finalizados->setColors('#2ECC71', '#FFFFFF', '#27AE60', '#FFFFFF');
        $pedidos_finalizados->setTitle("finalizados", '#FFFFFF', '20', '');
        $pedidos_finalizados->setCriteria($criteria_pedidos_finalizados);
        $pedidos_finalizados->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_finalizados->setValueSize("20");
        $pedidos_finalizados->setValueColor("#FFFFFF", 'B');
        $pedidos_finalizados->setSize('100%', 95);
        $pedidos_finalizados->setLayout('horizontal', 'left');

        $pedidos_cancelados->setDatabase('minierp');
        $pedidos_cancelados->setFieldValue("pedido_venda.valor_total");
        $pedidos_cancelados->setModel('PedidoVenda');
        $pedidos_cancelados->setTransformerValue(function($value)
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
        $pedidos_cancelados->setTotal('sum');
        $pedidos_cancelados->setColors('#FF7675', '#FFFFFF', '#D63031', '#FFFFFF');
        $pedidos_cancelados->setTitle("cancelados", '#FFFFFF', '20', '');
        $pedidos_cancelados->setCriteria($criteria_pedidos_cancelados);
        $pedidos_cancelados->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $pedidos_cancelados->setValueSize("20");
        $pedidos_cancelados->setValueColor("#FFFFFF", 'B');
        $pedidos_cancelados->setSize('100%', 95);
        $pedidos_cancelados->setLayout('horizontal', 'left');

        $total_de_vendas_por_mes->setDatabase('minierp');
        $total_de_vendas_por_mes->setFieldValue("pedido_venda.valor_total");
        $total_de_vendas_por_mes->setFieldGroup(["pedido_venda.mes"]);
        $total_de_vendas_por_mes->setModel('PedidoVenda');
        $total_de_vendas_por_mes->setTitle("Total de Vendas por Mês");
        $total_de_vendas_por_mes->setTransformerLegend(function($value, $row, $data)
            {

                $value = str_pad($value, 2, "0", STR_PAD_LEFT);
                $meses = TempoService::getMeses();

                return $meses[$value] ?? '';

            });
        $total_de_vendas_por_mes->setTransformerValue(function($value, $row, $data)
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
        $total_de_vendas_por_mes->setLayout('vertical');
        $total_de_vendas_por_mes->setTotal('sum');
        $total_de_vendas_por_mes->showLegend(false);
        $total_de_vendas_por_mes->setCriteria($criteria_total_de_vendas_por_mes);
        $total_de_vendas_por_mes->setLabelValue("Total no mês");
        $total_de_vendas_por_mes->setSize('100%', 280);
        $total_de_vendas_por_mes->disableZoom();

        $total_de_vendas_por_dia->setDatabase('minierp');
        $total_de_vendas_por_dia->setFieldValue("pedido_venda.valor_total");
        $total_de_vendas_por_dia->setFieldGroup(["pedido_venda.dt_pedido"]);
        $total_de_vendas_por_dia->setModel('PedidoVenda');
        $total_de_vendas_por_dia->setTitle("Total de Vendas por Dia");
        $total_de_vendas_por_dia->setTransformerLegend(function($value, $row, $data)
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
            });
        $total_de_vendas_por_dia->setTransformerValue(function($value, $row, $data)
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
        $total_de_vendas_por_dia->setTotal('sum');
        $total_de_vendas_por_dia->showLegend(false);
        $total_de_vendas_por_dia->setCriteria($criteria_total_de_vendas_por_dia);
        $total_de_vendas_por_dia->setLabelValue("Total no dia");
        $total_de_vendas_por_dia->setRotateLegend('35',60);
        $total_de_vendas_por_dia->setSize('100%', 280);
        $total_de_vendas_por_dia->disableZoom();

        $total_por_produto->setDatabase('minierp');
        $total_por_produto->setFieldValue("pedido_venda_item.valor_total");
        $total_por_produto->setFieldGroup("produto.nome");
        $total_por_produto->setModel('PedidoVendaItem');
        $total_por_produto->setTitle("Total por Produto");
        $total_por_produto->setTransformerValue(function($value, $row, $data)
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
        $total_por_produto->setJoins([
             'produto' => ['pedido_venda_item.produto_id', 'produto.id']
        ]);
        $total_por_produto->setTotal('sum');
        $total_por_produto->showLegend(true);
        $total_por_produto->enableOrderByValue('asc');
        $total_por_produto->setCriteria($criteria_total_por_produto);
        $total_por_produto->setSize('100%', 280);
        $total_por_produto->disableZoom();

        $total_familia_produto->setDatabase('minierp');
        $total_familia_produto->setFieldValue("pedido_venda_item.valor_total");
        $total_familia_produto->setFieldGroup("familia_produto.nome");
        $total_familia_produto->setModel('PedidoVendaItem');
        $total_familia_produto->setTitle("Total por Família de Produto");
        $total_familia_produto->setTransformerValue(function($value, $row, $data)
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
        $total_familia_produto->setJoins([
             'produto' => ['pedido_venda_item.produto_id', 'produto.id'],
             'familia_produto' => ['produto.familia_produto_id', 'familia_produto.id']
        ]);
        $total_familia_produto->setTotal('sum');
        $total_familia_produto->showLegend(true);
        $total_familia_produto->enableOrderByValue('asc');
        $total_familia_produto->setCriteria($criteria_total_familia_produto);
        $total_familia_produto->setSize('100%', 280);
        $total_familia_produto->disableZoom();

        $pedidos_column_id = new BTableColumnChart('id', "Pedidos", 'center','33%');
        $pedidos_column_valor_total = new BTableColumnChart('valor_total', "Total Vendido", 'right','33%');
        $pedidos_column_estado_pedido_venda_id = new BTableColumnChart('estado_pedido_venda_id', "Estado do Pedido", 'center','33%');
        $pedidos_column_id->setTotal('sum');
        $pedidos_column_valor_total->setTotal('sum', function($value, $object, $row)
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
        $pedidos_column_id->setAggregate('count');
        $pedidos_column_valor_total->setAggregate('sum');
        $pedidos_column_valor_total->setTransformer(function($value, $object, $row)
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
        $pedidos_column_estado_pedido_venda_id->setTransformer(function($value, $object, $row)
        {

            TTransaction::open('minierp');
            $estadoPedidoVenda = new EstadoPedidoVenda($value);
            TTransaction::close();

            return "<span class='label label-default' style='background-color:{$estadoPedidoVenda->cor}'> {$estadoPedidoVenda->nome} <span>";

        });

        $pedidos->setDatabase('minierp');
        $pedidos->setModel('PedidoVenda');
        $pedidos->setTitle("Pedidos");
        $pedidos->setSize('100%', 250);
        $pedidos->setColumns([$pedidos_column_id,$pedidos_column_valor_total,$pedidos_column_estado_pedido_venda_id]);
        $pedidos->setCriteria($criteria_pedidos);

        $pedidos->setRowColorOdd('#F9F9F9');
        $pedidos->setRowColorEven('#FFFFFF');
        $pedidos->setFontRowColorOdd('#333333');
        $pedidos->setFontRowColorEven('#333333');
        $pedidos->setBorderColor('#DDDDDD');
        $pedidos->setTableHeaderColor('#FFFFFF');
        $pedidos->setTableHeaderFontColor('#333333');
        $pedidos->setTableFooterColor('#FFFFFF');
        $pedidos->setTableFooterFontColor('#333333');

        $total_por_cliente_column_pessoa_nome = new BTableColumnChart('pessoa.nome', "Cliente", 'left','33%');
        $total_por_cliente_column_id = new BTableColumnChart('id', "Pedidos", 'right');
        $total_por_cliente_column_valor_total = new BTableColumnChart('valor_total', "Valor Total", 'right');
        $total_por_cliente_column_id->setTotal('sum');
        $total_por_cliente_column_valor_total->setTotal('sum', function($value, $object, $row)
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
        $total_por_cliente_column_id->setAggregate('count');
        $total_por_cliente_column_valor_total->setAggregate('sum');
        $total_por_cliente_column_valor_total->setTransformer(function($value, $object, $row)
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

        $total_por_cliente->setDatabase('minierp');
        $total_por_cliente->setModel('PedidoVenda');
        $total_por_cliente->setTitle("Totalizadores por Cliente");
        $total_por_cliente->setSize('100%', 250);
        $total_por_cliente->setColumns([$total_por_cliente_column_pessoa_nome,$total_por_cliente_column_id,$total_por_cliente_column_valor_total]);
        $total_por_cliente->setCriteria($criteria_total_por_cliente);
        $total_por_cliente->setJoins([
             'pessoa' => ['pedido_venda.cliente_id', 'pessoa.id']
        ]);

        $total_por_cliente->setRowColorOdd('#F9F9F9');
        $total_por_cliente->setRowColorEven('#FFFFFF');
        $total_por_cliente->setFontRowColorOdd('#333333');
        $total_por_cliente->setFontRowColorEven('#333333');
        $total_por_cliente->setBorderColor('#DDDDDD');
        $total_por_cliente->setTableHeaderColor('#FFFFFF');
        $total_por_cliente->setTableHeaderFontColor('#333333');
        $total_por_cliente->setTableFooterColor('#FFFFFF');
        $total_por_cliente->setTableFooterFontColor('#333333');

        $row1 = $this->form->addFields([new TLabel("Mês:", null, '14px', null, '100%'),$mes],[new TLabel("Ano:", null, '14px', null),$ano],[new TLabel(" ", null, '14px', null, '100%'),$button_buscar]);
        $row1->layout = [' col-sm-2',' col-sm-2','col-sm-2'];

        $row2 = $this->form->addFields([$pedidos_em_elaboracao],[$pedidos_em_analise_comercial],[$pedidos_em_anlise_de_credito],[$pedidos_em_processamento]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([$pedidos_em_faturamento],[$pedidos_aguardando_entrega],[$pedidos_finalizados],[$pedidos_cancelados]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $this->form->addFields([$total_de_vendas_por_mes]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$total_de_vendas_por_dia]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$total_por_produto],[$total_familia_produto]);
        $row6->layout = [' col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([$pedidos],[$total_por_cliente]);
        $row7->layout = [' col-sm-6','col-sm-6'];

        if(!isset($param['mes']) && $mes->getValue())
        {
            $_POST['mes'] = $mes->getValue();
        }
        if(!isset($param['ano']) && $ano->getValue())
        {
            $_POST['ano'] = $ano->getValue();
        }

        $searchData = $this->form->getData();
        $this->form->setData($searchData);

        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_em_elaboracao->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_em_elaboracao->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_em_analise_comercial->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_em_analise_comercial->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_em_anlise_de_credito->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_em_anlise_de_credito->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_em_processamento->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_em_processamento->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_em_faturamento->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_em_faturamento->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_aguardando_entrega->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_aguardando_entrega->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_finalizados->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_finalizados->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos_cancelados->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos_cancelados->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_de_vendas_por_mes->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_total_de_vendas_por_dia->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_de_vendas_por_dia->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_total_por_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE mes = '$filterVar')")); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_por_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE ano = '$filterVar')")); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_total_familia_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE mes = '$filterVar')")); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_familia_produto->add(new TFilter('pedido_venda_item.pedido_venda_id', 'in', "(SELECT id FROM pedido_venda WHERE ano = '$filterVar')")); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pedidos->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pedidos->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_total_por_cliente->add(new TFilter('pedido_venda.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_por_cliente->add(new TFilter('pedido_venda.ano', '=', $filterVar)); 
        }

        BChart::generate($pedidos_em_elaboracao, $pedidos_em_analise_comercial, $pedidos_em_anlise_de_credito, $pedidos_em_processamento, $pedidos_em_faturamento, $pedidos_aguardando_entrega, $pedidos_finalizados, $pedidos_cancelados, $total_de_vendas_por_mes, $total_de_vendas_por_dia, $total_por_produto, $total_familia_produto, $pedidos, $total_por_cliente);

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Pedido","Dashboard"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

