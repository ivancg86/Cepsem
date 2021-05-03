if (document.getElementById("myVideo") === undefined) {

    var vid = document.getElementById("myVideo");
    var pregunta = document.getElementById("pregunta");
    var label1 = document.getElementById("label1");
    var label2 = document.getElementById("label2");
    var label3 = document.getElementById("label3");
    var enunciat = document.getElementById("enunciat");
    var opcio1 = document.getElementById("opcio1");
    var opcio2 = document.getElementById("opcio2");
    var opcio3 = document.getElementById("opcio3");
    var presentacio = document.getElementById("presentacio");
    var btnValidar = document.getElementById("btnValidar");
    var final = document.getElementById("final");
    vid.ontimeupdate= function() {preguntas()};
    var contador = 0;
    var temps =0;
    var validar = false;

    function endavant()
    {
        vid.play();
        presentacio.style.display="none";

    }

    function preguntas() {

      if(Math.floor(vid.currentTime)==33  && contador==0)
      {

        vid.pause();
        pregunta.style.display = "block";
        contador++;


      }
      else if(Math.floor(vid.currentTime)==48  && contador==1)
      {
        vid.pause();
        pregunta.style.display = "block";
        enunciat.innerHTML="Pregunta 2: Quantes compressions toràciques se li ha d'aplicar al pacient quan es te el primer contacte? ";
        label1.innerHTML = "60 a ritme de 100/minut";
        label2.innerHTML = "100 a ritme de 60/minut";
        label3.innerHTML = "30 a ritme de 100/minut";
        contador++;

      }
      else if(Math.floor(vid.currentTime)==60  && contador==2)
      {
        vid.pause();
        pregunta.style.display = "block";
        enunciat.innerHTML="Pregunta 3: Després de fer les primeres compressions i abans d'aplicar el DESA hem de fer...";
        label1.innerHTML = "2 ventilacions i 30 compressions";
        label2.innerHTML = "4 ventilacions i 45 compressions";
        label3.innerHTML = "3 ventilacions i 30 compressions";
        contador++;
      }
      else if(Math.floor(vid.currentTime)==100 && contador==3)
      {
        vid.pause();
        pregunta.style.display = "block";
        enunciat.innerHTML="Pregunta 4: Una vegada aplicat el DESA, quan anem a fer la descarrega, és molt important...";
        label1.innerHTML = "Tocar al pacient per comprovar si te pols";
        label2.innerHTML = "No tocar al pacient";
        label3.innerHTML = "Fer el massatge cardiovascular mentres s'aplica la descarrega";
        contador++;
      }
      else if(Math.floor(vid.currentTime)==180  && contador==4)
      {
        vid.pause();
        pregunta.style.display = "block";
        enunciat.innerHTML="Pregunta 5: Si la primera descarrega no reanima al pacient, que hem de fer?";
        label1.innerHTML = "Aplicar un altre descarrega inmediatament";
        label2.innerHTML = "60 compressions a ritme de 100/minut i aplicar un altre descarrega";
        label3.innerHTML = "30 compressions i 2 ventilacions 3 vegades abans d'aplicar un altre decarrega";
        contador++;
      }else if(Math.floor(vid.currentTime)==220)
      {
          vid.pause();
          final.style.display = "block";

      }
    }

    function validarPregunta()
    {
        var validar = false;

        if(Math.floor(vid.currentTime)==33)
        {
            if(opcio1.checked)
            {
                pregunta.style.backgroundColor = "lightgreen";
                validar=true;
                btnValidar.style.backgroundColor = "#00c853";
                btnValidar.innerHTML = "Correcte!";
            }
            else
            {
                pregunta.style.backgroundColor = "lightcoral";
                btnValidar.style.backgroundColor = "#ff2e2e";
                btnValidar.innerHTML = "Error!"
                validar = false;
                contador--;
                temps = 10;


            }

        }

        else if(Math.trunc(vid.currentTime)==48)
        {
            if(opcio3.checked)
            {
                btnValidar.style.backgroundColor = "#17B60A";
                btnValidar.innerHTML = "Correcte!";
                pregunta.style.backgroundColor = "lightgreen";
                validar = true;
            }else
            {
                btnValidar.style.backgroundColor = "#ff2e2e";
                btnValidar.innerHTML = "Error!"
                pregunta.style.backgroundColor = "lightcoral";
                contador--;
                validar = false;
                temps = 33;

            }
        }
        else if(Math.trunc(vid.currentTime)==60)
        {
            if(opcio1.checked)
            {
                btnValidar.style.backgroundColor = "#17B60A";
                btnValidar.innerHTML = "Correcte!";
                pregunta.style.backgroundColor = "lightgreen";
                validar = true;
            }else
            {
                btnValidar.style.backgroundColor = "#ff2e2e";
                btnValidar.innerHTML = "Error!"
                pregunta.style.backgroundColor = "lightcoral";
                contador--;
                validar = false;
                temps = 49;
            }
        }
        else if(Math.trunc(vid.currentTime)==100)
        {
            if(opcio2.checked)
            {
                btnValidar.style.backgroundColor = "#17B60A";
                btnValidar.innerHTML = "Correcte!";
                pregunta.style.backgroundColor = "lightgreen";
                validar = true;
            }else
            {
                btnValidar.style.backgroundColor = "#ff2e2e";
                btnValidar.innerHTML = "Error!"
                pregunta.style.backgroundColor = "lightcoral";
                contador--;
                validar = false;
                temps = 61;
            }
        }
        else if(Math.trunc(vid.currentTime)==180)
        {
            if(opcio3.checked)
            {
                btnValidar.style.backgroundColor = "#17B60A";
                btnValidar.innerHTML = "Correcte!";
                pregunta.style.backgroundColor = "lightgreen";
                validar = true;
            }else
            {
                btnValidar.style.backgroundColor = "#ff2e2e";
                btnValidar.innerHTML = "Error!"
                contador--;
                validar = false;
                temps = 101;
            }
        }
        return validar;
    }

    function reanudar()
    {

        if(validarPregunta())
        {
            CorrectePregunta();
        }
        else
        {
            ErrorPregunta();
        }
    }

        function ErrorPregunta() {
            setTimeout(function(){
                btnValidar.style.backgroundColor = "#D91480";
                btnValidar.innerHTML = "Validar";
                pregunta.style.display="none";
                pregunta.style.backgroundColor = "white";
                vid.currentTime = temps;
                vid.play();
                opcio1.checked = false;
                opcio2.checked = false;
                opcio3.checked = false;

            }, 3000);
          }

          function CorrectePregunta(){

            setTimeout(function(){
                    btnValidar.style.backgroundColor = "#D91480";
                    btnValidar.innerHTML = "Validar";
                    vid.play();
                    pregunta.style.display="none";
                    pregunta.style.backgroundColor = "white";
                    opcio1.checked = false;
                    opcio2.checked = false;
                    opcio3.checked = false;

            }, 3000);

          }
}
