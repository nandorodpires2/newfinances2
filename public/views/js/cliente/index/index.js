/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    var data = null;
    var id_conta = null;

    buscaMovimentacoesData(data, id_conta);
    
    buscaGastosCategorias();
    buscaGastosOrcamento();
    
    $("#chart-movimentacao").click(function(){
        graficoReceitaDespesas();
    });
    
    $("#btn_data_movimentacao").click(function(){
        var data = $("#data_movimentacao").val();
        if (data == '') {
            alert("Preencha uma data!");
        } else {
            buscaMovimentacoesData(data, id_conta);
        }
    });
    
    /**
     * campo de pesquisa
     */
    jQuery("#pesquisar").focus(function() {
        jQuery(this).attr('style', 'width: 400px')
    });
    
    jQuery("#pesquisar").blur(function() {
        jQuery(this).attr('style', 'width: 200px')
    });
        
});

function buscaMovimentacoesData(data, id_conta) {
    
    var base_url = baseUrl();        
    $.ajax({        
        url: base_url + 'cliente/ajax/movimentacoes',
        type: "post",
        data: {
            data: data,
            id_conta: id_conta
        },
        dataType: "html",
        beforeSend: function() {            
            $("#movimentacoes").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Buscando lançamentos...");
        },
        success: function(dados) { 
            $("#movimentacoes").html(dados);
        },
        error: function(error) {
            //alert('Houve um erro');
        }
    });
    
}

function graficoReceitaDespesas() {
    var base_url = baseUrl();            
    
    $.ajax({        
        url: base_url + 'cliente/ajax/grafico-receitas-despesas',
        dataType: "json",
        beforeSend: function() {            
            $("#grafico-receitas-despesas").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Gerando o gráfico...");
        },
        success: function(json) { 
            $('#grafico-receitas-despesas').highcharts({
                chart: {
                    type: 'column',
                    width: $(".modal-dialog").innerWidth() - 50
                },
                title: {
                    text: 'Gráfico Receitas e Despesas'
                },
                subtitle: {
                    text: 'Anual'
                },
                xAxis: {
                    categories: json.categories.data
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Valores (R$)'
                    },
                    subtitle: {
                        text: 'Anual'
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, ',', '.');
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>R${point.y:,.2f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: "Receita",
                    data: json.receita.data
                }, {
                    name: "Despesa",
                    data: json.despesa.data
                }
                ]
            });
        },
        error: function(error) {
            //alert('Houve um erro');
        }
    });
}

function buscaGastosCategorias() {
    var base_url = baseUrl();            
    
    $.ajax({        
        url: base_url + 'cliente/ajax/grafico-categorias',
        dataType: "json",
        beforeSend: function() {            
            $("#dados-categorias").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Gerando o gráfico...");
        },
        success: function(json) { 
            if (json.dataCount > 0) {
                $('#dados-categorias').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: 0,//null,
                        plotShadow: false                        
                    },
                    title: {
                        text: 'Gráfico Categorias'
                    },
                    subtitle: {
                        text: 'Mês Atual'
                    },
                    tooltip: {
                        pointFormat: '<b>R${point.y:,.2f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        data: json.data
                    }]                
                });
            } else {
                $('#dados-categorias').html("<div class='text-warning'>Nenhum gráfico a ser exibido</div>");
            }
        },
        error: function(error) {
            //alert('Houve um erro');
        }
    });
}

function buscaGastosOrcamento() {
    
    var base_url = baseUrl(); 
    
    $.ajax({        
        url: base_url + 'cliente/ajax/grafico-orcamento',
        dataType: "json",
        beforeSend: function() {            
            $("#dados-orcamentos").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Gerando o gráfico...");
        },
        success: function(json) { 
            if (json.dataCount > 0) {
                $('#dados-orcamentos').highcharts({
                    chart: {
                        type: 'column'
                        //width: $(".modal-dialog").innerWidth() - 50
                    },
                    title: {
                        text: 'Gráfico Orçamentos'
                    },
                    subtitle: {
                        text: 'Mês Atual'
                    },
                    xAxis: {
                        categories: json.categories.data
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Valores (R$)'
                        },
                        labels: {
                            formatter: function() {
                                return Highcharts.numberFormat(this.value, 0, ',', '.');
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>R${point.y:,.2f}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: "Valor Orçamento",
                        data: json.total_orcamento.data
                    }, {
                        name: "Total Despesa",
                        data: json.total_despesa.data
                    }
                    ]
                });
            } else {
                $('#dados-orcamentos').html("<div class='text-warning'>Nenhum gráfico a ser exibido</div>");
            }
        },
        error: function(error) {
            //alert('Houve um erro');
        }
    });
}

