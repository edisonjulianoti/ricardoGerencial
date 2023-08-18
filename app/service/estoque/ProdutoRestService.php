<?php

class ProdutoRestService extends AdiantiRecordService
{
    const DATABASE      = 'minierp';
    const ACTIVE_RECORD = 'Produto';
    const ATTRIBUTES    = ['altura','ativo','cod_barras','created_at','data_ultimo_reajuste_preco','deleted_at','estoque_maximo','estoque_minimo','fabricante_id','familia_produto_id','fornecedor_id','foto','id','largura','nome','obs','peso_bruto','peso_liquido','preco_custo','preco_venda','qtde_estoque','tipo_produto_id','unidade_medida_id','updated_at','volume'];
    
    /**
     * load($param)
     *
     * Load an Active Records by its ID
     * 
     * @return The Active Record as associative array
     * @param $param['id'] Object ID
     */
    
    
    /**
     * delete($param)
     *
     * Delete an Active Records by its ID
     * 
     * @return The Operation result
     * @param $param['id'] Object ID
     */
    
    
    /**
     * store($param)
     *
     * Save an Active Records
     * 
     * @return The Operation result
     * @param $param['data'] Associative array with object data
     */
    
    
    /**
     * loadAll($param)
     *
     * List the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['offset']    Query offset
     *        $param['limit']     Query limit
     *        $param['order']     Query order by
     *        $param['direction'] Query order direction (asc, desc)
     *        $param['filters']   Query filters (array with field,operator,field)
     */
    
    
    /**
     * deleteAll($param)
     *
     * Delete the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['filters']   Query filters (array with field,operator,field)
     */
}
