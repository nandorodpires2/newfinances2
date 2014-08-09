/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    var data = null;
    var id_conta = null;

    buscaMovimentacoesData(data, id_conta);
    
    $("#chart-movimentacao").click(function(){
        graficoReceitaDespesas();
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
            $("#movimentacoes").html("Buscando as movimentações...");
        },
        success: function(dados) { 
            $("#movimentacoes").html(dados);
        },
        error: function(error) {
            alert('Houve um erro');
        }
    });
    
}

function graficoReceitaDespesas() {
    var base_url = baseUrl();        
    base_url + 'cliente/ajax/grafico-receitas-despesas';
    
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'column2d',
            renderAt: 'grafico-receitas-despesas',
            width: '500',
            height: '300',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Comparison of Quarterly Revenue",
                    "subCaption": "Harry's SuperMart",
                    "xAxisname": "Quarter",
                    "yAxisName": "Amount ($)",
                    "numberPrefix": "$",
                    // Theme can be set to "zune", "ocean" or "carbon"
                    "theme": "zune"
                },
                "categories": [{
                    "category": [
                        { "label": "Q1" },
                        { "label": "Q2" },
                        { "label": "Q3" },
                        { "label": "Q4" }
                    ]
                }],
                "dataset": [
                    {
                        "seriesname": "Previous Year",
                        "data": [
                            { "value": "10000" },
                            { "value": "11500" },
                            { "value": "12500" },
                            { "value": "15000" }
                        ]
                    },
                    {
                        "seriesname": "Current Year",
                        "data": [
                            { "value": "25400" },
                            { "value": "29800" },
                            { "value": "21800" },
                            { "value": "26800" }
                        ]
                    }
                ]
            }
        });

        revenueChart.render();
    });
    
}


