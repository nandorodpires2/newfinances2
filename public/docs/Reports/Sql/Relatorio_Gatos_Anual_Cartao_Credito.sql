/* TOTAL COMPRAS CARTAO DE CREDITO */
select	year(mov.data_movimentacao) as ano,
			ctr.descricao_cartao as cartao,
			sum(mov.valor_movimentacao) as total
from		movimentacao mov
			inner join cartao ctr on mov.id_cartao = ctr.id_cartao
where		mov.id_usuario = 1
			and mov.id_tipo_movimentacao = 3
			and  mov.realizado = 1
group by mov.id_cartao,
			year(mov.data_movimentacao)