/* RELATORIO DE ENTRADAS, SAIDAS E SALDO ANO */
select	year(mov.data_movimentacao) as ano,
			tmv.tipo_movimentacao as tipo,
			sum(mov.valor_movimentacao) as total
from		movimentacao mov
			inner join tipo_movimentacao tmv on mov.id_tipo_movimentacao = tmv.id_tipo_movimentacao
where		mov.id_usuario = 1
			and mov.realizado = 1
			and mov.id_tipo_movimentacao in (1,2)
group by year(mov.data_movimentacao),
			mov.id_tipo_movimentacao