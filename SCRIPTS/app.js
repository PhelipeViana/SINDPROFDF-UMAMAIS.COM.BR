  var firebaseConfig = {
    apiKey: "AIzaSyCVuwyvgT2NnZTmuxGfN7u46Y-dEzIcDjU",
    authDomain: "projeto-whatsapp-um-a-mais.firebaseapp.com",
    databaseURL: "https://projeto-whatsapp-um-a-mais-default-rtdb.firebaseio.com",
    projectId: "projeto-whatsapp-um-a-mais",
    storageBucket: "projeto-whatsapp-um-a-mais.appspot.com",
    messagingSenderId: "207586581585",
    appId: "1:207586581585:web:ca1a93659a1ebbbbd46c70",
    measurementId: "G-GN9MCY4S8D"
  };

  firebase.initializeApp(firebaseConfig);
  firebase.analytics();

  /*
  MULTIATENDENTES
                  
  */

  const fireFunction = {
 
    anonimoLogin: function () {
      firebase.auth().signInAnonymously().catch(function (error) {
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage);

      });

    },
    statusLogin: function () {

      firebase.auth().onAuthStateChanged(function (user) {
        if (user) {
          var isAnonymous = user.isAnonymous; //true
          var uid = user.uid; //chava
          let corpo_on=`<span class="indicator label-success"></span>Online`
          let corpo_off=`<span class="indicator label-danger"></span>Offline`
          
          //console.log(uid);
         // console.log('logado: '+uid)
          $("#status_firebase").html(corpo_on)
        } else {
          fireFunction.anonimoLogin();
          $("#status_firebase").html(corpo_off)
        }

      });
    },
    arquivo: function (files, barra, form_input, destino, btn = 0) {
      let file1 = document.getElementById(files);
      let progre1 = document.getElementById(barra);
      let campo_input = document.getElementById(form_input);

      file1.onchange = function (e) {

        let caminho;
        let enviando;
        let file1;
        let carregar;

        let a = Math.floor(Math.random() * 999 + 1);
        let b = Math.floor(Math.random() * 999 + 1);


        let rp = a + "_" + b;

        file1 = e.target.files[0];
        let tipo_nome = file1.name;
        let posicao = tipo_nome.lastIndexOf(".");
        let ext = tipo_nome.substring(posicao);

        let PERMITIDO = ['.png', '.jpg', '.jpeg', '.pdf'];
        let validador = PERMITIDO.indexOf(ext);

        if (validador > -1) {
          caminho = firebase.storage().ref(destino + "/").child(rp + tipo_nome);
          enviando = caminho.put(file1);

          enviando.on('state_changed', function (data) {
            carregar = (data.bytesTransferred / data.totalBytes) * 100;
            progre1.value = carregar;
            caminho.getDownloadURL().then(function (url) {

              campo_input.value = url;
              // console.log(url)
            });
            if (carregar == 100) {
              alert('Documento anexado!');

              if (btn !== 0) {
                $("#" + btn).prop('disabled', false);

              }

            }

          })

        } else {
          alert('Formato não permitido!');
          file1.value = "";
        }
      }
    }
  }
  // fireFunction.anonimoLogin();

fireFunction.statusLogin();