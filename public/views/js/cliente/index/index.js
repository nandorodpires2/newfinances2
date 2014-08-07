/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    var data = null;
    var id_conta = null;

    buscaMovimentacoesData(data, id_conta);
        
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


