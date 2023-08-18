PRAGMA foreign_keys=OFF; 

CREATE TABLE api_error( 
      id  INTEGER    NOT NULL  , 
      classe varchar  (255)   , 
      metodo varchar  (255)   , 
      url varchar  (500)   , 
      dados varchar  (3000)   , 
      error_message varchar  (3000)   , 
      created_at datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE aprovador( 
      id  INTEGER    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE categoria( 
      id  INTEGER    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_conta_id) REFERENCES tipo_conta(id)) ; 

CREATE TABLE categoria_cliente( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cep_cache( 
      id  INTEGER    NOT NULL  , 
      cep varchar  (10)   , 
      rua varchar  (10)   , 
      cidade varchar  (500)   , 
      bairro varchar  (500)   , 
      codigo_ibge varchar  (20)   , 
      uf varchar  (2)   , 
      cidade_id int   , 
      estado_id int   , 
      created_at datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cidade( 
      id  INTEGER    NOT NULL  , 
      estado_id int   NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      codigo_ibge varchar  (10)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado_id) REFERENCES estado(id)) ; 

CREATE TABLE condicao_pagamento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      numero_parcelas int   , 
      inicio int   , 
      intervalo int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  INTEGER    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      forma_pagamento_id int   NOT NULL  , 
      pedido_venda_id int   , 
      dt_vencimento date   , 
      dt_emissao date   , 
      dt_pagamento date   , 
      valor double   , 
      parcela int   , 
      obs text   , 
      mes_vencimento int   , 
      ano_vencimento int   , 
      ano_mes_vencimento int   , 
      mes_emissao int   , 
      ano_emissao int   , 
      ano_mes_emissao int   , 
      mes_pagamento int   , 
      ano_pagamento int   , 
      ano_mes_pagamento int   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_conta_id) REFERENCES tipo_conta(id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id),
FOREIGN KEY(forma_pagamento_id) REFERENCES forma_pagamento(id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id),
FOREIGN KEY(pedido_venda_id) REFERENCES pedido_venda(id)) ; 

CREATE TABLE conta_anexo( 
      id  INTEGER    NOT NULL  , 
      conta_id int   NOT NULL  , 
      tipo_anexo_id int   NOT NULL  , 
      descricao text   , 
      arquivo text   , 
 PRIMARY KEY (id),
FOREIGN KEY(conta_id) REFERENCES conta(id),
FOREIGN KEY(tipo_anexo_id) REFERENCES tipo_anexo(id)) ; 

CREATE TABLE email_template( 
      id  INTEGER    NOT NULL  , 
      titulo text   , 
      mensagem text   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE error_log_crontab( 
      id  INTEGER    NOT NULL  , 
      classe text   , 
      metodo text   , 
      mensagem text   , 
      created_at datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
      codigo_ibge varchar  (10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   , 
      cor varchar  (100)   , 
      kanban char  (1)   , 
      ordem int   , 
      estado_final char  (1)   , 
      estado_inicial char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda_aprovador( 
      id  INTEGER    NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      aprovador_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado_pedido_venda_id) REFERENCES estado_pedido_venda(id),
FOREIGN KEY(aprovador_id) REFERENCES aprovador(id)) ; 

CREATE TABLE etapa_negociacao( 
      id  INTEGER    NOT NULL  , 
      nome text   , 
      cor text   , 
      ordem int   , 
      roteiro text   , 
      kanban char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fabricante( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE familia_produto( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE forma_pagamento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_pessoa( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE matriz_estado_pedido_venda( 
      id  INTEGER    NOT NULL  , 
      estado_pedido_venda_origem_id int   NOT NULL  , 
      estado_pedido_venda_destino_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado_pedido_venda_origem_id) REFERENCES estado_pedido_venda(id),
FOREIGN KEY(estado_pedido_venda_destino_id) REFERENCES estado_pedido_venda(id)) ; 

CREATE TABLE negociacao( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      origem_contato_id int   NOT NULL  , 
      etapa_negociacao_id int   NOT NULL  , 
      data_inicio date   NOT NULL  , 
      data_fechamento date   , 
      data_fechamento_esperada date   , 
      valor_total double   , 
      ordem int   , 
      mes int   , 
      ano int   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
      email_novo_pedido_enviado char  (1)     DEFAULT 'F', 
 PRIMARY KEY (id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(origem_contato_id) REFERENCES origem_contato(id),
FOREIGN KEY(etapa_negociacao_id) REFERENCES etapa_negociacao(id)) ; 

CREATE TABLE negociacao_arquivo( 
      id  INTEGER    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      nome_arquivo text   , 
      conteudo_arquivo text   , 
      dt_arquivo datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id)) ; 

CREATE TABLE negociacao_atividade( 
      id  INTEGER    NOT NULL  , 
      tipo_atividade_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      descricao text   , 
      horario_inicial datetime   , 
      horario_final datetime   , 
      observacao text   , 
      dt_atividade datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id),
FOREIGN KEY(tipo_atividade_id) REFERENCES tipo_atividade(id)) ; 

CREATE TABLE negociacao_historico_etapa( 
      id  INTEGER    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      etapa_negociacao_id int   NOT NULL  , 
      dt_etapa datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id),
FOREIGN KEY(etapa_negociacao_id) REFERENCES etapa_negociacao(id)) ; 

CREATE TABLE negociacao_item( 
      id  INTEGER    NOT NULL  , 
      produto_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      quantidade double   , 
      valor double   , 
      valor_total double   , 
      dt_item datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id),
FOREIGN KEY(produto_id) REFERENCES produto(id)) ; 

CREATE TABLE negociacao_observacao( 
      id  INTEGER    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      observacao text   , 
      dt_observacao datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id)) ; 

CREATE TABLE nota_fiscal( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      condicao_pagamento_id int   NOT NULL  , 
      obs text   , 
      mes int   , 
      ano int   , 
      valor_total double   , 
      data_emissao date   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(pedido_venda_id) REFERENCES pedido_venda(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id),
FOREIGN KEY(condicao_pagamento_id) REFERENCES condicao_pagamento(id)) ; 

CREATE TABLE nota_fiscal_item( 
      id  INTEGER    NOT NULL  , 
      pedido_venda_item_id int   , 
      nota_fiscal_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade double   , 
      valor double   , 
      desconto double   , 
      valor_total double   , 
 PRIMARY KEY (id),
FOREIGN KEY(pedido_venda_item_id) REFERENCES pedido_venda_item(id),
FOREIGN KEY(nota_fiscal_id) REFERENCES nota_fiscal(id),
FOREIGN KEY(produto_id) REFERENCES produto(id)) ; 

CREATE TABLE origem_contato( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ouvidoria( 
      id  INTEGER    NOT NULL  , 
      tipo_ouvidoria_id int   NOT NULL  , 
      nome text   , 
      telefone text   , 
      email text   , 
      mensagem text   NOT NULL  , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_ouvidoria_id) REFERENCES tipo_ouvidoria(id)) ; 

CREATE TABLE pedido_venda( 
      id  INTEGER    NOT NULL  , 
      tipo_pedido_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      condicao_pagamento_id int   NOT NULL  , 
      transportadora_id int   NOT NULL  , 
      negociacao_id int   , 
      dt_pedido date   , 
      obs varchar  (255)   , 
      frete double   , 
      mes char  (2)   , 
      ano char  (4)   , 
      valor_total double   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
      obs_comercial text   , 
      obs_financeiro text   , 
 PRIMARY KEY (id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(estado_pedido_venda_id) REFERENCES estado_pedido_venda(id),
FOREIGN KEY(condicao_pagamento_id) REFERENCES condicao_pagamento(id),
FOREIGN KEY(transportadora_id) REFERENCES pessoa(id),
FOREIGN KEY(tipo_pedido_id) REFERENCES tipo_pedido(id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id)) ; 

CREATE TABLE pedido_venda_historico( 
      id  INTEGER    NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      estado_pedido_venda_id int   NOT NULL  , 
      aprovador_id int   , 
      data_operacao datetime   , 
      obs text   , 
 PRIMARY KEY (id),
FOREIGN KEY(pedido_venda_id) REFERENCES pedido_venda(id),
FOREIGN KEY(estado_pedido_venda_id) REFERENCES estado_pedido_venda(id),
FOREIGN KEY(aprovador_id) REFERENCES aprovador(id)) ; 

CREATE TABLE pedido_venda_item( 
      id  INTEGER    NOT NULL  , 
      pedido_venda_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade double   , 
      valor double   , 
      desconto double   , 
      valor_total double   , 
 PRIMARY KEY (id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(pedido_venda_id) REFERENCES pedido_venda(id)) ; 

CREATE TABLE pessoa( 
      id  INTEGER    NOT NULL  , 
      tipo_cliente_id int   NOT NULL  , 
      categoria_cliente_id int   , 
      system_user_id int   , 
      nome varchar  (500)   NOT NULL  , 
      documento varchar  (20)   NOT NULL  , 
      obs varchar  (1000)   , 
      fone varchar  (255)   , 
      email varchar  (255)   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
      login varchar  (255)   , 
      senha varchar  (255)   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_cliente_id) REFERENCES tipo_cliente(id),
FOREIGN KEY(categoria_cliente_id) REFERENCES categoria_cliente(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE pessoa_contato( 
      id  INTEGER    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      email varchar  (255)   , 
      nome varchar  (255)   , 
      telefone varchar  (255)   , 
      obs varchar  (500)   , 
      created_at datetime   , 
      updated_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id)) ; 

CREATE TABLE pessoa_endereco( 
      id  INTEGER    NOT NULL  , 
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
      created_at datetime   , 
      updated_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id),
FOREIGN KEY(cidade_id) REFERENCES cidade(id)) ; 

CREATE TABLE pessoa_grupo( 
      id  INTEGER    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      grupo_pessoa_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id),
FOREIGN KEY(grupo_pessoa_id) REFERENCES grupo_pessoa(id)) ; 

CREATE TABLE produto( 
      id  INTEGER    NOT NULL  , 
      tipo_produto_id int   NOT NULL  , 
      familia_produto_id int   NOT NULL  , 
      fornecedor_id int   NOT NULL  , 
      unidade_medida_id int   NOT NULL  , 
      fabricante_id int   , 
      nome varchar  (255)   NOT NULL  , 
      cod_barras varchar  (255)   , 
      preco_venda double   , 
      preco_custo double   , 
      peso_liquido double   , 
      peso_bruto double   , 
      largura double   , 
      altura double   , 
      volume double   , 
      estoque_minimo double   , 
      qtde_estoque double   , 
      estoque_maximo double   , 
      obs varchar  (500)   , 
      ativo char  (1)   , 
      foto varchar  (500)   , 
      data_ultimo_reajuste_preco datetime   , 
      created_at datetime   , 
      updated_at datetime   , 
      deleted_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_produto_id) REFERENCES tipo_produto(id),
FOREIGN KEY(familia_produto_id) REFERENCES familia_produto(id),
FOREIGN KEY(fabricante_id) REFERENCES fabricante(id),
FOREIGN KEY(unidade_medida_id) REFERENCES unidade_medida(id),
FOREIGN KEY(fornecedor_id) REFERENCES pessoa(id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id),
FOREIGN KEY(frontpage_id) REFERENCES system_program(id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE tipo_anexo( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atividade( 
      id  INTEGER    NOT NULL  , 
      nome text   , 
      cor text   , 
      icone text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_cliente( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_ouvidoria( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_pedido( 
      id  INTEGER    NOT NULL  , 
      categoria_id int   NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id)) ; 

CREATE TABLE tipo_produto( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade_medida( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)   NOT NULL  , 
      sigla char  (2)   , 
 PRIMARY KEY (id)) ; 

 
 
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
 
