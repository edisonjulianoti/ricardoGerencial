<?php

class OuvidoriaPublicaForm extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
        
        $tipo_ouvidoria_id = new TDBCombo('tipo_ouvidoria_id', 'minierp', 'TipoOuvidoria', 'id', 'nome', 'nome');
        $tipo_ouvidoria_id->class = 'form-control';
        
        $html = new THtmlRenderer('app/resources/ouvidoria_publica_form.html');
        $html->enableSection('main', [
            'tipo_ouvidoria_id' => $tipo_ouvidoria_id
        ]);
        
        
        
        parent::add($html);
        
    }
    
    public static function onSave($param = null)
    {
        try 
        {
            if(empty($param['mensagem']))
            {
                throw new Exception('A mensagem é obrigatória!');
            }
            
            if(empty($param['tipo_ouvidoria_id']))
            {
                throw new Exception('O tipo é obrigatório!');
            }
            
            TTransaction::open('minierp');
            $ouvidoria = new Ouvidoria();
            $ouvidoria->nome = $param['nome'];
            $ouvidoria->email = $param['email'];
            $ouvidoria->telefone = $param['telefone'];
            $ouvidoria->tipo_ouvidoria_id = $param['tipo_ouvidoria_id'];
            $ouvidoria->mensagem = $param['mensagem'];
            $ouvidoria->store();
            TTransaction::close();
            
            new TMessage('info', 'Ouvidoria enviada!');
        } 
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
        }
        
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
