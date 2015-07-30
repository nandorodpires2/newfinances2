/* SALDO ANUAL */
set		@ano := 2015;
select	month(mov.data_movimentacao) as mes,
			sum(mov.valor_movimentacao) as saldo
from		movimentacao mov
where		year(mov.data_movimentacao) = @ano
			and mov.id_tipo_movimentacao in (1,2)
			and mov.realizado = 1
group by month(mov.data_movimentacao)