CREATE TABLE api_error( 
      id  INT IDENTITY    NOT NULL  , 
      classe varchar  (255)   , 
      metodo varchar  (255)   , 
      url varchar  (500)   , 
      dados varchar  (3000)   , 
      error_message varchar  (3000)   , 
      created_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE aprovador( 
      id  INT IDENTITY    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_cliente( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cep_cache( 
      id  INT IDENTITY    NOT NULL  , 
      cep varchar  (10)   , 
      rua varchar  (10)   , 
      cidade varchar  (500)   , 
      bairro varchar  (500)   , 
      codigo_ibge varchar  (20)   , 
      uf varchar  (2)   , 
      cidade_id int   , 
      estado_id int   , 
      created_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cidade( 
      id  INT IDENTITY    NOT NULL  , 
      estado_id int   NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      codigo_ibge varchar  (10)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE condicao_pagamento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      numero_parcelas int   , 
      inicio int   , 
      intervalo int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  INT IDENTITY    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      forma_pagamento_id int   NOT NULL  , 
      pedido_venda_id int   , 
      dt_vencimento date   , 
      dt_emissao date   , 
      dt_pagamento date   , 
      valor float   , 
      parcela int   , 
      obs nvarchar(max)   , 
      mes_vencimento int   , 
      ano_vencimento int   , 
      ano_mes_vencimento int   , 
      mes_emissao int   , 
      ano_emissao int   , 
      ano_mes_emissao int   , 
      mes_pagamento int   , 
      ano_pagamento int   , 
      ano_mes_pagamento int   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta_anexo( 
      id  INT IDENTITY    NOT NULL  , 
      conta_id int   NOT NULL  , 
      tipo_anexo_id int   NOT NULL  , 
      descricao nvarchar(max)   , 
      arquivo nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email_template( 
      id  INT IDENTITY    NOT NULL  , 
      titulo nvarchar(max)   , 
      mensagem nvarchar(max)   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE error_log_crontab( 
      id  INT IDENTITY    NOT NULL  , 
      classe nvarchar(max)   , 
      metodo nvarchar(max)   , 
      mensagem nvarchar(max)   , 
      created_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
      codigo_ibge varchar  (10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   , 
      cor varchar  (100)   , 
      kanban char  (1)   , 
      ordem int   , 
      estado_final char  (1)   , 
      estado_inicial char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda_aprovador( 
      id  INT IDENTITY    NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      aprovador_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE etapa_negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   , 
      cor nvarchar(max)   , 
      ordem int   , 
      roteiro nvarchar(max)   , 
      kanban char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fabricante( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE familia_produto( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE forma_pagamento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_pessoa( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE matriz_estado_pedido_venda( 
      id  INT IDENTITY    NOT NULL  , 
      estado_pedido_venda_origem_id int   NOT NULL  , 
      estado_pedido_venda_destino_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      origem_contato_id int   NOT NULL  , 
      etapa_negociacao_id int   NOT NULL  , 
      data_inicio date   NOT NULL  , 
      data_fechamento date   , 
      data_fechamento_esperada date   , 
      valor_total float   , 
      ordem int   , 
      mes int   , 
      ano int   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
      email_novo_pedido_enviado char  (1)     DEFAULT 'F', 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_arquivo( 
      id  INT IDENTITY    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      nome_arquivo nvarchar(max)   , 
      conteudo_arquivo nvarchar(max)   , 
      dt_arquivo datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_atividade( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_atividade_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      descricao nvarchar(max)   , 
      horario_inicial datetime2   , 
      horario_final datetime2   , 
      observacao nvarchar(max)   , 
      dt_atividade datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_historico_etapa( 
      id  INT IDENTITY    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      etapa_negociacao_id int   NOT NULL  , 
      dt_etapa datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_item( 
      id  INT IDENTITY    NOT NULL  , 
      produto_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      valor_total float   , 
      dt_item datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_observacao( 
      id  INT IDENTITY    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      observacao nvarchar(max)   , 
      dt_observacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      condicao_pagamento_id int   NOT NULL  , 
      obs nvarchar(max)   , 
      mes int   , 
      ano int   , 
      valor_total float   , 
      data_emissao date   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal_item( 
      id  INT IDENTITY    NOT NULL  , 
      pedido_venda_item_id int   , 
      nota_fiscal_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      desconto float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_contato( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ouvidoria( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_ouvidoria_id int   NOT NULL  , 
      nome nvarchar(max)   , 
      telefone nvarchar(max)   , 
      email nvarchar(max)   , 
      mensagem nvarchar(max)   NOT NULL  , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_pedido_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      condicao_pagamento_id int   NOT NULL  , 
      transportadora_id int   NOT NULL  , 
      negociacao_id int   , 
      dt_pedido date   , 
      obs varchar  (255)   , 
      frete float   , 
      mes char  (2)   , 
      ano char  (4)   , 
      valor_total float   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
      obs_comercial nvarchar(max)   , 
      obs_financeiro nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_historico( 
      id  INT IDENTITY    NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      aprovador_id int   , 
      data_operacao datetime2   , 
      obs nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_item( 
      id  INT IDENTITY    NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      desconto float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_cliente_id int   NOT NULL  , 
      categoria_cliente_id int   , 
      system_user_id int   , 
      nome varchar  (500)   NOT NULL  , 
      documento varchar  (20)   NOT NULL  , 
      obs varchar  (1000)   , 
      fone varchar  (255)   , 
      email varchar  (255)   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
      login varchar  (255)   , 
      senha varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_contato( 
      id  INT IDENTITY    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      email varchar  (255)   , 
      nome varchar  (255)   , 
      telefone varchar  (255)   , 
      obs varchar  (500)   , 
      created_at datetime2   , 
      updated_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_endereco( 
      id  INT IDENTITY    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      cidade_id int   NOT NULL  , 
      nome varchar  (255)   , 
      principal char  (1)   , 
      cep varchar  (10)   , 
      rua varchar  (500)   , 
      numero varchar  (20)   , 
      bairro varchar  (500)   , 
      complemento varchar  (500)   , 
      data_desativacao date   , 
      created_at datetime2   , 
      updated_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id  INT IDENTITY    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      grupo_pessoa_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_produto_id int   NOT NULL  , 
      familia_produto_id int   NOT NULL  , 
      fornecedor_id int   NOT NULL  , 
      unidade_medida_id int   NOT NULL  , 
      fabricante_id int   , 
      nome varchar  (255)   NOT NULL  , 
      cod_barras varchar  (255)   , 
      preco_venda float   , 
      preco_custo float   , 
      peso_liquido float   , 
      peso_bruto float   , 
      largura float   , 
      altura float   , 
      volume float   , 
      estoque_minimo float   , 
      qtde_estoque float   , 
      estoque_maximo float   , 
      obs varchar  (500)   , 
      ativo char  (1)   , 
      foto varchar  (500)   , 
      data_ultimo_reajuste_preco datetime2   , 
      created_at datetime2   , 
      updated_at datetime2   , 
      deleted_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at nvarchar(max)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_anexo( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atividade( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   , 
      cor nvarchar(max)   , 
      icone nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_cliente( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_ouvidoria( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_pedido( 
      id  INT IDENTITY    NOT NULL  , 
      categoria_id int   NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade_medida( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE aprovador ADD CONSTRAINT fk_aprovador_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE categoria ADD CONSTRAINT fk_categoria_1 FOREIGN KEY (tipo_conta_id) references tipo_conta(id); 
ALTER TABLE cidade ADD CONSTRAINT fk_cidade_1 FOREIGN KEY (estado_id) references estado(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_1 FOREIGN KEY (tipo_conta_id) references tipo_conta(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_2 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_3 FOREIGN KEY (forma_pagamento_id) references forma_pagamento(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_4 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_5 FOREIGN KEY (pedido_venda_id) references pedido_venda(id); 
ALTER TABLE conta_anexo ADD CONSTRAINT fk_conta_anexo_1 FOREIGN KEY (conta_id) references conta(id); 
ALTER TABLE conta_anexo ADD CONSTRAINT fk_conta_anexo_2 FOREIGN KEY (tipo_anexo_id) references tipo_anexo(id); 
ALTER TABLE estado_pedido_venda_aprovador ADD CONSTRAINT fk_estado_pedido_venda_aprovador_1 FOREIGN KEY (estado_pedido_venda_id) references estado_pedido_venda(id); 
ALTER TABLE estado_pedido_venda_aprovador ADD CONSTRAINT fk_estado_pedido_venda_aprovador_2 FOREIGN KEY (aprovador_id) references aprovador(id); 
ALTER TABLE matriz_estado_pedido_venda ADD CONSTRAINT fk_matriz_estado_pedido_venda_1 FOREIGN KEY (estado_pedido_venda_origem_id) references estado_pedido_venda(id); 
ALTER TABLE matriz_estado_pedido_venda ADD CONSTRAINT fk_matriz_estado_pedido_venda_2 FOREIGN KEY (estado_pedido_venda_destino_id) references estado_pedido_venda(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_2 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_3 FOREIGN KEY (origem_contato_id) references origem_contato(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_4 FOREIGN KEY (etapa_negociacao_id) references etapa_negociacao(id); 
ALTER TABLE negociacao_arquivo ADD CONSTRAINT fk_negociacao_arquivo_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao_atividade ADD CONSTRAINT fk_negociacao_atividade_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao_atividade ADD CONSTRAINT fk_negociacao_atividade_2 FOREIGN KEY (tipo_atividade_id) references tipo_atividade(id); 
ALTER TABLE negociacao_historico_etapa ADD CONSTRAINT fk_negociacao_historico_etapa_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao_historico_etapa ADD CONSTRAINT fk_negociacao_historico_etapa_2 FOREIGN KEY (etapa_negociacao_id) references etapa_negociacao(id); 
ALTER TABLE negociacao_item ADD CONSTRAINT fk_negociacao_item_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao_item ADD CONSTRAINT fk_negociacao_item_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE negociacao_observacao ADD CONSTRAINT fk_negociacao_observacao_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE nota_fiscal ADD CONSTRAINT fk_nota_fiscal_1 FOREIGN KEY (pedido_venda_id) references pedido_venda(id); 
ALTER TABLE nota_fiscal ADD CONSTRAINT fk_nota_fiscal_2 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE nota_fiscal ADD CONSTRAINT fk_nota_fiscal_3 FOREIGN KEY (condicao_pagamento_id) references condicao_pagamento(id); 
ALTER TABLE nota_fiscal_item ADD CONSTRAINT fk_nota_fiscal_item_1 FOREIGN KEY (pedido_venda_item_id) references pedido_venda_item(id); 
ALTER TABLE nota_fiscal_item ADD CONSTRAINT fk_nota_fiscal_item_2 FOREIGN KEY (nota_fiscal_id) references nota_fiscal(id); 
ALTER TABLE nota_fiscal_item ADD CONSTRAINT fk_nota_fiscal_item_3 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE ouvidoria ADD CONSTRAINT fk_ouvidoria_1 FOREIGN KEY (tipo_ouvidoria_id) references tipo_ouvidoria(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_2 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_3 FOREIGN KEY (estado_pedido_venda_id) references estado_pedido_venda(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_4 FOREIGN KEY (condicao_pagamento_id) references condicao_pagamento(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_5 FOREIGN KEY (transportadora_id) references pessoa(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_6 FOREIGN KEY (tipo_pedido_id) references tipo_pedido(id); 
ALTER TABLE pedido_venda ADD CONSTRAINT fk_pedido_venda_7 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE pedido_venda_historico ADD CONSTRAINT fk_pedido_venda_historico_1 FOREIGN KEY (pedido_venda_id) references pedido_venda(id); 
ALTER TABLE pedido_venda_historico ADD CONSTRAINT fk_pedido_venda_historico_2 FOREIGN KEY (estado_pedido_venda_id) references estado_pedido_venda(id); 
ALTER TABLE pedido_venda_historico ADD CONSTRAINT fk_pedido_venda_historico_3 FOREIGN KEY (aprovador_id) references aprovador(id); 
ALTER TABLE pedido_venda_item ADD CONSTRAINT fk_pedido_venda_item_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE pedido_venda_item ADD CONSTRAINT fk_pedido_venda_item_1 FOREIGN KEY (pedido_venda_id) references pedido_venda(id); 
ALTER TABLE pessoa ADD CONSTRAINT fk_pessoa_1 FOREIGN KEY (tipo_cliente_id) references tipo_cliente(id); 
ALTER TABLE pessoa ADD CONSTRAINT fk_pessoa_2 FOREIGN KEY (categoria_cliente_id) references categoria_cliente(id); 
ALTER TABLE pessoa ADD CONSTRAINT fk_pessoa_3 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE pessoa_contato ADD CONSTRAINT fk_pessoa_contato_1 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE pessoa_endereco ADD CONSTRAINT fk_pessoa_endereco_1 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE pessoa_endereco ADD CONSTRAINT fk_pessoa_endereco_2 FOREIGN KEY (cidade_id) references cidade(id); 
ALTER TABLE pessoa_grupo ADD CONSTRAINT fk_pessoa_grupo_1 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE pessoa_grupo ADD CONSTRAINT fk_pessoa_grupo_2 FOREIGN KEY (grupo_pessoa_id) references grupo_pessoa(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (tipo_produto_id) references tipo_produto(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_2 FOREIGN KEY (familia_produto_id) references familia_produto(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_3 FOREIGN KEY (fabricante_id) references fabricante(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_4 FOREIGN KEY (unidade_medida_id) references unidade_medida(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_5 FOREIGN KEY (fornecedor_id) references pessoa(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tipo_pedido ADD CONSTRAINT fk_tipo_pedido_1 FOREIGN KEY (categoria_id) references categoria(id); 

 CREATE VIEW view_negociacao_timeline AS SELECT
     id as "chave",
     negociacao_id as "negociacao_id",
     dt_observacao as "dt_historico",
     'observacao' as "tipo"
 FROM negociacao_observacao

UNION ALL

SELECT
     id as "chave",
     negociacao_id as "negociacao_id",
     dt_arquivo as "dt_historico",
     'arquivo' as "tipo"
 FROM negociacao_arquivo

UNION ALL

SELECT
     id as "chave",
     negociacao_id as "negociacao_id",
     dt_atividade as "dt_historico",
     'atividade' as "tipo"
 FROM negociacao_atividade

UNION ALL

SELECT
     id as "chave",
     negociacao_id as "negociacao_id",
     dt_item as "dt_historico",
     'produto' as "tipo"
 FROM negociacao_item


UNION ALL

SELECT
     id as "chave",
     negociacao_id as "negociacao_id",
     dt_etapa as "dt_historico",
     'etapa' as "tipo"
 FROM negociacao_historico_etapa; 
 
