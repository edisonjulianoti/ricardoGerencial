INSERT INTO aprovador (id,system_user_id) VALUES (1,1); 

INSERT INTO aprovador (id,system_user_id) VALUES (2,2); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (1,1,'Vendas de mercadorias'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (2,1,'Vendas de produtos'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (3,1,'Venda de insumos'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (4,1,'Serviços de manutenção'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (5,1,'Receitas financeiras'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (6,2,'Compras de matérias primas'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (7,2,'Compras de insumos'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (8,2,'Pagamento de salários'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (9,2,'Investimentos em imobilizado'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (10,2,'Despesas administrativas'); 

INSERT INTO categoria (id,tipo_conta_id,nome) VALUES (11,2,'Despesas comerciais'); 

INSERT INTO categoria_cliente (id,nome) VALUES (1,'Supermercado'); 

INSERT INTO categoria_cliente (id,nome) VALUES (2,'Posto de gasolina'); 

INSERT INTO categoria_cliente (id,nome) VALUES (3,'Igreja'); 

INSERT INTO categoria_cliente (id,nome) VALUES (4,'Escola'); 

INSERT INTO categoria_cliente (id,nome) VALUES (5,'Consumidor final'); 

INSERT INTO categoria_cliente (id,nome) VALUES (6,'Fornecedor'); 

INSERT INTO categoria_cliente (id,nome) VALUES (7,'Vendedor'); 

INSERT INTO cidade (id,estado_id,nome,codigo_ibge) VALUES (1,1,'Lajeado','123123'); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (1,'À vista',1,0,0); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (2,'Entrada + 1',2,0,30); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (3,'Entrada + 2',3,0,30); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (4,'1x sem entrada',1,30,30); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (5,'2x sem entrada',2,30,30); 

INSERT INTO condicao_pagamento (id,nome,numero_parcelas,inicio,intervalo) VALUES (6,'3x sem entrada',3,30,30); 

INSERT INTO conta (id,pessoa_id,tipo_conta_id,categoria_id,forma_pagamento_id,pedido_venda_id,dt_vencimento,dt_emissao,dt_pagamento,valor,parcela,obs,mes_vencimento,ano_vencimento,ano_mes_vencimento,mes_emissao,ano_emissao,ano_mes_emissao,mes_pagamento,ano_pagamento,ano_mes_pagamento,created_at,updated_at,deleted_at) VALUES (1,1,2,8,1,null,'2022-07-20','2022-07-20',null,150,1,'',null,null,null,null,null,null,null,null,null,null,null,null); 

INSERT INTO conta (id,pessoa_id,tipo_conta_id,categoria_id,forma_pagamento_id,pedido_venda_id,dt_vencimento,dt_emissao,dt_pagamento,valor,parcela,obs,mes_vencimento,ano_vencimento,ano_mes_vencimento,mes_emissao,ano_emissao,ano_mes_emissao,mes_pagamento,ano_pagamento,ano_mes_pagamento,created_at,updated_at,deleted_at) VALUES (2,1,2,6,2,null,'2022-07-21','2022-07-20',null,250,1,'',null,null,null,null,null,null,null,null,null,null,null,null); 

INSERT INTO conta (id,pessoa_id,tipo_conta_id,categoria_id,forma_pagamento_id,pedido_venda_id,dt_vencimento,dt_emissao,dt_pagamento,valor,parcela,obs,mes_vencimento,ano_vencimento,ano_mes_vencimento,mes_emissao,ano_emissao,ano_mes_emissao,mes_pagamento,ano_pagamento,ano_mes_pagamento,created_at,updated_at,deleted_at) VALUES (3,1,2,11,3,null,'2022-07-30','2022-07-01',null,300,1,'',null,null,null,null,null,null,null,null,null,null,null,null); 

INSERT INTO conta (id,pessoa_id,tipo_conta_id,categoria_id,forma_pagamento_id,pedido_venda_id,dt_vencimento,dt_emissao,dt_pagamento,valor,parcela,obs,mes_vencimento,ano_vencimento,ano_mes_vencimento,mes_emissao,ano_emissao,ano_mes_emissao,mes_pagamento,ano_pagamento,ano_mes_pagamento,created_at,updated_at,deleted_at) VALUES (4,1,2,10,1,null,'2022-07-30','2022-07-01',null,400,1,'',null,null,null,null,null,null,null,null,null,null,null,null); 

INSERT INTO email_template (id,titulo,mensagem,created_at,updated_at,deleted_at) VALUES (1,'Atualização do Pedido #{id}','O pedido #{id} foi atualizado para o estado {estado_pedido_venda->nome}.',null,null,null); 

INSERT INTO email_template (id,titulo,mensagem,created_at,updated_at,deleted_at) VALUES (2,'Pedido #{id} aguardando aprovação','O pedido #{id} está aguardando a sua aprovação.',null,null,null); 

INSERT INTO email_template (id,titulo,mensagem,created_at,updated_at,deleted_at) VALUES (3,'Pedido {id} confirmado','Olá {nome} o seu pedido {id} feito na data {data_pedido} foi confirmado com os seguintes itens: <br><br> {itens_pedido}',null,null,null); 

INSERT INTO estado (id,nome,sigla,codigo_ibge) VALUES (1,'Rio Grande do Sul','RS',''); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (1,'Elaboração','#81ecec','T',1,'F','T','T','T',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (2,'Análise comercial','#fd79a8','T',2,'F','F','T','T',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (3,'Análise de crédito','#f1c40f','T',3,'F','F','T','T',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (4,'Processamento','#3498db','T',4,'F','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (6,'Faturamento','#8e44ad','T',6,'F','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (7,'Aguardando entrega','#f39c12','T',7,'F','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (8,'Finalizado','#2ecc71','T',8,'T','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (9,'Cancelado','#e74c3c','F',null,'T','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (10,'Reprovado','#c0392b','F',null,'T','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda (id,nome,cor,kanban,ordem,estado_final,estado_inicial,permite_edicao,permite_exclusao,created_at,updated_at,deleted_at) VALUES (5,'Gerando Financeiro','#44bd32','T',5,'F','F','F','F',null,null,null); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (1,1,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (2,2,2); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (3,2,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (4,3,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (5,4,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (6,5,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (7,6,1); 

INSERT INTO estado_pedido_venda_aprovador (id,estado_pedido_venda_id,aprovador_id) VALUES (8,7,1); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (1,'Prospectar','#1abc9c',1,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (2,'Qualificar','#2ecc71',2,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (3,'Levantar necessidades','#3498db',3,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (4,'Elaborar proposta','#9b59b6',4,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (5,'FollowUp (Cobrar feedback)','#e67e22',5,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (6,'Iniciar negociacão','#f1c40f',6,'','T','T','T'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (7,'Negociacão finalizada','#2ecc71',7,'','T','F','F'); 

INSERT INTO etapa_negociacao (id,nome,cor,ordem,roteiro,kanban,permite_edicao,permite_exclusao) VALUES (8,'Negociacão cancelada','#c0392b',8,'','F','F','F'); 

INSERT INTO fabricante (id,nome) VALUES (1,'Apple'); 

INSERT INTO fabricante (id,nome) VALUES (2,'LG'); 

INSERT INTO fabricante (id,nome) VALUES (3,'Samsung'); 

INSERT INTO fabricante (id,nome) VALUES (4,'Sony'); 

INSERT INTO fabricante (id,nome) VALUES (5,'Nikon'); 

INSERT INTO fabricante (id,nome) VALUES (6,'Dell'); 

INSERT INTO familia_produto (id,nome) VALUES (1,'Games'); 

INSERT INTO familia_produto (id,nome) VALUES (2,'Cadeiras'); 

INSERT INTO familia_produto (id,nome) VALUES (3,'Computadores'); 

INSERT INTO familia_produto (id,nome) VALUES (4,'Tablets'); 

INSERT INTO familia_produto (id,nome) VALUES (5,'Smartphones'); 

INSERT INTO familia_produto (id,nome) VALUES (6,'Tvs'); 

INSERT INTO familia_produto (id,nome) VALUES (7,'Audio'); 

INSERT INTO familia_produto (id,nome) VALUES (8,'Camêras'); 

INSERT INTO forma_pagamento (id,nome) VALUES (1,'Dinheiro'); 

INSERT INTO forma_pagamento (id,nome) VALUES (2,'Boleto'); 

INSERT INTO forma_pagamento (id,nome) VALUES (3,'Cartão'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (1,'Funcionário'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (2,'Vendedor'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (3,'Cliente'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (4,'Fornecedor'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (5,'Distribuidor'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (6,'Revendedor'); 

INSERT INTO grupo_pessoa (id,nome) VALUES (7,'Transportadora'); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (1,1,2); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (2,1,8); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (3,1,9); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (4,2,3); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (5,2,9); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (6,3,4); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (7,3,9); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (8,4,5); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (9,4,9); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (10,6,7); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (11,7,8); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (12,5,6); 

INSERT INTO matriz_estado_pedido_venda (id,estado_pedido_venda_origem_id,estado_pedido_venda_destino_id) VALUES (13,5,9); 

INSERT INTO origem_contato (id,nome) VALUES (1,'Anúncio Facebook'); 

INSERT INTO origem_contato (id,nome) VALUES (2,'Anúncio Google Ads'); 

INSERT INTO origem_contato (id,nome) VALUES (3,'Indicacão'); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (1,1,1,2,1,1,4,null,null,'',null,'','',5000,null,null,null,'',''); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (2,1,1,2,2,2,4,null,null,'',null,'','',10000,null,null,null,'',''); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (3,1,1,2,3,2,4,null,null,'',null,'','',150000,null,null,null,'',''); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (4,1,1,2,4,1,4,null,null,'',null,'','',250000,null,null,null,'',''); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (5,1,1,2,5,1,4,null,null,'',null,'','',30000,null,null,null,'',''); 

INSERT INTO pedido_venda (id,tipo_pedido_id,cliente_id,vendedor_id,estado_pedido_venda_id,condicao_pagamento_id,transportadora_id,negociacao_id,dt_pedido,obs,frete,mes,ano,valor_total,created_at,updated_at,deleted_at,obs_comercial,obs_financeiro) VALUES (6,1,1,2,6,2,4,null,null,'',null,'','',4500,null,null,null,'',''); 

INSERT INTO pedido_venda_historico (id,pedido_venda_id,estado_pedido_venda_id,aprovador_id,data_operacao,obs) VALUES (1,5,1,1,'2022-05-08','Tudo certo, pode seguir!'); 

INSERT INTO pedido_venda_historico (id,pedido_venda_id,estado_pedido_venda_id,aprovador_id,data_operacao,obs) VALUES (2,5,2,1,'2022-05-08','Comercial OK'); 

INSERT INTO pedido_venda_historico (id,pedido_venda_id,estado_pedido_venda_id,aprovador_id,data_operacao,obs) VALUES (3,5,3,1,'2022-05-09','Cliente possui bastante crédito aprovado'); 

INSERT INTO pedido_venda_historico (id,pedido_venda_id,estado_pedido_venda_id,aprovador_id,data_operacao,obs) VALUES (4,5,4,1,'2022-05-09','Processado com Sucesso!'); 

INSERT INTO pedido_venda_historico (id,pedido_venda_id,estado_pedido_venda_id,aprovador_id,data_operacao,obs) VALUES (5,5,5,1,'2022-05-10','Faturado Ok!'); 

INSERT INTO pessoa (id,tipo_cliente_id,categoria_cliente_id,system_user_id,nome,documento,obs,fone,email,created_at,updated_at,deleted_at,login,senha) VALUES (1,1,5,null,'Cliente 01','111.111.111-11','','(51) 9 9813-1234','cliente@cliente.com.br',null,null,null,null,null); 

INSERT INTO pessoa (id,tipo_cliente_id,categoria_cliente_id,system_user_id,nome,documento,obs,fone,email,created_at,updated_at,deleted_at,login,senha) VALUES (2,1,7,1,'Vendedor 01','1111111','','','',null,null,null,null,null); 

INSERT INTO pessoa (id,tipo_cliente_id,categoria_cliente_id,system_user_id,nome,documento,obs,fone,email,created_at,updated_at,deleted_at,login,senha) VALUES (3,2,6,null,'Fornecedor 01','1111111','','','',null,null,null,null,null); 

INSERT INTO pessoa (id,tipo_cliente_id,categoria_cliente_id,system_user_id,nome,documento,obs,fone,email,created_at,updated_at,deleted_at,login,senha) VALUES (4,2,null,null,'Transportadora','111111111','','','',null,null,null,null,null); 

INSERT INTO pessoa_grupo (id,pessoa_id,grupo_pessoa_id) VALUES (1,1,3); 

INSERT INTO pessoa_grupo (id,pessoa_id,grupo_pessoa_id) VALUES (2,2,2); 

INSERT INTO pessoa_grupo (id,pessoa_id,grupo_pessoa_id) VALUES (3,3,4); 

INSERT INTO pessoa_grupo (id,pessoa_id,grupo_pessoa_id) VALUES (4,4,7); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (1,2,3,3,1,1,'Macbook','',25000,15000,null,null,null,null,null,5,3,10,'','T','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (2,2,5,3,1,1,'Iphone','',5000,2500,null,null,null,null,null,5,3,10,'','T','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (3,1,1,3,1,4,'Fifa 2021','',120,30,null,null,null,null,null,5,3,10,'','T','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (4,1,1,3,1,4,'Fifa 2022','', 120,30,null,null,null,null,null,5,3,10,'','T','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (5,1,2,3,1,2,'Cadeira Gamer','',1200,550,null,null,null,null,null,null,null,null,'','','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (6,1,4,3,1,1,'Ipda PRO','',8000,5000,null,null,null,null,null,null,null,null,'','','',null,null,null,null); 

INSERT INTO produto (id,tipo_produto_id,familia_produto_id,fornecedor_id,unidade_medida_id,fabricante_id,nome,cod_barras,preco_venda,preco_custo,peso_liquido,peso_bruto,largura,altura,volume,estoque_minimo,qtde_estoque,estoque_maximo,obs,ativo,foto,data_ultimo_reajuste_preco,created_at,updated_at,deleted_at) VALUES (7,1,5,3,1,3,'Galaxy S22','',5500,3500,null,null,null,null,null,null,null,null,'','','',null,null,null,null); 

INSERT INTO system_group (id,name,uuid) VALUES (1,'Admin',null); 

INSERT INTO system_group (id,name,uuid) VALUES (2,'Standard',null); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (1,1,1); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (2,1,2); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (3,1,3); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (4,1,4); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (5,1,5); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (6,1,6); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (7,1,8); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (8,1,9); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (9,1,11); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (10,1,14); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (11,1,15); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (12,2,10); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (13,2,12); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (14,2,13); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (15,2,16); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (16,2,17); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (17,2,18); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (18,2,19); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (19,2,20); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (20,1,21); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (21,2,22); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (22,2,23); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (23,2,24); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (24,2,25); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (25,1,26); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (26,1,27); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (27,1,28); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (28,1,29); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (29,2,30); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (30,1,31); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (31,1,32); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (32,1,33); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (33,1,34); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (34,1,35); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (35,1,36); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (36,1,37); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (37,1,38); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (38,1,39); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (39,1,40); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (40,1,41); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (41,1,42); 

INSERT INTO system_program (id,name,controller) VALUES (1,'System Group Form','SystemGroupForm'); 

INSERT INTO system_program (id,name,controller) VALUES (2,'System Group List','SystemGroupList'); 

INSERT INTO system_program (id,name,controller) VALUES (3,'System Program Form','SystemProgramForm'); 

INSERT INTO system_program (id,name,controller) VALUES (4,'System Program List','SystemProgramList'); 

INSERT INTO system_program (id,name,controller) VALUES (5,'System User Form','SystemUserForm'); 

INSERT INTO system_program (id,name,controller) VALUES (6,'System User List','SystemUserList'); 

INSERT INTO system_program (id,name,controller) VALUES (7,'Common Page','CommonPage'); 

INSERT INTO system_program (id,name,controller) VALUES (8,'System PHP Info','SystemPHPInfoView'); 

INSERT INTO system_program (id,name,controller) VALUES (9,'System ChangeLog View','SystemChangeLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (10,'Welcome View','WelcomeView'); 

INSERT INTO system_program (id,name,controller) VALUES (11,'System Sql Log','SystemSqlLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (12,'System Profile View','SystemProfileView'); 

INSERT INTO system_program (id,name,controller) VALUES (13,'System Profile Form','SystemProfileForm'); 

INSERT INTO system_program (id,name,controller) VALUES (14,'System SQL Panel','SystemSQLPanel'); 

INSERT INTO system_program (id,name,controller) VALUES (15,'System Access Log','SystemAccessLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (16,'System Message Form','SystemMessageForm'); 

INSERT INTO system_program (id,name,controller) VALUES (17,'System Message List','SystemMessageList'); 

INSERT INTO system_program (id,name,controller) VALUES (18,'System Message Form View','SystemMessageFormView'); 

INSERT INTO system_program (id,name,controller) VALUES (19,'System Notification List','SystemNotificationList'); 

INSERT INTO system_program (id,name,controller) VALUES (20,'System Notification Form View','SystemNotificationFormView'); 

INSERT INTO system_program (id,name,controller) VALUES (21,'System Document Category List','SystemDocumentCategoryFormList'); 

INSERT INTO system_program (id,name,controller) VALUES (22,'System Document Form','SystemDocumentForm'); 

INSERT INTO system_program (id,name,controller) VALUES (23,'System Document Upload Form','SystemDocumentUploadForm'); 

INSERT INTO system_program (id,name,controller) VALUES (24,'System Document List','SystemDocumentList'); 

INSERT INTO system_program (id,name,controller) VALUES (25,'System Shared Document List','SystemSharedDocumentList'); 

INSERT INTO system_program (id,name,controller) VALUES (26,'System Unit Form','SystemUnitForm'); 

INSERT INTO system_program (id,name,controller) VALUES (27,'System Unit List','SystemUnitList'); 

INSERT INTO system_program (id,name,controller) VALUES (28,'System Access stats','SystemAccessLogStats'); 

INSERT INTO system_program (id,name,controller) VALUES (29,'System Preference form','SystemPreferenceForm'); 

INSERT INTO system_program (id,name,controller) VALUES (30,'System Support form','SystemSupportForm'); 

INSERT INTO system_program (id,name,controller) VALUES (31,'System PHP Error','SystemPHPErrorLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (32,'System Database Browser','SystemDatabaseExplorer'); 

INSERT INTO system_program (id,name,controller) VALUES (33,'System Table List','SystemTableList'); 

INSERT INTO system_program (id,name,controller) VALUES (34,'System Data Browser','SystemDataBrowser'); 

INSERT INTO system_program (id,name,controller) VALUES (35,'System Menu Editor','SystemMenuEditor'); 

INSERT INTO system_program (id,name,controller) VALUES (36,'System Request Log','SystemRequestLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (37,'System Request Log View','SystemRequestLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (38,'System Administration Dashboard','SystemAdministrationDashboard'); 

INSERT INTO system_program (id,name,controller) VALUES (39,'System Log Dashboard','SystemLogDashboard'); 

INSERT INTO system_program (id,name,controller) VALUES (40,'System Session dump','SystemSessionDumpView'); 

INSERT INTO system_program (id,name,controller) VALUES (41,'Files diff','SystemFilesDiff'); 

INSERT INTO system_program (id,name,controller) VALUES (42,'System Information','SystemInformationView'); 

INSERT INTO system_unit (id,name,connection_name) VALUES (1,'Matriz','matriz'); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (1,1,1); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (2,2,2); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (3,1,2); 

INSERT INTO system_user_program (id,system_user_id,system_program_id) VALUES (1,2,7); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.net',10,null,'Y','',''); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES (2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user@user.net',7,null,'Y','',''); 

INSERT INTO system_user_unit (id,system_user_id,system_unit_id) VALUES (1,1,1); 

INSERT INTO tipo_anexo (id,nome) VALUES (1,'Recibo'); 

INSERT INTO tipo_anexo (id,nome) VALUES (2,'Boleto'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (1,'Ligar','#00d2d3','fas fa-phone'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (2,'Reunião','#54a0ff','fas fa-users'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (3,'Tarefa','#5f27cd','fas fa-tasks'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (4,'Prazo','#341f97','far fa-clock'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (5,'Email','#ee5253','far fa-envelope'); 

INSERT INTO tipo_atividade (id,nome,cor,icone) VALUES (6,'Almoço','#feca57','fas fa-utensils'); 

INSERT INTO tipo_cliente (id,nome,sigla) VALUES (1,'Física','PF'); 

INSERT INTO tipo_cliente (id,nome,sigla) VALUES (2,'Jurídica','PJ'); 

INSERT INTO tipo_conta (id,nome) VALUES (1,'Receber'); 

INSERT INTO tipo_conta (id,nome) VALUES (2,'Pagar'); 

INSERT INTO tipo_ouvidoria (id,nome) VALUES (1,'Sugestão'); 

INSERT INTO tipo_ouvidoria (id,nome) VALUES (2,'Elogio'); 

INSERT INTO tipo_ouvidoria (id,nome) VALUES (3,'Critica'); 

INSERT INTO tipo_ouvidoria (id,nome) VALUES (4,'Reclamação'); 

INSERT INTO tipo_pedido (id,categoria_id,nome) VALUES (1,1,'Vendas de mercadorias'); 

INSERT INTO tipo_pedido (id,categoria_id,nome) VALUES (2,2,'Vendas de produtos'); 

INSERT INTO tipo_produto (id,nome) VALUES (1,'Mercadoria'); 

INSERT INTO tipo_produto (id,nome) VALUES (2,'Produto'); 

INSERT INTO tipo_produto (id,nome) VALUES (3,'Serviço'); 

INSERT INTO unidade_medida (id,nome,sigla) VALUES (1,'Peça','PC'); 

INSERT INTO unidade_medida (id,nome,sigla) VALUES (2,'Litro','LT'); 

INSERT INTO unidade_medida (id,nome,sigla) VALUES (3,'Metro cúbico','M3'); 
