<?php

class FakeDataService
{
    public static function generatePedidosVenda()
    {
        // Código gerado pelo snippet: "Conexão com banco de dados"
        TTransaction::open('minierp');

        $produtos = Produto::getObjects();
        $estadosPedidovenda = EstadoPedidoVenda::getObjects();
        $etapasNegociacao = EtapaNegociacao::getObjects();
        $pessoas = Pessoa::getObjects();
        $origensContato = OrigemContato::getObjects();
        
        $vendedores = [];
        $clientes = [];
        for($i = 0; $i <= 5; $i++)
        {
            $vendedor = new Pessoa();
            $vendedor->nome = "Vendedor {$i}";
            $vendedor->documento = '11111111111';
            $vendedor->tipo_cliente_id = 2;
            $vendedor->store();
            
            $vendedores[] = $vendedor;
            
            $grupoPessoa = new PessoaGrupo();
            $grupoPessoa->pessoa_id = $vendedor->id;
            $grupoPessoa->grupo_pessoa_id = GrupoPessoa::VENDEDOR;
            $grupoPessoa->store();
        }
        
        for($i = 0; $i <= 50; $i++)
        {
            $cliente = new Pessoa();
            $cliente->nome = "Cliente {$i}";
            $cliente->documento = '11111111111';
            $cliente->tipo_cliente_id = 1;
            $cliente->store();
            
            $clientes[] = $cliente;
            
            $grupoPessoa = new PessoaGrupo();
            $grupoPessoa->pessoa_id = $cliente->id;
            $grupoPessoa->grupo_pessoa_id = GrupoPessoa::CLIENTE;
            $grupoPessoa->store();
        }
        
        
        for($i = 0; $i <= 400; $i++)
        {
            $mes = str_pad(rand(1,12), 2, "0", STR_PAD_LEFT);
            $dia = str_pad(rand(1,28), 2, "0", STR_PAD_LEFT);
            
            $pedido = new PedidoVenda();
            $pedido->cliente_id = $clientes[rand(0, count($clientes) -1)]->id;
            $pedido->vendedor_id = $vendedores[rand(0, count($vendedores) -1)]->id;
            $pedido->dt_pedido = '2022-'.$mes.'-'.$dia;
            $pedido->estado_pedido_venda_id = rand(1, count($estadosPedidovenda));
            $pedido->condicao_pagamento_id = 1;
            $pedido->transportadora_id = 4;
            $pedido->mes = $mes;
            $pedido->ano = '2022';
            $pedido->valor_total = 0;
            $pedido->tipo_pedido_id = 1;
            $pedido->store();
            
            for($x = 0; $x <= rand(1,5); $x++)
            {
                $produto = $produtos[rand(0, count($produtos)-1)] ?? $produtos[0];
                
                $pedidoVendaItem = new PedidoVendaItem();
                $pedidoVendaItem->pedido_venda_id = $pedido->id;
                $pedidoVendaItem->produto_id = $produto->id;
                $pedidoVendaItem->quantidade = rand(1,10);
                $pedidoVendaItem->valor = $produto->preco_venda;
                $pedidoVendaItem->valor_total = $pedidoVendaItem->quantidade * $pedidoVendaItem->valor;
                $pedidoVendaItem->store();
                
                $pedido->valor_total += $pedidoVendaItem->valor_total;
            }
            $pedido->store();
        }
        
        for($i = 0; $i <= 400; $i++)
        {
            $mes = str_pad(rand(1,12), 2, "0", STR_PAD_LEFT);
            $dia = str_pad(rand(1,28), 2, "0", STR_PAD_LEFT);
            
            $negociacao = new Negociacao();
            $negociacao->cliente_id = $clientes[rand(0, count($clientes) -1)]->id;
            $negociacao->vendedor_id = $vendedores[rand(0, count($vendedores) -1)]->id;
            $negociacao->data_inicio = '2022-'.$mes.'-'.$dia;
            
            $data_fechamento_esperada = new DateTime($negociacao->data_inicio);
            $data_fechamento_esperada->add(new DateInterval("P15D"));
            $negociacao->data_fechamento_esperada = $data_fechamento_esperada->format('Y-m-d');
            
            $negociacao->etapa_negociacao_id = rand(1, count($etapasNegociacao));
            $negociacao->origem_contato_id = rand(1, count($origensContato));
            
            if($negociacao->etapa_negociacao_id == EtapaNegociacao::FINALIZADA)
            {
                $data_fechamento_esperada = new DateTime($negociacao->data_inicio);
                $data_fechamento_esperada->add(new DateInterval("P8D"));
            
                $negociacao->data_fechamento = $data_fechamento_esperada->format('Y-m-d');
            }
            
            $negociacao->mes = $mes;
            $negociacao->ano = '2022';
            $negociacao->valor_total = 0;
            $negociacao->store();
            
            for($x = 0; $x <= rand(1,5); $x++)
            {
                $produto = $produtos[rand(0, count($produtos)-1)] ?? $produtos[0];
                
                $negociacaoItem = new NegociacaoItem();
                $negociacaoItem->negociacao_id = $negociacao->id;
                $negociacaoItem->produto_id = $produto->id;
                $negociacaoItem->quantidade = rand(1,10);
                $negociacaoItem->valor = $produto->preco_venda;
                $negociacaoItem->valor_total = $negociacaoItem->quantidade * $negociacaoItem->valor;
                $negociacaoItem->store();
                
                $negociacao->valor_total += $negociacaoItem->valor_total;
            }
            $negociacao->store();
        }
        
        $categoriasReceber = Categoria::where('tipo_conta_id', '=', TipoConta::RECEBER)->load();
        $categoriasPagar = Categoria::where('tipo_conta_id', '=', TipoConta::PAGAR)->load();
        
        for($i = 0; $i <= 400; $i++)
        {
            $conta = new Conta();
            $conta->pessoa_id = rand(1, count($pessoas));
            $conta->tipo_conta_id = rand(1,2);
            
            if($conta->tipo_conta_id == TipoConta::PAGAR)
            {
                $conta->categoria_id = $categoriasPagar[rand(0, count($categoriasPagar)-1)]->id;
            }
            else
            {
                $conta->categoria_id = $categoriasReceber[rand(0, count($categoriasReceber)-1)]->id;
            }
        
            $conta->forma_pagamento_id = rand(1,3);

            $mes = str_pad(rand(1,12), 2, "0", STR_PAD_LEFT);
            $dia = str_pad(rand(1,28), 2, "0", STR_PAD_LEFT);
            $conta->dt_emissao = '2022-'.$mes.'-'.$dia;
            
            $dtEmissao = new DateTime($conta->dt_emissao);
            $dtEmissao->add(new DateInterval("P5D"));
            $conta->dt_vencimento = $dtEmissao->format('Y-m-d');
            
            if(rand(1,2) == 2)
            {
                $conta->dt_pagamento = $conta->dt_vencimento;
            }
            
            $conta->valor = rand(50, 1000);
            $conta->store();
        }
        
        if(!is_dir('app/fotos/produtos'))
        {
            mkdir('app/fotos/produtos', 0777, true);    
        }
        
        file_put_contents('app/fotos/produtos/cadeiragamer.png',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/cadeiragamer.png'));
        file_put_contents('app/fotos/produtos/fifa.jpeg',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/fifa.jpeg'));
        file_put_contents('app/fotos/produtos/fifa2021.jpeg',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/fifa2021.jpeg'));
        file_put_contents('app/fotos/produtos/galaxy.png',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/galaxy.png'));
        file_put_contents('app/fotos/produtos/ipadpro.png',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/ipadpro.png'));
        file_put_contents('app/fotos/produtos/iphone.png',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/iphone.png'));
        file_put_contents('app/fotos/produtos/macboook.png',file_get_contents('https://www.adiantibuilder.com.br/images/mini-erp-builder-cast-images/macboook.png'));
        
        $produto_5 = new Produto(5);
        $produto_4 = new Produto(4);
        $produto_3 = new Produto(3);
        $produto_7 = new Produto(7);
        $produto_6 = new Produto(6);
        $produto_2 = new Produto(2);
        $produto_1 = new Produto(1);
        
        $produto_5->cod_barras = rand(1111111,9999999);
        $produto_4->cod_barras = rand(1111111,9999999);
        $produto_3->cod_barras = rand(1111111,9999999);
        $produto_7->cod_barras = rand(1111111,9999999);
        $produto_6->cod_barras = rand(1111111,9999999);
        $produto_2->cod_barras = rand(1111111,9999999);
        $produto_1->cod_barras = rand(1111111,9999999);
        
        $produto_5->foto = 'app/fotos/produtos/cadeiragamer.png';
        $produto_4->foto = 'app/fotos/produtos/fifa.jpeg';
        $produto_3->foto = 'app/fotos/produtos/fifa2021.jpeg';
        $produto_7->foto = 'app/fotos/produtos/galaxy.png';
        $produto_6->foto = 'app/fotos/produtos/ipadpro.png';
        $produto_2->foto = 'app/fotos/produtos/iphone.png';
        $produto_1->foto = 'app/fotos/produtos/macboook.png';
        
        $produto_5->store();
        $produto_4->store();
        $produto_3->store();
        $produto_7->store();
        $produto_6->store();
        $produto_2->store();
        $produto_1->store();
        
        
        TTransaction::close();
        // -----
    }
}
