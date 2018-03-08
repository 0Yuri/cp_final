// Este JavaScript está sendo adaptado para validar em tempo real na página de cadastro
// latreta


var teste = $('.testando'),
    saida = $('.saida');

var DURACAO_DIGITACAO = 400,
    digitando = false,
    tempoUltimaDigitacao;

teste.on('input', function () {
   atualiza();
});

function atualiza () {
    
    if(!digitando) {
        digitando = true;
        saida.html('procurando...');
    }
    
    tempoUltimaDigitacao = (new Date()).getTime();
    
    setTimeout(function () {
        
        var digitacaoTempo = (new Date()).getTime();
        var diferencaTempo = digitacaoTempo - tempoUltimaDigitacao;
        
        if(diferencaTempo >= DURACAO_DIGITACAO && digitando) {
            digitando = false;
            saida.html('exibe resultado...');
            //aqui você pode chamar a função ajax
        }
        
    }, DURACAO_DIGITACAO);
    
}