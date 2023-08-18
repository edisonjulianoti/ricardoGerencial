<?php

class NegociacaoAtividadeCalendarForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'minierp';
    private static $activeRecord = 'NegociacaoAtividade';
    private static $primaryKey = 'id';
    private static $formName = 'form_NegociacaoAtividadeCalendarForm';
    private static $startDateField = 'horario_inicial';
    private static $endDateField = 'horario_final';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.8, null);
        parent::setTitle("Atividades da negociação");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Atividades da negociação");

        $view = new THidden('view');

        $id = new TEntry('id');
        $negociacao_id = new THidden('negociacao_id');
        $tipo_atividade_id = new TDBCombo('tipo_atividade_id', 'minierp', 'TipoAtividade', 'id', '{icone_formatado} {nome}','nome asc'  );
        $descricao = new TEntry('descricao');
        $horario_inicial = new TDateTime('horario_inicial');
        $horario_final = new TDateTime('horario_final');
        $observacao = new TText('observacao');

        $tipo_atividade_id->addValidation("Tipo atividade", new TRequiredValidator()); 

        $id->setEditable(false);
        $negociacao_id->setValue(TSession::getValue('negociacao_id'));
        $tipo_atividade_id->enableSearch();
        $horario_final->setMask('dd/mm/yyyy hh:ii');
        $horario_inicial->setMask('dd/mm/yyyy hh:ii');

        $horario_final->setDatabaseMask('yyyy-mm-dd hh:ii');
        $horario_inicial->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(100);
        $descricao->setSize('100%');
        $negociacao_id->setSize(200);
        $horario_final->setSize(150);
        $horario_inicial->setSize(150);
        $observacao->setSize('100%', 100);
        $tipo_atividade_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id,$negociacao_id],[new TLabel("Tipo atividade:", '#ff0000', '14px', null, '100%'),$tipo_atividade_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Descricao:", null, '14px', null, '100%'),$descricao]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Horario inicial:", null, '14px', null, '100%'),$horario_inicial],[new TLabel("Horario final:", null, '14px', null, '100%'),$horario_final]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Observacao:", null, '14px', null, '100%'),$observacao]);
        $row4->layout = [' col-sm-12'];

        $this->form->addFields([$view]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_ondelete = $this->form->addAction("Excluir", new TAction([$this, 'onDelete']), 'fas:trash-alt #dd5a43');
        $this->btn_ondelete = $btn_ondelete;

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new NegociacaoAtividade(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $messageAction = new TAction(['NegociacaoAtividadeCalendarFormView', 'onReload']);
            $messageAction->setParameter('view', $data->view);
            $messageAction->setParameter('date', explode(' ', $data->horario_inicial)[0]);

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            $paramTimeline = [
                'target_container' => 'container_timeline',
                'negociacao_id' => $object->negociacao_id
            ];

            TApplication::loadPage('NegociacaoTimeline', 'onShow', $paramTimeline);

                TWindow::closeWindow(parent::getId()); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onDelete($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                $key = $param[self::$primaryKey];

                // open a transaction with database
                TTransaction::open(self::$database);

                $class = self::$activeRecord;

                // instantiates object
                $object = new $class($key, FALSE);

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                $messageAction = new TAction(array(__CLASS__.'View', 'onReload'));
                $messageAction->setParameter('view', $param['view']);
                $messageAction->setParameter('date', explode(' ',$param[self::$startDateField])[0]);

                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'), $messageAction);
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters((array) $this->form->getData());
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new NegociacaoAtividade($key); // instantiates the Active Record 

                                $object->view = !empty($param['view']) ? $param['view'] : 'agendaWeek'; 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public function onStartEdit($param)
    {

        $this->form->clear(true);

        $data = new stdClass;
        $data->view = $param['view'] ?? 'agendaWeek'; // calendar view
        $data->tipo_atividade = new stdClass();
        $data->tipo_atividade->cor = '#3a87ad';

        if (!empty($param['date']))
        {
            if(strlen($param['date']) == '10')
                $param['date'].= ' 09:00';

            $data->horario_inicial = str_replace('T', ' ', $param['date']);

            $horario_final = new DateTime($data->horario_inicial);
            $horario_final->add(new DateInterval('PT1H'));
            $data->horario_final = $horario_final->format('Y-m-d H:i:s');

        }

        $this->form->setData( $data );
    }

    public static function onUpdateEvent($param)
    {
        try
        {
            if (isset($param['id']))
            {
                TTransaction::open(self::$database);

                $class = self::$activeRecord;
                $object = new $class($param['id']);

                $object->horario_inicial = str_replace('T', ' ', $param['start_time']);
                $object->horario_final   = str_replace('T', ' ', $param['end_time']);

                $object->store();

                // close the transaction
                TTransaction::close();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }

}

