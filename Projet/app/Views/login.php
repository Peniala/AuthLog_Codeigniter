<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIT | Connexion</title>
    <style>
        @font-face {
            font-family: Poppins;
            src: url(/authentification/assets/fonts/Poppins-Regular.ttf);
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
            color:red;
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
            color:#ccc;
        }
        .link:hover{
            color:red;
        }
        
        .form-fields input:focus {
            outline: none;
            border-color: red;
        }
        
        .divButton {
            display: flex;
            align-items: center;
        }
        
        .form-fields button {
            width: 95%;
            background-color: #FF3131;
            color: #000;
            /* margin: auto; */
            border: none;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button {
            margin-top:5px;
            width: 95%;
            background-color: #ccc;
            color: #000;
            /* margin: auto; */
            border: none;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        button:hover {
            background-color: #202124;
            color: #fff;
        }
        
        .form-fields button:hover {
            background-color: #202124;
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
        
        
 
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        
        @media screen and (max-width:900px) {
            .container{
                width: 100vw;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-evenly;
            }
        
        }
        
        @media screen and (max-width:768px) {
            .container{
                width: 100vw;
                height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-evenly;
            }
            .left-panel{
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

    </style>
</head>
<body>
    <div class="main">
        <div class="container" id="formContainer" style="display:flex;">
                        <h2 class="title">Connexion</h2>
                        <form class="form-fields">
                            <div class="fields">
                                <label for="username">Nom</label>
                                <input type="text" name="nom" id="username" >
                            </div>
                            <div class="fields">
                                <label for="username">Prénom</label>
                                <input type="text" name="prenom" id="" >
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
                            <a href="/index.php/inscription" >
                                <p class="link">Créer un compte</p>
                            </a>
                        </div>
                    </div>
            <div id="popup" class="popup">
                <div class="p-content">
                    <span class="p-close"><i class="fas fa-times"></i></span>
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
                domReady(function () {
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
                        setTimeout(() => {
                        // window.location.href = '/qrconnect?' + decodeText;
                        url = '/qrconnect?' + decodeText;
                        fetch(url).then(resp => {
                            if (resp.status < 400) {
                            window.location.href = '/accueil';
                            }
                        }) 
                        }, 3000); // Rediriger après 3 secondes (3000 millisecondes)
                    }
                }

                // Initialisation du scanner de QR code
                var htmlscanner = new Html5QrcodeScanner(
                    "my-qr-reader", { fps: 10, qrbox: 250 }
                );
                // Lancement du scanner de QR code
                htmlscanner.render(onScanSuccess);
                });
                </script>
            <button id="formButton">
                Formulaire normale
            </button>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/main.js'); ?>"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
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
</body>
</html>
