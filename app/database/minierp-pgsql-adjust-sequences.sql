SELECT setval('api_error_id_seq', coalesce(max(id),0) + 1, false) FROM api_error;
SELECT setval('aprovador_id_seq', coalesce(max(id),0) + 1, false) FROM aprovador;
SELECT setval('categoria_id_seq', coalesce(max(id),0) + 1, false) FROM categoria;
SELECT setval('categoria_cliente_id_seq', coalesce(max(id),0) + 1, false) FROM categoria_cliente;
SELECT setval('cep_cache_id_seq', coalesce(max(id),0) + 1, false) FROM cep_cache;
SELECT setval('cidade_id_seq', coalesce(max(id),0) + 1, false) FROM cidade;
SELECT setval('condicao_pagamento_id_seq', coalesce(max(id),0) + 1, false) FROM condicao_pagamento;
SELECT setval('conta_id_seq', coalesce(max(id),0) + 1, false) FROM conta;
SELECT setval('conta_anexo_id_seq', coalesce(max(id),0) + 1, false) FROM conta_anexo;
SELECT setval('email_template_id_seq', coalesce(max(id),0) + 1, false) FROM email_template;
SELECT setval('error_log_crontab_id_seq', coalesce(max(id),0) + 1, false) FROM error_log_crontab;
SELECT setval('estado_id_seq', coalesce(max(id),0) + 1, false) FROM estado;
SELECT setval('estado_pedido_venda_id_seq', coalesce(max(id),0) + 1, false) FROM estado_pedido_venda;
SELECT setval('estado_pedido_venda_aprovador_id_seq', coalesce(max(id),0) + 1, false) FROM estado_pedido_venda_aprovador;
SELECT setval('etapa_negociacao_id_seq', coalesce(max(id),0) + 1, false) FROM etapa_negociacao;
SELECT setval('fabricante_id_seq', coalesce(max(id),0) + 1, false) FROM fabricante;
SELECT setval('familia_produto_id_seq', coalesce(max(id),0) + 1, false) FROM familia_produto;
SELECT setval('forma_pagamento_id_seq', coalesce(max(id),0) + 1, false) FROM forma_pagamento;
SELECT setval('grupo_pessoa_id_seq', coalesce(max(id),0) + 1, false) FROM grupo_pessoa;
SELECT setval('matriz_estado_pedido_venda_id_seq', coalesce(max(id),0) + 1, false) FROM matriz_estado_pedido_venda;
SELECT setval('negociacao_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao;
SELECT setval('negociacao_arquivo_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao_arquivo;
SELECT setval('negociacao_atividade_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao_atividade;
SELECT setval('negociacao_historico_etapa_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao_historico_etapa;
SELECT setval('negociacao_item_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao_item;
SELECT setval('negociacao_observacao_id_seq', coalesce(max(id),0) + 1, false) FROM negociacao_observacao;
SELECT setval('nota_fiscal_id_seq', coalesce(max(id),0) + 1, false) FROM nota_fiscal;
SELECT setval('nota_fiscal_item_id_seq', coalesce(max(id),0) + 1, false) FROM nota_fiscal_item;
SELECT setval('origem_contato_id_seq', coalesce(max(id),0) + 1, false) FROM origem_contato;
SELECT setval('ouvidoria_id_seq', coalesce(max(id),0) + 1, false) FROM ouvidoria;
SELECT setval('pedido_venda_id_seq', coalesce(max(id),0) + 1, false) FROM pedido_venda;
SELECT setval('pedido_venda_historico_id_seq', coalesce(max(id),0) + 1, false) FROM pedido_venda_historico;
SELECT setval('pedido_venda_item_id_seq', coalesce(max(id),0) + 1, false) FROM pedido_venda_item;
SELECT setval('pessoa_id_seq', coalesce(max(id),0) + 1, false) FROM pessoa;
SELECT setval('pessoa_contato_id_seq', coalesce(max(id),0) + 1, false) FROM pessoa_contato;
SELECT setval('pessoa_endereco_id_seq', coalesce(max(id),0) + 1, false) FROM pessoa_endereco;
SELECT setval('pessoa_grupo_id_seq', coalesce(max(id),0) + 1, false) FROM pessoa_grupo;
SELECT setval('produto_id_seq', coalesce(max(id),0) + 1, false) FROM produto;
SELECT setval('tipo_anexo_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_anexo;
SELECT setval('tipo_atividade_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_atividade;
SELECT setval('tipo_cliente_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_cliente;
SELECT setval('tipo_conta_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_conta;
SELECT setval('tipo_ouvidoria_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_ouvidoria;
SELECT setval('tipo_pedido_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_pedido;
SELECT setval('tipo_produto_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_produto;
SELECT setval('unidade_medida_id_seq', coalesce(max(id),0) + 1, false) FROM unidade_medida;