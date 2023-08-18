<?php

class CNPJService
{
    public static function get($cnpj)
    {
        try 
        {
            $dadosCnpj = BuilderCNPJService::get($cnpj);

            if($dadosCnpj->cep)
            {
                $dadosCep = CEPService::get($dadosCnpj->cep);    

                $dadosCnpj->estado_id = $dadosCep->estado_id;
                $dadosCnpj->cidade_id = $dadosCep->cidade_id;
            }
        } 
        catch (Exception $e) 
        {
            $apiError = new ApiError();
            $apiError->url = BuilderCNPJService::getUrl($cnpj);
            $apiError->error_message = $e->getMessage();
            $apiError->store();

            return null;
        }

        return $dadosCnpj;
    }
}