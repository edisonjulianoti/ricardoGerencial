<?php

class TempoService
{
    public static function getMeses()
    {
        return [
            '01'=>'Janeiro',
            '02'=>'Fevereiro',
            '03'=>'Março',
            '04'=>'Abril',
            '05'=>'Maio',
            '06'=>'Junho',
            '07'=>'Julho',
            '08'=>'Agosto',
            '09'=>'Setembro',
            '10'=>'Outubro',
            '11'=>'Novembro',
            '12'=>'Dezembro'
        ];
    }
    
    public static function getAnos()
    {
        $anoAtual = date('Y');
        $anoAtual -= 5;
        $anos = [];
        for($anoAtual; $anoAtual <= date('Y'); $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        for($anoAtual; $anoAtual <= date('Y') + 5; $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        return $anos;
    }
}
