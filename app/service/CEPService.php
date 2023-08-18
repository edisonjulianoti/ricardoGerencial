<?php

class CEPService
{
    public static function get($cep)
    {
        $cep = str_replace(['-','.'], ['', ''], $cep);

        $dadosCep = CEPCacheService::get($cep);

        if($dadosCep)
        {
            return $dadosCep;
        }

        try 
        {
            $dadosCep = BuilderCEPService::get($cep);
        } 
        catch (Exception $e) 
        {
            $apiError = new ApiError();
            $apiError->url = BuilderCEPService::getUrl($cep);
            $apiError->error_message = $e->getMessage();
            $apiError->store();

            return null;
        }

        $dadosCep->rua = $dadosCep->tipo_logradouro . ' ' .$dadosCep->logradouro;
        $dadosCep->cep = $cep;

        $dadosCep->cidade = $dadosCep->cidade;

        $cidade = Cidade::where('codigo_ibge', '=', $dadosCep->cidade_cod_ibge)->first();
        $estado = Estado::where('codigo_ibge', '=', $dadosCep->estado_cod_ibge)->first();

        if ($cidade)
        {
            $dadosCep->cidade_id = $cidade->id;
            $dadosCep->estado_id = $cidade->estado_id;
        }
        else // se não achar a cidade/estado aproveitamos para salvar
        {
            if (!$estado)
            {
                $estado = new Estado;
                $estado->sigla = $dadosCep->uf;
                $estado->nome = $dadosCep->estado;
                $estado->codigo_ibge = $dadosCep->estado_cod_ibge;
                $estado->store();
            }

            $cidade = new Cidade;
            $cidade->nome = $dadosCep->cidade;
            $cidade->codigo_ibge = $dadosCep->cidade_cod_ibge;
            $cidade->estado_id = $estado->id;
            $cidade->store();

            $dadosCep->cidade_id = $cidade->id;
            $dadosCep->estado_id = $cidade->estado_id;
        }

        CEPCacheService::save($dadosCep);

        return $dadosCep;
    }
}