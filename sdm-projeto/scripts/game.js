document.addEventListener("DOMContentLoaded", function () {
    var telaDenuncia = document.querySelector(".telaDenuncia");//tela de denuncia
    var telaSaida = document.querySelector(".tela_saida"); // tela de saida
    var telaPont = document.querySelector(".telapontuacao");//tela de pontuacao
    var telaperdeu = document.querySelector(".telaconfirmacaosaida");//tela de confirmação de saida
    var telacerteza = document.querySelector(".tela-temcerteza");//tela de certza de saida
    var teladenunciado = document.querySelector(".telasucesso");//tela de denuncia realizada
    var telaajuda = document.querySelector(".telaajuda");

    var fecharBtns = document.querySelectorAll(".fechar-btn"); //funcao pra fechar telas
    var principal = document.querySelector(".principal"); //tela principal

    var abrirdenuncia = document.querySelector(".btn-denuncia");//botão de denuncia
    var sairBtn = document.querySelector(".btn-saida"); //botao de saida
    var abrirPont = document.querySelector(".btn-pontuacao"); //botao de pontuacao
    var incerteza = document.querySelector(".incerteza-btn");//botao da incerteza
    var denunciado = document.querySelector(".denunciado");//botao de sim na denuncia
    var desistencia = document.querySelector(".desistencia-btn"); //botao de sim na tela de sair
    var dica = document.querySelector(".ajuda")



    abrirdenuncia.addEventListener("click", function () {
      telaDenuncia.classList.add("active"); //exibe a tela de denuncia
      principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
    });

    sairBtn.addEventListener("click", function () {
      telaSaida.classList.add("active"); // Exibe a tela de saída
      principal.style.filter = "blur(5px)"; // Aplica o desfoque ao fundo
    });

    abrirPont.addEventListener("click", function () {
      telaPont.classList.add("active");//exibe a tela de saída
      principal.style.filter = "blur(5px)";//Aplica o desfoque ao fundo
    });

    incerteza.addEventListener("click", function () {
      telacerteza.classList.add("active");//exibe a tela de incerteza
      telaSaida.classList.remove("active"); // Esconde a tela de saída
    })

    desistencia.addEventListener("click", function () {
      telaperdeu.classList.add("active");//exibe tela de desistencia
      telacerteza.classList.remove("active");
      principal.style.filter = "blur(5px)";//Aplica o desfoque ao fundo
    })

    denunciado.addEventListener("click", function () {
      teladenunciado.classList.add("active");//exibe tela de denuncia realizada
      telaDenuncia.classList.remove("active");
    })
    /*
      A função abaixo é para quando clicar na tela, ela fechar
    */
    teladenunciado.addEventListener("click", function () {
      principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
      teladenunciado.classList.remove("active")
    })

    dica.addEventListener("click", function(){
      telaajuda.classList.add("active");
      principal.style.filter = "blur(5px)";
    });


    fecharBtns.forEach(function (btn) { //função para que todos os btn-fechar fechem os conteudos
      btn.addEventListener("click", function () {
        principal.style.filter = "blur(0)"; // Remove o desfoque do fundo
        telaDenuncia.classList.remove("active"); //esconde a tela de denuncia
        telaSaida.classList.remove("active"); // Esconde a tela de saída
        telaPont.classList.remove("active"); // esconde a tela de pontuação
        telacerteza.classList.remove("active");//esconde a tela de incerteza
        telaajuda.classList.remove("active");
      });
    });


  });
