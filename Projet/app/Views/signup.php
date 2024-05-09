<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MIT | Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
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


        .signup {
            text-align: center;
        }

        .signup h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .input {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input input {
            width: 300px;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 12px;
            transition: border-color 0.3s ease;
        }

        .input input:focus {
            outline: none;
            border-color: #ff1111;
        }

        .button button {
            width: 300px;
            background-color: #ff1111;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button button:hover {
            background-color: #dd1111;
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
            color: #de1111;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="signup">
                <div class="clip-out"></div>
                <h3>Cr&eacute;ation de compte</h3>
                <form id="signup">
                    <div class="input">
                        <input type="text" name="nom" placeholder='Nom...' required autocomplete='off'>
                        <input type="text" name="prenom" placeholder='Pr&eacute;nom...' required autocomplete='off'>
                        <input type="password" name="password" placeholder='Mot de passe...' required autocomplete='off'>
                        <div style="display: flex;flex-direction:column;">
                            <input type="password" name="passwd" placeholder='Confirmation mot de passe...' required autocomplete='off'>
                            <p class="match-content" style="display: none;color:red">Ne correspondent pas</p>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" id="signupButton">Cr&eacute;er</button>
                    </div>
                </form>
            </div>
            <div class="link">
                <p>Connectez-vous avec votre compte MIT</p>
                <a href="/connexion">Connexion</a>
            </div>
            <div id="popup" class="popup">
                <div class="p-content">
                    <span class="p-close"><i class="fas fa-times"></i></span>
                    <p class="p-content-text"></p>
                </div>
            </div>
        </div>
    <script src="<?php echo base_url('js/signup.js'); ?>"></script>
    </body>
</html>
