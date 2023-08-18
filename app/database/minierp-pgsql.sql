CREATE TABLE api_error( 
      id  SERIAL    NOT NULL  , 
      classe varchar  (255)   , 
      metodo varchar  (255)   , 
      url varchar  (500)   , 
      dados varchar  (3000)   , 
      error_message varchar  (3000)   , 
      created_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE aprovador( 
      id  SERIAL    NOT NULL  , 
      system_user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  SERIAL    NOT NULL  , 
      tipo_conta_id integer   NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_cliente( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cep_cache( 
      id  SERIAL    NOT NULL  , 
      cep varchar  (10)   , 
      rua varchar  (10)   , 
      cidade varchar  (500)   , 
      bairro varchar  (500)   , 
      codigo_ibge varchar  (20)   , 
      uf varchar  (2)   , 
      cidade_id integer   , 
      estado_id integer   , 
      created_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cidade( 
      id  SERIAL    NOT NULL  , 
      estado_id integer   NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      codigo_ibge varchar  (10)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE condicao_pagamento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      numero_parcelas integer   , 
      inicio integer   , 
      intervalo integer   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  SERIAL    NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
      tipo_conta_id integer   NOT NULL  , 
      categoria_id integer   NOT NULL  , 
      forma_pagamento_id integer   NOT NULL  , 
      pedido_venda_id integer   , 
      dt_vencimento date   , 
      dt_emissao date   , 
      dt_pagamento date   , 
      valor float   , 
      parcela integer   , 
      obs text   , 
      mes_vencimento integer   , 
      ano_vencimento integer   , 
      ano_mes_vencimento integer   , 
      mes_emissao integer   , 
      ano_emissao integer   , 
      ano_mes_emissao integer   , 
      mes_pagamento integer   , 
      ano_pagamento integer   , 
      ano_mes_pagamento integer   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta_anexo( 
      id  SERIAL    NOT NULL  , 
      conta_id integer   NOT NULL  , 
      tipo_anexo_id integer   NOT NULL  , 
      descricao text   , 
      arquivo text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email_template( 
      id  SERIAL    NOT NULL  , 
      titulo text   , 
      mensagem text   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE error_log_crontab( 
      id  SERIAL    NOT NULL  , 
      classe text   , 
      metodo text   , 
      mensagem text   , 
      created_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
      codigo_ibge varchar  (10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   , 
      cor varchar  (100)   , 
      kanban char  (1)   , 
      ordem integer   , 
      estado_final char  (1)   , 
      estado_inicial char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda_aprovador( 
      id  SERIAL    NOT NULL  , 
      estado_pedido_venda_id integer   NOT NULL  , 
      aprovador_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE etapa_negociacao( 
      id  SERIAL    NOT NULL  , 
      nome text   , 
      cor text   , 
      ordem integer   , 
      roteiro text   , 
      kanban char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fabricante( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE familia_produto( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE forma_pagamento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_pessoa( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE matriz_estado_pedido_venda( 
      id  SERIAL    NOT NULL  , 
      estado_pedido_venda_origem_id integer   NOT NULL  , 
      estado_pedido_venda_destino_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      origem_contato_id integer   NOT NULL  , 
      etapa_negociacao_id integer   NOT NULL  , 
      data_inicio date   NOT NULL  , 
      data_fechamento date   , 
      data_fechamento_esperada date   , 
      valor_total float   , 
      ordem integer   , 
      mes integer   , 
      ano integer   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
      email_novo_pedido_enviado char  (1)     DEFAULT 'F', 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_arquivo( 
      id  SERIAL    NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      nome_arquivo text   , 
      conteudo_arquivo text   , 
      dt_arquivo timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_atividade( 
      id  SERIAL    NOT NULL  , 
      tipo_atividade_id integer   NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      descricao text   , 
      horario_inicial timestamp   , 
      horario_final timestamp   , 
      observacao text   , 
      dt_atividade timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_historico_etapa( 
      id  SERIAL    NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      etapa_negociacao_id integer   NOT NULL  , 
      dt_etapa timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_item( 
      id  SERIAL    NOT NULL  , 
      produto_id integer   NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      valor_total float   , 
      dt_item timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_observacao( 
      id  SERIAL    NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      observacao text   , 
      dt_observacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      pedido_venda_id integer   NOT NULL  , 
      condicao_pagamento_id integer   NOT NULL  , 
      obs text   , 
      mes integer   , 
      ano integer   , 
      valor_total float   , 
      data_emissao date   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal_item( 
      id  SERIAL    NOT NULL  , 
      pedido_venda_item_id integer   , 
      nota_fiscal_id integer   NOT NULL  , 
      produto_id integer   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      desconto float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_contato( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ouvidoria( 
      id  SERIAL    NOT NULL  , 
      tipo_ouvidoria_id integer   NOT NULL  , 
      nome text   , 
      telefone text   , 
      email text   , 
      mensagem text   NOT NULL  , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda( 
      id  SERIAL    NOT NULL  , 
      tipo_pedido_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      estado_pedido_venda_id integer   NOT NULL  , 
      condicao_pagamento_id integer   NOT NULL  , 
      transportadora_id integer   NOT NULL  , 
      negociacao_id integer   , 
      dt_pedido date   , 
      obs varchar  (255)   , 
      frete float   , 
      mes char  (2)   , 
      ano char  (4)   , 
      valor_total float   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
      obs_comercial text   , 
      obs_financeiro text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_historico( 
      id  SERIAL    NOT NULL  , 
      pedido_venda_id integer   NOT NULL  , 
      estado_pedido_venda_id integer   NOT NULL  , 
      aprovador_id integer   , 
      data_operacao timestamp   , 
      obs text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_item( 
      id  SERIAL    NOT NULL  , 
      pedido_venda_id integer   NOT NULL  , 
      produto_id integer   NOT NULL  , 
      quantidade float   , 
      valor float   , 
      desconto float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id  SERIAL    NOT NULL  , 
      tipo_cliente_id integer   NOT NULL  , 
      categoria_cliente_id integer   , 
      system_user_id integer   , 
      nome varchar  (500)   NOT NULL  , 
      documento varchar  (20)   NOT NULL  , 
      obs varchar  (1000)   , 
      fone varchar  (255)   , 
      email varchar  (255)   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
      login varchar  (255)   , 
      senha varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_contato( 
      id  SERIAL    NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
      email varchar  (255)   , 
      nome varchar  (255)   , 
      telefone varchar  (255)   , 
      obs varchar  (500)   , 
      created_at timestamp   , 
      updated_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_endereco( 
      id  SERIAL    NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
      cidade_id integer   NOT NULL  , 
      nome varchar  (255)   , 
      principal char  (1)   , 
      cep varchar  (10)   , 
      rua varchar  (500)   , 
      numero varchar  (20)   , 
      bairro varchar  (500)   , 
      complemento varchar  (500)   , 
      data_desativacao date   , 
      created_at timestamp   , 
      updated_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id  SERIAL    NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
      grupo_pessoa_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  SERIAL    NOT NULL  , 
      tipo_produto_id integer   NOT NULL  , 
      familia_produto_id integer   NOT NULL  , 
      fornecedor_id integer   NOT NULL  , 
      unidade_medida_id integer   NOT NULL  , 
      fabricante_id integer   , 
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
      data_ultimo_reajuste_preco timestamp   , 
      created_at timestamp   , 
      updated_at timestamp   , 
      deleted_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id integer   , 
      system_unit_id integer   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_anexo( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atividade( 
      id  SERIAL    NOT NULL  , 
      nome text   , 
      cor text   , 
      icone text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_cliente( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_ouvidoria( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_pedido( 
      id  SERIAL    NOT NULL  , 
      categoria_id integer   NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade_medida( 
      id  SERIAL    NOT NULL  , 
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
 
