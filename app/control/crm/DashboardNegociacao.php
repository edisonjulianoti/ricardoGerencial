<?php

class DashboardNegociacao extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_DashboardNegociacao';

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

        $criteria_total_em_negociacao = new TCriteria();
        $criteria_total_finalizado = new TCriteria();
        $criteria_negociacoes_por_etapa = new TCriteria();
        $criteria_origens_de_contato = new TCriteria();
        $criteria_total_finalizado_por_mes = new TCriteria();

        $filterVar = [EtapaNegociacao::CANCELADA, EtapaNegociacao::FINALIZADA];
        $criteria_total_em_negociacao->add(new TFilter('negociacao.etapa_negociacao_id', 'not in', $filterVar)); 
        $filterVar = EtapaNegociacao::FINALIZADA;
        $criteria_total_finalizado->add(new TFilter('negociacao.etapa_negociacao_id', '=', $filterVar)); 
        $filterVar = EtapaNegociacao::FINALIZADA;
        $criteria_total_finalizado_por_mes->add(new TFilter('negociacao.etapa_negociacao_id', '=', $filterVar)); 

        $mes = new TCombo('mes');
        $ano = new TCombo('ano');
        $button_buscar = new TButton('button_buscar');
        $total_em_negociacao = new BIndicator('total_em_negociacao');
        $total_finalizado = new BIndicator('total_finalizado');
        $negociacoes_por_etapa = new BPieChart('negociacoes_por_etapa');
        $origens_de_contato = new BPieChart('origens_de_contato');
        $total_finalizado_por_mes = new BBarChart('total_finalizado_por_mes');


        $button_buscar->setAction(new TAction(['DashboardNegociacao', 'onShow']), "Buscar");
        $button_buscar->addStyleClass('btn-primary');
        $button_buscar->setImage('fas:search #FFFFFF');
        $mes->setSize('100%');
        $ano->setSize('100%');

        $ano->addItems(TempoService::getAnos());
        $mes->addItems(TempoService::getMeses());

        $mes->setValue($param["mes"] ?? date('m'));
        $ano->setValue($param["ano"] ?? date('Y'));

        $mes->enableSearch();
        $ano->enableSearch();


        $total_em_negociacao->setDatabase('minierp');
        $total_em_negociacao->setFieldValue("negociacao.valor_total");
        $total_em_negociacao->setModel('Negociacao');
        $total_em_negociacao->setTransformerValue(function($value)
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
        $total_em_negociacao->setTotal('sum');
        $total_em_negociacao->setColors('#0984E3', '#ffffff', '#74B9FF', '#ffffff');
        $total_em_negociacao->setTitle("Total em negociação", '#ffffff', '20', '');
        $total_em_negociacao->setCriteria($criteria_total_em_negociacao);
        $total_em_negociacao->setIcon(new TImage('fas:shopping-basket #ffffff'));
        $total_em_negociacao->setValueSize("20");
        $total_em_negociacao->setValueColor("#ffffff", 'B');
        $total_em_negociacao->setSize('100%', 95);
        $total_em_negociacao->setLayout('horizontal', 'left');

        $total_finalizado->setDatabase('minierp');
        $total_finalizado->setFieldValue("negociacao.valor_total");
        $total_finalizado->setModel('Negociacao');
        $total_finalizado->setTransformerValue(function($value)
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
        $total_finalizado->setTotal('sum');
        $total_finalizado->setColors('#10AC84', '#FFFFFF', '#1DD1A1', '#FFFFFF');
        $total_finalizado->setTitle("Total finalizado", '#FFFFFF', '20', '');
        $total_finalizado->setCriteria($criteria_total_finalizado);
        $total_finalizado->setIcon(new TImage('fas:shopping-basket #FFFFFF'));
        $total_finalizado->setValueSize("20");
        $total_finalizado->setValueColor("#FFFFFF", 'B');
        $total_finalizado->setSize('100%', 95);
        $total_finalizado->setLayout('horizontal', 'left');

        $negociacoes_por_etapa->setDatabase('minierp');
        $negociacoes_por_etapa->setFieldValue("negociacao.id");
        $negociacoes_por_etapa->setFieldGroup("etapa_negociacao.nome");
        $negociacoes_por_etapa->setModel('Negociacao');
        $negociacoes_por_etapa->setTitle("Negociações por Etapa");
        $negociacoes_por_etapa->setJoins([
             'etapa_negociacao' => ['negociacao.etapa_negociacao_id', 'etapa_negociacao.id']
        ]);
        $negociacoes_por_etapa->setTotal('count');
        $negociacoes_por_etapa->showLegend(true);
        $negociacoes_por_etapa->enableOrderByValue('asc');
        $negociacoes_por_etapa->setCriteria($criteria_negociacoes_por_etapa);
        $negociacoes_por_etapa->setSize('100%', 250);
        $negociacoes_por_etapa->disableZoom();

        $origens_de_contato->setDatabase('minierp');
        $origens_de_contato->setFieldValue("negociacao.id");
        $origens_de_contato->setFieldGroup("origem_contato.nome");
        $origens_de_contato->setModel('Negociacao');
        $origens_de_contato->setTitle("Negociações por origem de Contato");
        $origens_de_contato->setJoins([
             'origem_contato' => ['negociacao.origem_contato_id', 'origem_contato.id']
        ]);
        $origens_de_contato->setTotal('count');
        $origens_de_contato->showLegend(true);
        $origens_de_contato->enableOrderByValue('asc');
        $origens_de_contato->setCriteria($criteria_origens_de_contato);
        $origens_de_contato->setSize('100%', 250);
        $origens_de_contato->disableZoom();

        $total_finalizado_por_mes->setDatabase('minierp');
        $total_finalizado_por_mes->setFieldValue("negociacao.valor_total");
        $total_finalizado_por_mes->setFieldGroup(["negociacao.mes"]);
        $total_finalizado_por_mes->setModel('Negociacao');
        $total_finalizado_por_mes->setTitle("Valor total de negociações por mês");
        $total_finalizado_por_mes->setTransformerLegend(function($value, $row, $data)
            {

                $value = str_pad($value, 2, "0", STR_PAD_LEFT);
                $meses = TempoService::getMeses();

                return $meses[$value] ?? '';

            });
        $total_finalizado_por_mes->setTransformerValue(function($value, $row, $data)
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
        $total_finalizado_por_mes->setLayout('vertical');
        $total_finalizado_por_mes->setTotal('sum');
        $total_finalizado_por_mes->showLegend(true);
        $total_finalizado_por_mes->setCriteria($criteria_total_finalizado_por_mes);
        $total_finalizado_por_mes->setLabelValue("Valor total");
        $total_finalizado_por_mes->setSize('100%', 250);
        $total_finalizado_por_mes->disableZoom();

        $row1 = $this->form->addFields([new TLabel("Mês:", null, '14px', null, '100%'),$mes],[new TLabel("Ano:", null, '14px', null, '100%'),$ano],[new TLabel(" ", null, '14px', null, '100%'),$button_buscar]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-6'];

        $row2 = $this->form->addFields([$total_em_negociacao],[$total_finalizado]);
        $row2->layout = [' col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([$negociacoes_por_etapa],[$origens_de_contato]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([$total_finalizado_por_mes]);
        $row4->layout = [' col-sm-12'];

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
            $criteria_total_em_negociacao->add(new TFilter('negociacao.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_em_negociacao->add(new TFilter('negociacao.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_total_finalizado->add(new TFilter('negociacao.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_finalizado->add(new TFilter('negociacao.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_negociacoes_por_etapa->add(new TFilter('negociacao.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_negociacoes_por_etapa->add(new TFilter('negociacao.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_origens_de_contato->add(new TFilter('negociacao.mes', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_origens_de_contato->add(new TFilter('negociacao.ano', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_total_finalizado_por_mes->add(new TFilter('negociacao.ano', '=', $filterVar)); 
        }

        BChart::generate($total_em_negociacao, $total_finalizado, $negociacoes_por_etapa, $origens_de_contato, $total_finalizado_por_mes);

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["CRM","Dashboard"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

