<?php

class GenerateDataControl extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
        
        FakeDataService::generatePedidosVenda();
        
        new TMessage('info', 'Dados Gerados com Sucesso!');
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
