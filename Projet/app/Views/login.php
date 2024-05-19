<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/font-awesome/font-awesome.min.css">
    <title>MIT | Connexion</title>
    <style>
        @font-face {
            font-family: Poppins;
            src: url(/assets/fonts/Poppins-Regular.ttf);
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f1f1f1;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }

        .title {
            color: red;
        }

        .container {
            margin-bottom: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
        }

        .form-fields input {
            width: 95%;
            border-radius: 10px;
            border: 1px solid rgba(128, 124, 124, 0.699);
            padding: 10px;
            margin-bottom: 15px;
            transition: border-color 0.3s ease;
        }

        .link {
            color: #ccc;
        }

        .link:hover {
            color: red;
        }

        .form-fields input:focus {
            outline: none;
            border-color: red;
        }

        .divButton {
            display: flex;
            align-items: center;
        }

        button {
            --color: red;
            font-family: inherit;
            display: inline-block;
            width: 90%;
            height: 2.6em;
            line-height: 2.5em;
            overflow: hidden;
            margin: 20px;
            font-size: 17px;
            z-index: 1;
            color: var(--color);
            border: 2px solid var(--color);
            border-radius: 6px;
            position: relative;
        }

        button::before {
            position: absolute;
            content: "";
            background: var(--color);
            width: 600px;
            height: 800px;
            z-index: -1;
            border-radius: 50%;
        }

        button:hover {
            color: white;
        }

        button:before {
            top: 100%;
            left: 100%;
            transition: .3s all;
        }

        button:hover::before {
            top: -110px;
            left: -110px;
        }

        .form-fields button:hover {
            color: #fff;
        }

        .link {
            position: relative;
            bottom: 0;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .link p {
            margin-bottom: 10px;
            color: #555;
        }

        .link a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link a:hover {
            color: #de0000;
        }

        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .p-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            margin: 15% auto;
            padding: 20px;
            width: 30%;
            position: relative;
            animation: fadeIn 0.5s;
        }

        .p-content p {
            color: #dd1111;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            text-align: center;
        }

        .p-close {
            color: #aaa;
            float: right;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            transition: fadeIn .3s ease;
        }

        label,
        h2,
        h3 {
            color: #ccc;
        }

        .p-close:hover,
        .p-close:focus {
            color: #202124;
            text-decoration: none;
            cursor: pointer;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }


        @media screen and (max-width:900px) {
            .container {
                width: 100vw;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-evenly;
            }

        }

        @media screen and (max-width:768px) {
            .container {
                width: 100vw;
                height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-evenly;
            }

            .left-panel {
                width: 100vw;
                height: 40vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #ffffff84;
            }
        }

        .main {
            display: flex;
            flex-direction: column;
        }
        .loader-container {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        /* .loader {
            position: fixed;
            z-index: 2;
            left: 50%;
            top: 35%;
            width: 45px;
            height: 50px;
            background: linear-gradient(#0000 calc(1*100%/6),#f00 0 calc(3*100%/6),#0000 0),
                      linear-gradient(#0000 calc(2*100%/6),#f00 0 calc(4*100%/6),#0000 0),
                      linear-gradient(#0000 calc(3*100%/6),#f00 0 calc(5*100%/6),#0000 0);
            background-size: 10px 400%;
            background-repeat: no-repeat;
            animation: matrix 1s infinite linear;
        }

        @keyframes matrix {
          0% {
            background-position: 0% 100%, 50% 100%, 100% 100%
          }
      
          100% {
            background-position: 0% 0%, 50% 0%, 100% 0%
          }
        } */
        .loader {
         position: relative;
         width: 2.5em;
         height: 2.5em;
         transform: rotate(165deg);
        }
        
        .loader:before, .loader:after {
         content: "";
         position: absolute;
         top: 50%;
         left: 50%;
         display: block;
         width: 0.5em;
         height: 0.5em;
         border-radius: 0.25em;
         transform: translate(-50%, -50%);
        }
        
        .loader:before {
         animation: before8 2s infinite;
        }
        
        .loader:after {
         animation: after6 2s infinite;
        }
        
        @keyframes before8 {
         0% {
          width: 0.5em;
          box-shadow: 1em -0.5em rgba(225, 20, 98, 0.75), -1em 0.5em rgba(111, 202, 220, 0.75);
         }
     
         35% {
          width: 2.5em;
          box-shadow: 0 -0.5em rgba(225, 20, 98, 0.75), 0 0.5em rgba(111, 202, 220, 0.75);
         }
     
         70% {
          width: 0.5em;
          box-shadow: -1em -0.5em rgba(225, 20, 98, 0.75), 1em 0.5em rgba(111, 202, 220, 0.75);
         }
     
         100% {
          box-shadow: 1em -0.5em rgba(225, 20, 98, 0.75), -1em 0.5em rgba(111, 202, 220, 0.75);
         }
        }
        
        @keyframes after6 {
         0% {
          height: 0.5em;
          box-shadow: 0.5em 1em rgba(61, 184, 143, 0.75), -0.5em -1em rgba(233, 169, 32, 0.75);
         }
     
         35% {
          height: 2.5em;
          box-shadow: 0.5em 0 rgba(61, 184, 143, 0.75), -0.5em 0 rgba(233, 169, 32, 0.75);
         }
     
         70% {
          height: 0.5em;
          box-shadow: 0.5em -1em rgba(61, 184, 143, 0.75), -0.5em 1em rgba(233, 169, 32, 0.75);
         }
     
         100% {
          box-shadow: 0.5em 1em rgba(61, 184, 143, 0.75), -0.5em -1em rgba(233, 169, 32, 0.75);
         }
        }
        
        .loader {
         position: absolute;
         top: calc(50% - 1.25em);
         left: calc(50% - 1.25em);
        }
    </style>
</head>

<body>
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <div class="main">
        <div class="container" id="formContainer" style="display:flex;">
            <h2 class="title">Connexion</h2>
            <form class="form-fields">
                <div class="fields">
                    <label for="username">Nom</label>
                    <input type="text" name="nom" id="username">
                </div>
                <div class="fields">
                    <label for="username">Prénom</label>
                    <input type="text" name="prenom" id="">
                </div>
                <div class="fields">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder='Mot de passe...'>
                </div>
                <div class="divButton">
                    <button type="submit" id="loginButton">Connexion</button>
                </div>
            </form>
            <div class="link">
                <p>Connectez-vous facilement avec votre compte MIT</p>
                <div class="container-link-signup">
                    <a href="/index.php/inscription">
                        <p class="link">Créer un compte</p>
                    </a>
                </div>
            </div>
            <div id="popup" class="popup">
                <div class="p-content">
                    <span class="p-close"><i class="fa fa-times"></i></span>
                    <p class="p-content-text"></p>
                </div>
            </div>
            <button id="qrButton">
                Scanner un QR code
            </button>
        </div>
        <div class="container" id="qrContainer" style="display:none;">
            <div class="section">
                <div id="you-qr-result"></div>
                <h2>Scan de code QR </h2>
                <div style="display: flex; justify-content: center;">
                    <div id="my-qr-reader"></div>
                </div>
                <script>
                    // Vérifier si le DOM est prêt
                    function domReady(fn) {
                        if (document.readyState === "complete" || document.readyState === "interactive") {
                            setTimeout(fn, 1);
                        } else {
                            document.addEventListener("DOMContentLoaded", fn);
                        }
                    }

                    // Attendre le chargement complet du DOM avant d'exécuter le script
                    domReady(function() {
                        var myqr = document.getElementById('you-qr-result');
                        var lastResult, countResults = 0;

                        // Fonction appelée lorsqu'un QR code est détecté avec succès
                        function onScanSuccess(decodeText, decodeResult) {
                            if (decodeText !== lastResult) {
                                ++countResults;
                                lastResult = decodeText;

                                // Affichage du résultat renvoyé par le serveur
                                myqr.innerHTML = `Vous avez scanné ${countResults} QR code(s) : ${decodeText}`;

                                // Redirection vers une autre page après 3 secondes avec les données du QR code dans l'URL
                                // setTimeout(() => {
                                // window.location.href = '/qrconnect?' + decodeText;
                                url = '/qrconnect?' + decodeText;
                                let statusCode = 800;
                                fetch(url).then(resp => {
                                    statusCode = resp.status;
                                    return resp.json();
                                }).then(
                                    data => {
                                        if (statusCode < 400) {
                                            window.location.href = '/Auth';
                                            return;
                                        } else {
                                            console.log(data.status);
                                            p_text.innerText = data.status;
                                            popup.style.display = 'flex';
                                            return;
                                        }
                                    });
                                // }, 3000); // Rediriger après 3 secondes (3000 millisecondes)
                            }
                        }

                        // Initialisation du scanner de QR code
                        var htmlscanner = new Html5QrcodeScanner(
                            "my-qr-reader", {
                                fps: 10,
                                qrbox: 250
                            }
                        );
                        // Lancement du scanner de QR code
                        htmlscanner.render(onScanSuccess);
                    });
                    close.onclick = () => {
                        popup.style.display = 'none';
                    }
                    window.onclick = e => {
                        if (e.target == popup) {
                            popup.style.display = 'none';
                        }
                    }
                </script>
                <button id="formButton">
                    Formulaire normale
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var qrButton = document.getElementById('qrButton');
            var qrContainer = document.getElementById('qrContainer');
            var formContainer = document.getElementById('formContainer');
            var formButton = document.getElementById('formButton');

            formButton.addEventListener('click', function() {
                formContainer.style.display = 'flex';
                qrContainer.style.display = 'none';
            });

            qrButton.addEventListener('click', function() {
                qrContainer.style.display = 'flex';
                formContainer.style.display = 'none';
            });
        });
    </script>
    <script src="<?php echo base_url('js/main.js'); ?>"></script>
    <script src="<?= base_url('js/qr.js'); ?>"></script>
</body>

</html>
