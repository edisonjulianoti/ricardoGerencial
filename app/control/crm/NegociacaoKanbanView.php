<?php

class NegociacaoKanbanView extends TPage
{
    private static $database = 'minierp';
    private static $activeRecord = 'Negociacao';
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
            $criteriaItem->setProperty('order', 'ordem asc');

            $filterVar = "T";
            $criteriaStage->add(new TFilter('kanban', '=', $filterVar)); 

            TSession::setValue(__CLASS__.'load_filter_cliente_id', null);
            TSession::setValue(__CLASS__.'load_filter_vendedor_id', null);
            TSession::setValue(__CLASS__.'load_filter_origem_contato_id', null);

            if(!empty($param["cliente_id"] ?? ""))
        {
            TSession::setValue(__CLASS__.'load_filter_cliente_id', $param["cliente_id"] ?? "");
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_cliente_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('cliente_id', '=', $filterVar)); 
            }
            if(!empty($param["vendedor_id"] ?? ""))
        {
            TSession::setValue(__CLASS__.'load_filter_vendedor_id', $param["vendedor_id"] ?? "");
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_vendedor_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('vendedor_id', '=', $filterVar)); 
            }
            if(!empty($param["origem_contato_id"] ?? ""))
        {
            TSession::setValue(__CLASS__.'load_filter_origem_contato_id', $param["origem_contato_id"] ?? "");
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_origem_contato_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('origem_contato_id', '=', $filterVar)); 
            }

            $filterVar = [EtapaNegociacao::CANCELADA, EtapaNegociacao::FINALIZADA];
            $criteriaItem->add(new TFilter('etapa_negociacao_id', 'not in', $filterVar)); 

            TTransaction::open(self::$database);
            $stages = EtapaNegociacao::getObjects($criteriaStage);
            $items  = Negociacao::getObjects($criteriaItem);

            if($stages)
            {
                foreach ($stages as $key => $stage)
                {

                    $kanban->addStage($stage->id, "{nome}", $stage ,$stage->cor);

                    if ($stage->id == EtapaNegociacao::FINALIZADA)
                    {
                        $criteriaNegociacoesFinalizadas = new TCriteria;
                        $criteriaNegociacoesFinalizadas->add(new TFilter('etapa_negociacao_id', '=', $stage->id));
                        $criteriaNegociacoesFinalizadas->setProperty('limit', 10);
                        $criteriaNegociacoesFinalizadas->setProperty('order', 'updated_at desc, ordem asc');

                        $negociacoesFinalizadas = Negociacao::getObjects($criteriaNegociacoesFinalizadas);
                        $items = array_merge($negociacoesFinalizadas, $items);
                    }

                }    
            }

            if($items)
            {
                foreach ($items as $key => $item)
                {

                    $item->data_inicio = call_user_func(function($value, $object, $row) 
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
                    }, $item->data_inicio, $item, null);

                    $item->data_fechamento_esperada = call_user_func(function($value, $object, $row) 
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
                    }, $item->data_fechamento_esperada, $item, null);

                    $kanban->addItem($item->id, $item->etapa_negociacao_id, "Negociação #{id}", "Nome: <b>{cliente->nome}</b><br/>
Vendedor: <b>{vendedor->nome}</b><br/>
Início: <b>{data_inicio}</b><br/>
Previsão de finalização: <b>{data_fechamento_esperada}</b>", '', $item);

                }    
            }

            $kanbanItemAction_NegociacaoFormView_onShow = new TAction(['NegociacaoFormView', 'onShow']);
            $kanbanItemAction_NegociacaoFormView_onShow->setParameter("target_container", "adianti_div_content");

            $kanban->addItemAction("Visualizar", $kanbanItemAction_NegociacaoFormView_onShow, 'fas:search-plus #00BCD4', null, true);

            //$kanban->setTemplatePath('app/resources/card.html');

            $kanban->setItemDropAction(new TAction([__CLASS__, 'onUpdateItemDrop']));
            TTransaction::close();

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {
                $container->add(TBreadCrumb::create(["CRM","Kanban de negociação"]));
            }
            $container->add($kanban);

            TScript::create("
               const slider = document.querySelector('.kanban-board-wrapper');
                let isDown = false;
                let startX;
                let scrollLeft;

                slider.addEventListener('mousedown', (e) => {
                  isDown = true;
                  slider.classList.add('active');
                  startX = e.pageX - slider.offsetLeft;
                  scrollLeft = slider.scrollLeft;
                });
                slider.addEventListener('mouseleave', () => {
                  isDown = false;
                  slider.classList.remove('active');
                });
                slider.addEventListener('mouseup', () => {
                  isDown = false;
                  slider.classList.remove('active');
                });
                slider.addEventListener('mousemove', (e) => {
                  if(!isDown) return;
                  e.preventDefault();
                  const x = e.pageX - slider.offsetLeft;
                  const walk = (x - startX) * 3; 
                  slider.scrollLeft = scrollLeft - walk;
                });
            ");

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Update item on drop
     */
    public static function onUpdateItemDrop($param)
    {
        try
        {
            TTransaction::open(self::$database);

            if (!empty($param['order']))
            {
                foreach ($param['order'] as $key => $id)
                {
                    $sequence = ++$key;

                    $item = new Negociacao($id);
                    $item->ordem = $sequence;
                    $item->etapa_negociacao_id = $param['stage_id'];

                    $item->store();

                }

                TTransaction::close();
            }
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }
    public function onShow($param = null)
    {

    } 

}

