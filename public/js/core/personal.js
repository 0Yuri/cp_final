$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
};

var credit_card = {}

credit_card.criptografar = function(){
  var cc = new Moip.CreditCard({
    number  : $("#cc_number").val(),
    cvc     : $("#cc_cvc").val(),
    expMonth: $("#cc_exp_month").val(),
    expYear : $("#cc_exp_year").val(),
    pubKey  : $("#public_key").val()
  });

  if(cc.isValid()){
    return cc.hash();
  }
  else{
    alert('Cartão de crédito inválido, verifique os parâmetros!');
  }
}
