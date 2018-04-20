<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorreiosError extends Model
{
    // Código -1
    const COD_SERV_INVALIDO = "Código de serviço inválido.";
    // Código -2
    const CEP_ORIGEM_INVALID = "CEP de origem inválido.";
    // Código -3
    const CEP_DESTINO_INVALID = "CEP de origem inválido.";
    // Código -4
    const PESO_EXCEDIDO = "Peso do pacote foi excedido.";
    // -5 O Valor Declarado não deve exceder R$ 10.000,00
    const VALOR_EXCEDIDO = "O Valor Declarado não deve exceder R$ 10.000,00.";
    // -6 Serviço indisponível para o trecho informado
    const SERV_INDIS_TRECHO = "Serviço indisponível para o trecho informado.";
    // -7 O Valor Declarado é obrigatório para este serviço
    const VALOR_DECLA_OBRIG = "O Valor Declarado é obrigatório para este serviço.";
    // -8 Este serviço não aceita Mão Própria
    const MAO_PROPRIA = "Este serviço não aceita Mão Própria.";
    // -9 Este serviço não aceita Aviso de Recebimento
    const N_ACEITA_AVISO = "Este serviço não aceita Aviso de Recebimento";
    // -10 Precificação indisponível para o trecho informado
    const PRECIFI_INDIS = "Precificação indisponível para o trecho informado";
    // -11 ou -40 Para definição do preço deverão ser informados, também, o comprimento, a
    // largura e altura do objeto em centímetros (cm).
    const MEDIDAS_N_INFO = "É preciso informar as medidas(comprimento, largura e altura) em centímetros(cm).";
    // -12 e -24 Comprimento inválido.
    const COMPRIMENTO_INVALIDO = "Comprimento do pacote é inválido.";
    // -13 Largura inválida.
    const LARGURA_INVALID = "Largura do pacote é inválida.";
    // -14 Altura inválida.
    const ALTURA_INVALID = "Altura do pacote é inválida.";
    // -15 O comprimento não pode ser maior que 105 cm.
    const COMPRIMENTO_EXCED = "O comprimento não pode ser maior que 105 cm.";
    // -16 A largura não pode ser maior que 105 cm.
    const LARGURA_EXCED = "A largura não pode ser maior que 105 cm.";
    // -17 A altura não pode ser maior que 105 cm.
    const ALTURA_EXCED = "A altura não pode ser maior que 105 cm.";
    // -18 A altura não pode ser inferior a 2 cm.
    const ALTURA_MENOR = "A altura não pode ser inferior a 2 cm.";
    // -20 A largura não pode ser inferior a 11 cm.
    const LARGURA_MENOR = "A largura não pode ser inferior a 11 cm.";
    // -22 O comprimento não pode ser inferior a 16 cm.
    const COMPRIMENTO_MENOR = "O comprimento não pode ser inferior a 16 cm."; // TODO:AVALIAR
    // -23 A soma resultante do comprimento + largura + altura não deve superar a 200 cm.
    const SOMA_RESULTANTE = "A soma resultante do comprimento + largura + altura não deve superar a 200 cm.";    
    // -25 Diâmetro inválido.
    const DIAMETRO_INVALID = "Diâmetro inválido.";
    // -26 Informe o comprimento.
    const COMPRIMENTO_N_INFO = "Informe o comprimento.";
    // -27 Informe o diâmetro.
    const DIAMETRO_N_INFO = "Informe o diâmetro.";
    // -28 O comprimento não pode ser maior que 105 cm.
    const COMPRIMENTO_MAIOR = "O comprimento não pode ser maior que 105 cm.";
    // -29 O diâmetro não pode ser maior que 91 cm.
    const DIAMETRO_EXCED = "O diâmetro não pode ser maior que 91 cm.";
    // -30 O comprimento não pode ser inferior a 18 cm.
    const COMPRIMENTO_MENOR2 = "O comprimento não pode ser inferior a 18 cm."; // TODO:AVALIAR
    // -31 O diâmetro não pode ser inferior a 5 cm.
    const DIAMETRO_MENOR = "O diâmetro não pode ser inferior a 5 cm.";
    // -32 A soma resultante do comprimento + o dobro do diâmetro não deve superar a
    // 200 cm.
    const SOMA_RESULTANTE_DIAMETRO = "A soma resultante do comprimento + o dobro do diâmetro não deve superar a 200 cm.";
    // -33 Sistema temporariamente fora do ar. Favor tentar mais tarde.
    const FORA_DO_AR = "Sistema temporariamente fora do ar. Favor tentar mais tarde.";
    // -34 Código Administrativo ou Senha inválidos.
    const COD_ADMIN_INVALID = "Código Administrativo ou Senha inválidos.";
    // -35 Senha incorreta.
    const SENHA_INCORRETA = "Senha incorreta.";
    // -36 Cliente não possui contrato vigente com os Correios.
    const CLIENTE_SEM_CONTR = "Cliente não possui contrato vigente com os Correios.";
    // -37 Cliente não possui serviço ativo em seu contrato.
    const CLIENT_SERV_N_ATIVO = "Cliente não possui serviço ativo em seu contrato.";
    // -38 Serviço indisponível para este código administrativo.
    const SERV_INDISPO_ADMIN = "Serviço indisponível para este código administrativo.";
    // -39 Peso excedido para o formato envelope
    const PESO_EXCED_ENVELOP = "Peso excedido para o formato envelope.";
    // -41 O comprimento nao pode ser maior que 60 cm.
    const COMP_MAIOR_60 = "O comprimento nao pode ser maior que 60 cm.";
    // -42 O comprimento nao pode ser inferior a 16 cm.
    const COMP_MENOR_16 = "O comprimento nao pode ser menor que 16 cm.";
    // -43 A soma resultante do comprimento + largura nao deve superar a 120 cm.
    const COMP_E_LARGURA = "A soma resultante do comprimento + largura nao deve superar a 120 cm.";
    // -44 A largura nao pode ser inferior a 11 cm.
    const LARG_MENOR_11 = "A largura nao pode ser inferior a 11 cm.";
    // -45 A largura nao pode ser maior que 60 cm.
    const LARG_MAIOR_60 = "A largura não pode ser maior que 60cm.";
    // -888 Erro ao calcular a tarifa
    const ERRO_TARIFA = "Erro ao calcular a tarifa.";
    // 006 Localidade de origem não abrange o serviço informado
    const LOCAL_ORIG = "Localidade de origem não abrange o serviço informado.";
    // 007 Localidade de destino não abrange o serviço informado
    const LOCAL_DEST = "Localidade de destino não abrange o serviço informado.";
    // 008 Serviço indisponível para o trecho informado
    const SERVIC_INDISP = "Serviço indisponível para o trecho informado.";
    // 009 CEP inicial pertencente a Área de Risco.
    const CEP_ORIG_RISCO = "CEP inicial pertencente a Área de Risco.";
    // 010 CEP de destino está temporariamente sem entrega domiciliar. A entrega será
    // efetuada na agência indicada no Aviso de Chegada que será entregue no
    // endereço do destinatário
    const CEP_DEST_TEMP_ENT = "CEP de destino está temporariamente sem entrega domiciliar. A entrega será 
    efetuada na agência indicada no Aviso de Chegada que será entregue no endereço do destinatário";
    // 011 CEP de destino está sujeito a condições especiais de entrega pela ECT e será
    // realizada com o acréscimo de até 7 (sete) dias úteis ao prazo regular.
    const CEP_DEST_TEMP_AUMENTO = "CEP de destino está sujeito a condições especiais de entrega pela ECT e será
     realizada com o acréscimo de até 7 (sete) dias úteis ao prazo regular.";
    // 99 Outros erros diversos do .Net
    const ERRO_DOT_NET = "Outros erros diversos do .Net.";
    // Código 0 Processo concluído com sucesso
    const OKAY_STATUS = "Processo concluído com sucesso.";
    // Código 7 Serviço indisponível
    const SERV_INDISPONIVEL = "Serviço indisponível, Tente novamente mais tarde!";
    
    public static function tratarErro($codigo = "0"){
        switch($codigo){
            case "0":
                return CorreiosError::OKAY_STATUS;
                break;
            case "7":
                return CorreiosError::SERV_INDISPONIVEL;
                break;
            case "-1":
                return CorreiosError::COD_SERV_INVALIDO;
                break;
            case "-2":
                return CorreiosError::CEP_ORIGEM_INVALID;
                break;
            case "-3":
                return CorreiosError::CEP_DESTINO_INVALID;
                break;
            case "-4":
                return CorreiosError::PESO_EXCEDIDO;
                break;
            case "-5":
                return CorreiosError::VALOR_EXCEDIDO;
                break;
            case "-6":
                return CorreiosError::SERV_INDIS_TRECHO;
                break;
            case "-7":
                return CorreiosError::VALOR_DECLA_OBRIG;
                break;
            case "-8":
                return CorreiosError::MAO_PROPRIA;
                break;
            case "-9":
                return CorreiosError::N_ACEITA_AVISO;
                break;
            case "-10":
                return CorreiosError::PRECIFI_INDIS;
                break;
            case "-11":
                return CorreiosError::MEDIDAS_N_INFO;
                break;
            case "-12":
                return CorreiosError::COMPRIMENTO_INVALIDO;
                break;
            case "-13":
                return CorreiosError::LARGURA_INVALID;
                break;
            case "-14":
                return CorreiosError::ALTURA_INVALID;
                break;
            case "-15":
                return CorreiosError::COMPRIMENTO_EXCED;
                break;
            case "-16":
                return CorreiosError::LARGURA_EXCED;
                break;
            case "-17":
                return CorreiosError::ALTURA_EXCED;
                break;
            case "-18":
                return CorreiosError::ALTURA_MENOR;
                break;
            case "-20":
                return CorreiosError::LARGURA_MENOR;
                break;
            case "-22":
                return CorreiosError::COMPRIMENTO_MENOR;
                break;
            case "-23":
                return CorreiosError::SOMA_RESULTANTE;
                break;
            case "-24":
                return CorreiosError::COMPRIMENTO_INVALIDO;
                break;
            case "-25":
                return CorreiosError::DIAMETRO_INVALID;
                break;
            case "-26":
                return CorreiosError::COMPRIMENTO_N_INFO;
                break;
            case "-27";
                return CorreiosError::DIAMETRO_N_INFO;
                break;
            case "-28":
                return CorreiosError::COMPRIMENTO_MAIOR;
                break;
            case "-29":
                return CorreiosError::DIAMETRO_EXCED;
                break;
            case "-30":
                return CorreiosError::COMPRIMENTO_MENOR2;
                break;
            case "-31":
                return CorreiosError::DIAMETRO_MENOR;
                break;
            case "-32":
                return CorreiosError::SOMA_RESULTANTE_DIAMETRO;
                break;
            case "-33":
                return CorreiosError::FORA_DO_AR;
                break;
            case "-34":
                return CorreiosError::COD_ADMIN_INVALID;
                break;
            case "-35":
                return CorreiosError::SENHA_INCORRETA;
                break;
            case "-36":
                return CorreiosError::CLIENTE_SEM_CONTR;
                break;
            case "-37":
                return CorreiosError::CLIENT_SERV_N_ATIVO;
                break;
            case "-38":
                return CorreiosError::SERV_INDISPO_ADMIN;
                break;
            case "-39":
                return CorreiosError::PESO_EXCED_ENVELOP;
                break;
            case "-41":
                return CorreiosError::COMP_MAIOR_60;
                break;
            case "-42":
                return CorreiosError::COMP_MENOR_16;
                break;
            case "-43":
                return CorreiosError::COMP_E_LARGURA;
                break;
            case "-44":
                return CorreiosError::LARG_MENOR_11;
                break;
            case "-45":
                return CorreiosError::LARG_MAIOR_60;
                break;
            case "-888":
                return CorreiosError::ERRO_TARIFA;
                break;
            case "-006":
                return CorreiosError::LOCAL_ORIG;
                break;
            case "007":
                return CorreiosError::LOCAL_DEST;
                break;
            case "008":
                return CorreiosError::SERVIC_INDISP;
                break;
            case "009":
                return CorreiosError::CEP_ORIG_RISCO;
                break;
            case "010":
                return CorreiosError::CEP_DEST_TEMP_ENT;
                break;
            case "011":
                return CorreiosError::CEP_DEST_TEMP_AUMENTO;
                break;
            case "99":
                return CorreiosError::ERRO_DOT_NET;
                break;
            default:
                return "Código desconhecido.";
                break;
            
        }
    }
}
