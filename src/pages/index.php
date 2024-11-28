<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    $_SESSION['message'] = "<div id='alert_message'></div>";        
} else {
    $_SESSION['message'] = "<div id='alert_message'></div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club félin baie des anges</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="preload" href="PaintingWithChocolate.woff2" as="font" type="font/woff2" crossorigin>
    <script src="../JS/main.js" defer></script>
</head>
<body>
<div class="topnav" id="myTopnav">
    <a href="#home" class="active">Accueil</a>
    <div class="user-info">
        <?php
        if (isset($_SESSION["user"])) {
            // Affichage du message de bienvenue avec le nom et prénom de l'utilisateur
            echo "<span>Bienvenue, " . htmlspecialchars($_SESSION["user"]["name"]) . " " . htmlspecialchars($_SESSION["user"]["surname"]) . "</span>";
            
            // Ajouter le lien pour modifier le profil
            echo ' <a href="profile.php">Modifier mon profil</a>';
            //Ajout d'un lien de gestion des chats
            echo ' <a href="cats.php">Gestion des chats</a>';
            // Vérifier si l'utilisateur a le rôle 'admin' et afficher le lien vers le Back Office
            if (isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === 'admin') {
                echo ' <a href="backoffice.php">Back Office</a>';
            }

            // Afficher le lien de déconnexion
            echo ' <a href="logout.php">Se déconnecter</a>';
        } else {
            echo '<a href="login.php">Connexion</a> <a href="inscription.php">Inscription</a>';
        }
        ?>
            <a href="#contact">Contact</a>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>

    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
    <header class="header">
        <div class="header-container">
            <img src="../img/bengal.png" alt="Chat Bengal" class="header-image">
            <div class="header-content">
                <h1>Cercle félin baie des anges</h1>
            </div>
        </div>
    </header>

    <section class="news-section">
        <div class="container">
            <img src="../img/chaton.jpg" alt="Chaton roux" class="image">
            <div class="text-content"><h1>Expositions à venir</h1>
                <h2>Spéciale chatons</h2>
                <p class="paragraph">Plongez dans une exposition féline dédiée aux petites boules de poils : races variées, conseils d’experts, et moments câlins inoubliables. Un rendez-vous incontournable pour tous les amoureux des chats ! 🐾
                    Rendez-vous le 18 & 19 Janvier à l'espace Chiris de Grasse.
                </p>
                <button>
                    <a href="#">Bulletin d'engagement</a>
                </button>
            </div>
        </div>
    </section>

    <section class="gallery-section"><h1>Expositions passées</h1>
        <div class="gallery-container">
          <img src="../img/img1.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img2.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img3.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img1.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img2.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img2.jpg" alt="Image d'illustration" class="gallery-image">
          <img src="../img/img2.jpg" alt="Image d'illustration" class="gallery-image">
        </div>
      </section>
      

      <section class="section-about"><h1>Notre équipe</h1>
        <div class="container-about">
            <div class="about-item">
                <img src="../img/chat1.jpg" alt="Image d'illustration Nicole & son chat" class="about-image">
                <h3>Mme Nicole Chaniel & nom du chat</h3><br>
                <p class="about-text">
                Présidente du club</p>
            </div>
            <div class="about-item">
                <img src="../img/chat2.jpg" alt="Image d'illustration Karine & son chat" class="about-image">
                <h3>Mme Karine Riahi & nom du chat</h3><br>
                <p class="about-text">
                    Secrétaire générale du club</p>
            </div>
            <div class="about-item">
                <img src="../img/chat3.jpg" alt="Image d'illustration Michel & son chat" class="about-image">
                <h3>Mr Michel Pons & nom du chat</h3><br>
                <p class="about-text">
                    Trésorier</p>
            </div>
            <div class="about-item">
                <img src="../img/mitaine.jpg" alt="Image d'illustration Mathilde & Mitaine" class="about-image">
                <h3>Mlle Mathilde Jourden & Mitaine</h3><br>
                <p class="about-text">
                    Développeuse web et assesseuse occasionnelle</p></p>
            </div>
        </div> 
    </section>
    


    

    <section class="contact-section">
        <div class="container-contact">
            <!-- Contact Form -->
            <div class="form-content">
                <h2>Contactez-nous</h2>
                <form action="#" method="POST" class="contact-form">
                    <label for="first-name">Prénom</label>
                    <input type="text" id="first-name" name="first-name" required>
    
                    <label for="last-name">Nom</label>
                    <input type="text" id="last-name" name="last-name" required>
    
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
    
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
    
                    <button type="submit">Envoyer</button>
                </form>
            </div>
    
            <!-- Contact Image -->
            <div class="contact-image">
                <img src="../img/img2.jpg" alt="Contact Image" class="image">
            </div>
        </div>
    </section>

    <section class="history-section">
        <div class="container">
          <div class="text-content"><h1>A propos du club</h1>
            <p class="paragraph">Eius populus ab incunabulis primis ad usque pueritiae tempus extremum, quod annis circumcluditur fere trecentis, circummurana pertulit bella, deinde aetatem ingressus adultam post multiplices bellorum aerumnas Alpes transcendit et fretum, in iuvenem erectus et virum ex omni plaga quam orbis ambit inmensus, reportavit laureas et triumphos, iamque vergens in senium et nomine solo aliquotiens vincens ad tranquilliora vitae discessit.</p>  
            <button>
                <a href="#">Adhérer au club</a>
            </button>
        </div>
        </div>
      </section>

      <section class="partenaires-section">
        <h2>Nos partenaires</h2>
        <div class="partenaires">
            <a href="https://www.royalcanin.com/fr" target="_blank" class="partenaire-link">
                <img src="../img/royalcanin.png" alt="Logo de royal canin" class="partenaire-image">
            </a>
            <a href="https://loof.asso.fr" target="_blank" class="partenaire-link">
                <img src="../img/loof.png" alt="Logo du loof" class="partenaire-image">
            </a>
        </div>
    </section>
    <?php
      
    include 'footer.php';?>
    


      

</body>
</html> 

