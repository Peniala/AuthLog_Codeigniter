<!DOCTYPE html>
<html lang="en">

<head>
    <title>MIT | Sign Up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/font-awesome/font-awesome.min.css">
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
        }  background-color: #ff0000;

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
        /* OLD LOADER */
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
                <span class="p-close"><i class="fa fa-times"></i></span>
                <p class="p-content-text"></p>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('js/signup.js'); ?>"></script>
</body>

</html>
