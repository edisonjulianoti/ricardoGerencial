<?php
/**
 * NegociacaoAtividadeGlobalCalendarForm Form
 * @author  <your name here>
 */
class NegociacaoAtividadeGlobalCalendarFormView extends TPage
{
    private $fc;

    /**
     * Page constructor
     */
    public function __construct($param = null)
    {
        parent::__construct();

        TSession::setValue(__CLASS__.'load_filter_tipo_atividade_id', null);
        TSession::setValue(__CLASS__.'load_filter_negociacao_id', null);
        TSession::setValue(__CLASS__.'load_filter_negociacao_id_1', null);

        $this->fc = new TFullCalendar(date('Y-m-d'), 'month');
        $this->fc->enableDays([1,2,3,4,5]);
        $this->fc->setReloadAction(new TAction(array($this, 'getEvents'), $param));
        $this->fc->setDayClickAction(new TAction(array('NegociacaoAtividadeGlobalCalendarForm', 'onStartEdit')));
        $this->fc->setEventClickAction(new TAction(array('NegociacaoAtividadeGlobalCalendarForm', 'onEdit')));
        $this->fc->setEventUpdateAction(new TAction(array('NegociacaoAtividadeGlobalCalendarForm', 'onUpdateEvent')));
        $this->fc->setCurrentView('agendaWeek');
        $this->fc->setTimeRange('07:00', '19:00');
        $this->fc->enablePopover('Informações', " {descricao}  <br> {observacao} ");
        $this->fc->setOption('slotTime', "00:30:00");
        $this->fc->setOption('slotDuration', "00:30:00");
        $this->fc->setOption('slotLabelInterval', 30);

        TSession::setValue(__CLASS__.'load_filter_negociacao_id_1', null);

        parent::add( $this->fc );
    }

    /**
     * Output events as an json
     */
    public static function getEvents($param=NULL)
    {
        $return = array();
        try
        {
            TTransaction::open('minierp');

            $criteria = new TCriteria(); 

            $criteria->add(new TFilter('horario_inicial', '<=', substr($param['end'], 0, 10).' 23:59:59'));
            $criteria->add(new TFilter('horario_final', '>=', substr($param['start'], 0, 10).' 00:00:00'));

            if(!empty($param['clear_session_filters']))
            {
                TSession::setValue(__CLASS__.'load_filter_tipo_atividade_id', null);
                TSession::setValue(__CLASS__.'load_filter_negociacao_id', null);
                TSession::setValue(__CLASS__.'load_filter_negociacao_id_1', null);
            }

            if(!empty($param["tipo_atividade_id"]))
        {
            TSession::setValue(__CLASS__.'load_filter_tipo_atividade_id', $param["tipo_atividade_id"]);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_tipo_atividade_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteria->add(new TFilter('tipo_atividade_id', '=', $filterVar)); 
            }
            if(!empty($param["cliente_id"]))
        {
            TSession::setValue(__CLASS__.'load_filter_negociacao_id', $param["cliente_id"]);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_negociacao_id');

            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteria->add(new TFilter('negociacao_id', 'in', "(SELECT id FROM negociacao WHERE cliente_id = '{$filterVar}')")); 
            }
            if(!empty($param["vendedor_id"] ?? ""))
        {
            TSession::setValue(__CLASS__.'load_filter_negociacao_id_1', $param["vendedor_id"] ?? "");
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_negociacao_id_1');

            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteria->add(new TFilter('negociacao_id', 'in', "(SELECT id FROM negociacao WHERE vendedor_id = '{$filterVar}')")); 
            }

            $events = NegociacaoAtividade::getObjects($criteria);

            if ($events)
            {
                foreach ($events as $event)
                {
                    $event_array = $event->toArray();
                    $event_array['start'] = str_replace( ' ', 'T', $event_array['horario_inicial']);
                    $event_array['end'] = str_replace( ' ', 'T', $event_array['horario_final']);
                    $event_array['id'] = $event->id;
                    $event_array['color'] = $event->render("{tipo_atividade->cor}");
                    $event_array['title'] = TFullCalendar::renderPopover($event->render("{tipo_atividade->icone_formatado}  -  {tipo_atividade->nome} ({negociacao->cliente->nome})<br>
V:  {negociacao->vendedor->nome} "), $event->render("Informações"), $event->render(" {descricao}  <br> {observacao} "));

                    $return[] = $event_array;
                }
            }
            TTransaction::close();
            echo json_encode($return);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Reconfigure the callendar
     */
    public function onReload($param = null)
    {
        if (isset($param['view']))
        {
            $this->fc->setCurrentView($param['view']);
        }

        if (isset($param['date']))
        {
            $this->fc->setCurrentDate($param['date']);
        }
    }

}

