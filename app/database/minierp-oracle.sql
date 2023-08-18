CREATE TABLE api_error( 
      id number(10)    NOT NULL , 
      classe varchar  (255)   , 
      metodo varchar  (255)   , 
      url varchar  (500)   , 
      dados varchar  (3000)   , 
      error_message varchar  (3000)   , 
      created_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE aprovador( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id number(10)    NOT NULL , 
      tipo_conta_id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_cliente( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cep_cache( 
      id number(10)    NOT NULL , 
      cep varchar  (10)   , 
      rua varchar  (10)   , 
      cidade varchar  (500)   , 
      bairro varchar  (500)   , 
      codigo_ibge varchar  (20)   , 
      uf varchar  (2)   , 
      cidade_id number(10)   , 
      estado_id number(10)   , 
      created_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cidade( 
      id number(10)    NOT NULL , 
      estado_id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
      codigo_ibge varchar  (10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE condicao_pagamento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      numero_parcelas number(10)   , 
      inicio number(10)   , 
      intervalo number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
      tipo_conta_id number(10)    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
      forma_pagamento_id number(10)    NOT NULL , 
      pedido_venda_id number(10)   , 
      dt_vencimento date   , 
      dt_emissao date   , 
      dt_pagamento date   , 
      valor binary_double   , 
      parcela number(10)   , 
      obs varchar(3000)   , 
      mes_vencimento number(10)   , 
      ano_vencimento number(10)   , 
      ano_mes_vencimento number(10)   , 
      mes_emissao number(10)   , 
      ano_emissao number(10)   , 
      ano_mes_emissao number(10)   , 
      mes_pagamento number(10)   , 
      ano_pagamento number(10)   , 
      ano_mes_pagamento number(10)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta_anexo( 
      id number(10)    NOT NULL , 
      conta_id number(10)    NOT NULL , 
      tipo_anexo_id number(10)    NOT NULL , 
      descricao varchar(3000)   , 
      arquivo varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE email_template( 
      id number(10)    NOT NULL , 
      titulo varchar(3000)   , 
      mensagem varchar(3000)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE error_log_crontab( 
      id number(10)    NOT NULL , 
      classe varchar(3000)   , 
      metodo varchar(3000)   , 
      mensagem varchar(3000)   , 
      created_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
      sigla char  (2)    NOT NULL , 
      codigo_ibge varchar  (10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda( 
      id number(10)    NOT NULL , 
      nome varchar  (255)   , 
      cor varchar  (100)   , 
      kanban char  (1)   , 
      ordem number(10)   , 
      estado_final char  (1)   , 
      estado_inicial char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_pedido_venda_aprovador( 
      id number(10)    NOT NULL , 
      estado_pedido_venda_id number(10)    NOT NULL , 
      aprovador_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE etapa_negociacao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)   , 
      cor varchar(3000)   , 
      ordem number(10)   , 
      roteiro varchar(3000)   , 
      kanban char  (1)   , 
      permite_edicao char  (1)   , 
      permite_exclusao char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fabricante( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE familia_produto( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE forma_pagamento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo_pessoa( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE matriz_estado_pedido_venda( 
      id number(10)    NOT NULL , 
      estado_pedido_venda_origem_id number(10)    NOT NULL , 
      estado_pedido_venda_destino_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      origem_contato_id number(10)    NOT NULL , 
      etapa_negociacao_id number(10)    NOT NULL , 
      data_inicio date    NOT NULL , 
      data_fechamento date   , 
      data_fechamento_esperada date   , 
      valor_total binary_double   , 
      ordem number(10)   , 
      mes number(10)   , 
      ano number(10)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
      email_novo_pedido_enviado char  (1)    DEFAULT 'F' , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_arquivo( 
      id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      nome_arquivo varchar(3000)   , 
      conteudo_arquivo varchar(3000)   , 
      dt_arquivo timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_atividade( 
      id number(10)    NOT NULL , 
      tipo_atividade_id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      descricao varchar(3000)   , 
      horario_inicial timestamp(0)   , 
      horario_final timestamp(0)   , 
      observacao varchar(3000)   , 
      dt_atividade timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_historico_etapa( 
      id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      etapa_negociacao_id number(10)    NOT NULL , 
      dt_etapa timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_item( 
      id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      quantidade binary_double   , 
      valor binary_double   , 
      valor_total binary_double   , 
      dt_item timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_observacao( 
      id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      observacao varchar(3000)   , 
      dt_observacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      pedido_venda_id number(10)    NOT NULL , 
      condicao_pagamento_id number(10)    NOT NULL , 
      obs varchar(3000)   , 
      mes number(10)   , 
      ano number(10)   , 
      valor_total binary_double   , 
      data_emissao date   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota_fiscal_item( 
      id number(10)    NOT NULL , 
      pedido_venda_item_id number(10)   , 
      nota_fiscal_id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      quantidade binary_double   , 
      valor binary_double   , 
      desconto binary_double   , 
      valor_total binary_double   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_contato( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE ouvidoria( 
      id number(10)    NOT NULL , 
      tipo_ouvidoria_id number(10)    NOT NULL , 
      nome varchar(3000)   , 
      telefone varchar(3000)   , 
      email varchar(3000)   , 
      mensagem varchar(3000)    NOT NULL , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda( 
      id number(10)    NOT NULL , 
      tipo_pedido_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      estado_pedido_venda_id number(10)    NOT NULL , 
      condicao_pagamento_id number(10)    NOT NULL , 
      transportadora_id number(10)    NOT NULL , 
      negociacao_id number(10)   , 
      dt_pedido date   , 
      obs varchar  (255)   , 
      frete binary_double   , 
      mes char  (2)   , 
      ano char  (4)   , 
      valor_total binary_double   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
      obs_comercial varchar(3000)   , 
      obs_financeiro varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_historico( 
      id number(10)    NOT NULL , 
      pedido_venda_id number(10)    NOT NULL , 
      estado_pedido_venda_id number(10)    NOT NULL , 
      aprovador_id number(10)   , 
      data_operacao timestamp(0)   , 
      obs varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pedido_venda_item( 
      id number(10)    NOT NULL , 
      pedido_venda_id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      quantidade binary_double   , 
      valor binary_double   , 
      desconto binary_double   , 
      valor_total binary_double   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id number(10)    NOT NULL , 
      tipo_cliente_id number(10)    NOT NULL , 
      categoria_cliente_id number(10)   , 
      system_user_id number(10)   , 
      nome varchar  (500)    NOT NULL , 
      documento varchar  (20)    NOT NULL , 
      obs varchar  (1000)   , 
      fone varchar  (255)   , 
      email varchar  (255)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
      login varchar  (255)   , 
      senha varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_contato( 
      id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
      email varchar  (255)   , 
      nome varchar  (255)   , 
      telefone varchar  (255)   , 
      obs varchar  (500)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_endereco( 
      id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
      cidade_id number(10)    NOT NULL , 
      nome varchar  (255)   , 
      principal char  (1)   , 
      cep varchar  (10)   , 
      rua varchar  (500)   , 
      numero varchar  (20)   , 
      bairro varchar  (500)   , 
      complemento varchar  (500)   , 
      data_desativacao date   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
      grupo_pessoa_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id number(10)    NOT NULL , 
      tipo_produto_id number(10)    NOT NULL , 
      familia_produto_id number(10)    NOT NULL , 
      fornecedor_id number(10)    NOT NULL , 
      unidade_medida_id number(10)    NOT NULL , 
      fabricante_id number(10)   , 
      nome varchar  (255)    NOT NULL , 
      cod_barras varchar  (255)   , 
      preco_venda binary_double   , 
      preco_custo binary_double   , 
      peso_liquido binary_double   , 
      peso_bruto binary_double   , 
      largura binary_double   , 
      altura binary_double   , 
      volume binary_double   , 
      estoque_minimo binary_double   , 
      qtde_estoque binary_double   , 
      estoque_maximo binary_double   , 
      obs varchar  (500)   , 
      ativo char  (1)   , 
      foto varchar  (500)   , 
      data_ultimo_reajuste_preco timestamp(0)   , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      deleted_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_anexo( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atividade( 
      id number(10)    NOT NULL , 
      nome varchar(3000)   , 
      cor varchar(3000)   , 
      icone varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_cliente( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
      sigla char  (2)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_ouvidoria( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_pedido( 
      id number(10)    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade_medida( 
      id number(10)    NOT NULL , 
      nome varchar  (255)    NOT NULL , 
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
 CREATE SEQUENCE api_error_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER api_error_id_seq_tr 

BEFORE INSERT ON api_error FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT api_error_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE aprovador_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER aprovador_id_seq_tr 

BEFORE INSERT ON aprovador FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT aprovador_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE categoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_id_seq_tr 

BEFORE INSERT ON categoria FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT categoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE categoria_cliente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_cliente_id_seq_tr 

BEFORE INSERT ON categoria_cliente FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT categoria_cliente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cep_cache_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cep_cache_id_seq_tr 

BEFORE INSERT ON cep_cache FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT cep_cache_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cidade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cidade_id_seq_tr 

BEFORE INSERT ON cidade FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT cidade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE condicao_pagamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER condicao_pagamento_id_seq_tr 

BEFORE INSERT ON condicao_pagamento FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT condicao_pagamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER conta_id_seq_tr 

BEFORE INSERT ON conta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE conta_anexo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER conta_anexo_id_seq_tr 

BEFORE INSERT ON conta_anexo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT conta_anexo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE email_template_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER email_template_id_seq_tr 

BEFORE INSERT ON email_template FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT email_template_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE error_log_crontab_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER error_log_crontab_id_seq_tr 

BEFORE INSERT ON error_log_crontab FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT error_log_crontab_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_id_seq_tr 

BEFORE INSERT ON estado FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT estado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_pedido_venda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_pedido_venda_id_seq_tr 

BEFORE INSERT ON estado_pedido_venda FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT estado_pedido_venda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_pedido_venda_aprovador_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_pedido_venda_aprovador_id_seq_tr 

BEFORE INSERT ON estado_pedido_venda_aprovador FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT estado_pedido_venda_aprovador_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE etapa_negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER etapa_negociacao_id_seq_tr 

BEFORE INSERT ON etapa_negociacao FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT etapa_negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE fabricante_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER fabricante_id_seq_tr 

BEFORE INSERT ON fabricante FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT fabricante_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE familia_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER familia_produto_id_seq_tr 

BEFORE INSERT ON familia_produto FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT familia_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE forma_pagamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER forma_pagamento_id_seq_tr 

BEFORE INSERT ON forma_pagamento FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT forma_pagamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE grupo_pessoa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER grupo_pessoa_id_seq_tr 

BEFORE INSERT ON grupo_pessoa FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT grupo_pessoa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE matriz_estado_pedido_venda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER matriz_estado_pedido_venda_id_seq_tr 

BEFORE INSERT ON matriz_estado_pedido_venda FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT matriz_estado_pedido_venda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_id_seq_tr 

BEFORE INSERT ON negociacao FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_arquivo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_arquivo_id_seq_tr 

BEFORE INSERT ON negociacao_arquivo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_arquivo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_atividade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_atividade_id_seq_tr 

BEFORE INSERT ON negociacao_atividade FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_atividade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_historico_etapa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_historico_etapa_id_seq_tr 

BEFORE INSERT ON negociacao_historico_etapa FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_historico_etapa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_item_id_seq_tr 

BEFORE INSERT ON negociacao_item FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_observacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_observacao_id_seq_tr 

BEFORE INSERT ON negociacao_observacao FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT negociacao_observacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE nota_fiscal_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER nota_fiscal_id_seq_tr 

BEFORE INSERT ON nota_fiscal FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT nota_fiscal_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE nota_fiscal_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER nota_fiscal_item_id_seq_tr 

BEFORE INSERT ON nota_fiscal_item FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT nota_fiscal_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE origem_contato_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER origem_contato_id_seq_tr 

BEFORE INSERT ON origem_contato FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT origem_contato_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE ouvidoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER ouvidoria_id_seq_tr 

BEFORE INSERT ON ouvidoria FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT ouvidoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pedido_venda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pedido_venda_id_seq_tr 

BEFORE INSERT ON pedido_venda FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pedido_venda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pedido_venda_historico_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pedido_venda_historico_id_seq_tr 

BEFORE INSERT ON pedido_venda_historico FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pedido_venda_historico_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pedido_venda_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pedido_venda_item_id_seq_tr 

BEFORE INSERT ON pedido_venda_item FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pedido_venda_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_id_seq_tr 

BEFORE INSERT ON pessoa FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pessoa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_contato_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_contato_id_seq_tr 

BEFORE INSERT ON pessoa_contato FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pessoa_contato_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_endereco_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_endereco_id_seq_tr 

BEFORE INSERT ON pessoa_endereco FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pessoa_endereco_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_grupo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_grupo_id_seq_tr 

BEFORE INSERT ON pessoa_grupo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pessoa_grupo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER produto_id_seq_tr 

BEFORE INSERT ON produto FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_anexo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_anexo_id_seq_tr 

BEFORE INSERT ON tipo_anexo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_anexo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_atividade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_atividade_id_seq_tr 

BEFORE INSERT ON tipo_atividade FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_atividade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_cliente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_cliente_id_seq_tr 

BEFORE INSERT ON tipo_cliente FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_cliente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_conta_id_seq_tr 

BEFORE INSERT ON tipo_conta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_ouvidoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_ouvidoria_id_seq_tr 

BEFORE INSERT ON tipo_ouvidoria FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_ouvidoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_pedido_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_pedido_id_seq_tr 

BEFORE INSERT ON tipo_pedido FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_pedido_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_produto_id_seq_tr 

BEFORE INSERT ON tipo_produto FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE unidade_medida_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER unidade_medida_id_seq_tr 

BEFORE INSERT ON unidade_medida FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT unidade_medida_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
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
 
