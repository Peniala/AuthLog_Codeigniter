<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
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

    .link button {
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
    .link button:hover {
            background-color: #202124;
            color: #fff;
    }
  </style>
  <title>Accueil test</title>
</head>
<body>
  
</body>
</html>
<html>
  <body>
    <div class="container">
        OK Connecter 
        <?php 
        if($data['statut'] == 1){
          echo "MR" . $data['nom'];
        } else {
          echo "Mpianatra" . $data['prenom'];
        }
        ?>
        <a href='/deconnexion' class="link"> 
          <button>
          deconnexion 
          </button>  
        </a>
    </div>
  <body>
</html>
