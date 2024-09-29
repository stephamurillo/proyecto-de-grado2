<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicio</title>

   <!-- Enlace CDN de Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Enlace del archivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<style>
    img {
      max-width: 100%;
      height: auto;
    }
  </style>
<!-- sección de selección rápida empieza  -->
<img src="./images/fondop.png" width="100%" height="10%" alt="">
<section class="quick-select">

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?> 
      <div class="box"> 
         <h3 class="title">Me gusta y comentarios</h3>
         <p>Total de me gusta: <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">Ver me gusta</a>
         <p>Total de comentarios: <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">Ver comentarios</a>
         <p>Playlist guardadas: <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">Ver marcadores</a>
      </div>
      <?php
         }else{ 
      ?>
      <div class="box" style="text-align: center;">
         <h3 class="title">Por favor, inicia sesión o regístrate</h3>
         <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">Iniciar sesión</a>
            <a href="register.php" class="option-btn">Regis<br>trate</a>
         </div>
      </div>
      <?php
      }
      ?>

      <div class="box">
         <h3 class="title">Categorías principales</h3>
         <div class="flex">
            <a href="search_course.php?"><i class="fas fa-code"></i><span>psicologos</span></a>
            <a href="#"><i class="fas fa-chart-simple"></i><span>Recomendaciones</span></a>
            <a href="#"><i class="fas fa-pen"></i><span>Foro</span></a>
            <a href="#"><i class="fas fa-chart-line"></i><span>Test</span></a>
       
         </div>
      </div>

      <div class="box">
         <h3 class="title">Temas populares</h3>
         <div class="flex">
            <a href="#"><span>Ayuda</span></a>
            <a href="#"><span>Ansiedad</span></a>
            <a href="#"><span>Depresión</span></a>
            <a href="#"><span>psicologos</span></a>
            <a href="#"><span>Foros</span></a>
            <a href="#"><span>Test</span></a>
         </div>
      </div>

      <div class="box tutor">
         <h3 class="title">Ingresa como psicologo</h3>
         <p>Da el siguiente paso en tu carrera y ayuda a mejorar el bienestar mental de muchos</p>
         <a href="admin/register.php" class="inline-btn">Empezar</a>
      </div>

   </div>

</section>

<!-- sección de selección rápida termina -->

<!-- sección de cursos empieza  -->

<section class="teachers">

   <h1 class="heading">Psicólogos</h1>
 <br><br><br><br><br><br><br><br><br><br><br><br>
   <form action="search_tutor.php" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="buscar psicólogo..." required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <div class="box offer">
         <h3>Conviértete en un psicólogo</h3>
         <p>Da el siguiente paso en tu carrera y ayuda a mejorar el bienestar mental de muchos</p>
         <a href="admin/register.php" class="inline-btn">Comienza ahora</a>
      </div>

      <?php
         $select_tutors = $conn->prepare("SELECT * FROM `tutors`");
         $select_tutors->execute();
         if($select_tutors->rowCount() > 0){
            while($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)){

               $tutor_id = $fetch_tutor['id'];

               $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
               $count_playlists->execute([$tutor_id]);
               $total_playlists = $count_playlists->rowCount();

               $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
               $count_contents->execute([$tutor_id]);
               $total_contents = $count_contents->rowCount();

               $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
               $count_likes->execute([$tutor_id]);
               $total_likes = $count_likes->rowCount();

               $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
               $count_comments->execute([$tutor_id]);
               $total_comments = $count_comments->rowCount();
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
            <h2 style="color: #e272e6;;"><?= $fetch_tutor['name']; ?></h2>
 
            </div>
         </div>

         <p>Total de videos: <span><?= $total_contents ?></span></p>
         <p>Total de "Me gusta": <span><?= $total_likes ?></span></p>
         <p>Total de comentarios: <span><?= $total_comments ?></span></p>
         <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" value="Ver perfil" name="tutor_fetch" class="inline-btn">
         </form>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">¡No se encontraron psicólogos!</p>';
         }
      ?>

   </div>

</section>

<div style="background-color: #c281ed; width:100%;height: 0%;border-radius: 10%;">
      <section class="slider-container">
        <div class="slider-images">
          <div class="slider-img">
            <img src="Images/1.jpeg" alt="1" />
            <h1>Mike lina</h1>
            <div class="details">
              <h2>Mike y lina</h2>
              <p>Claro, aquí está el texto reducido:

                *"Gracias a las sesiones virtuales y recursos de Psyware, pudimos trabajar en
                nuestras diferencias sin salir de casa. Los ejercicios de comunicación y las
                recomendaciones fueron clave para reconectar y sentirnos comprendidos."*</p>
            </div>
          </div>
          <div class="slider-img">
            <img src="Images/2.webp" alt="2" />
            <h1>Marta</h1>
            <div class="details">
              <h2>Marta</h2>
              <p>"A los 50 años, la depresión me estaba afectando profundamente. Psyware me ofreció un test y conexión
                con
                un terapeuta que entendió mi situación. Las sesiones y recursos online me ayudaron a gestionar mis
                emociones y a sentirme más esperanzada. Estoy agradecida por el apoyo que encontré en Psyware."</p>
            </div>
          </div>
          <div class="slider-img">
            <img src="Images/3.webp" alt="3" />
            <h1> Cardenas</h1>
            <div class="details">
              <h2>Familia Cardenas</h2>
              <p>"Psyware nos conectó con especialistas que ayudaron a nuestro hijo con disforia corporal. Los recursos
                y
                apoyo online fueron esenciales para entender y manejar la situación. Agradecemos profundamente la ayuda
                recibida."</p>
            </div>
          </div>
          <div class="slider-img active">
            <img src="Images/4.webp" alt="4" />
            <h1>kaity</h1>
            <div class="details">
              <h2>Kate </h2>
              <p>"A mis 25 años, la ansiedad social me estaba limitando. Psyware me ofreció herramientas y apoyo en
                línea
                que me ayudaron a enfrentar mis miedos. Gracias a los recursos y la terapia, me siento más segura y
                capaz
                en situaciones sociales. Estoy muy agradecida por la ayuda que recibí."



              </p>
            </div>
          </div>
          <div class="slider-img">
            <img src="Images/5.png" alt="5" />
            <h1>lauren</h1>
            <div class="details">
              <h2>lauren</h2>
              <p>"A los 36 años, la agresividad me estaba afectando seriamente. Psyware me proporcionó recursos y
                terapia
                en línea que fueron cruciales para entender y controlar mis emociones. Gracias a su apoyo, ahora manejo
                mejor mi agresividad y me siento más en paz."</p>
            </div>
          </div>
          <div class="slider-img">
            <img src="Images/6.png" alt="6" />
            <h1>ryan</h1>
            <div class="details">
              <h2>ryan</h2>
              <p>"A mis 20 años, enfrentaba problemas psicológicos que me afectaban mucho. Psyware me brindó acceso a
                apoyo y recursos en línea que me ayudaron a comprender y manejar mi situación. Gracias a su ayuda, me
                siento más equilibrada y en camino hacia una mejor salud mental."</p>
            </div>
          </div>
          <div class="slider-img">
            <img src="Images/7.png" alt="6" />
            <h1>Beatriz</h1>
            <div class="details">
              <h2>Beatriz</h2>
              <p>"A mis 30 años, enfrentaba problemas psicológicos que afectaban mi vida cotidiana. Psyware me brindó el
                apoyo y las herramientas necesarias para comprender y manejar mi situación. Gracias a su ayuda, me
                siento más equilibrada y en control de mi vida."</p>
            </div>
          </div>
        </div>
    </div>
    </section>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <script src="js/jQuery.js"></script>
    <script>
      jQuery(document).ready(function ($) {
        $(".slider-img").on("click", function () {
          $(".slider-img").removeClass("active");
          $(this).addClass("active");
        });
      });
    </script>
    <style>
  
    /* Contenedor flexible para alinear el contenido */
   
 
  </style>
  <title>Optimización de Espaciado</title>
</head>
<body>



  <div class="content flex">
    <div class="container1">
      <div class="row">
        <!-- Sección de Redes Sociales -->
        <footer class="footer">
          <div class="box-container">
            <div class="box">
              <h3>Sobre nosotros</h3>
              <p>En Psyware nos dedicamos a brindar apoyo psicológico accesible y de calidad a través de nuestra plataforma en línea, conectando a los usuarios con los profesionales adecuados según sus necesidades.</p>
            </div>
            <div class="box">
              <h3>Enlaces rápidos</h3>
              <a href="home.php">Inicio</a>
              <a href="about.php">Sobre nosotros</a>
              <a href="courses.php">Cursos</a>
              <a href="contact.php">Contacto</a>
            </div>
            <div class="box">
              <h3>Contacto</h3>
              <p><i class="fas fa-map-marker-alt"></i> Ciudad, País</p>
              <p><i class="fas fa-phone"></i> +123 456 789</p>
              <p><i class="fas fa-envelope"></i> info@psyware.com</p>
            </div>
            <div class="box">
              <h3>Síguenos</h3>
              <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
              <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
              <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
              <a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a>
            </div>
          </div>

          <div class="credit">© 2024 <span>Psyware</span> | Todos los derechos reservados.</div>
        </footer>
      </div>
    </div>
  </div>
</div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
      const menuIcon = document.getElementById('menuIcon');
      const sideMenu = document.getElementById('sideMenu');
      const overlay = document.getElementById('overlay');

      menuIcon.addEventListener('click', () => {
        sideMenu.classList.toggle('active');
        overlay.classList.toggle('active');
      });

      overlay.addEventListener('click', () => {
        sideMenu.classList.remove('active');
        overlay.classList.remove('active');
      });
    </script>
  </body>
<!-- sección de cursos termina -->

<!-- sección del pie de página empieza  -->
<?php include 'components/footer.php'; ?>
<!-- sección del pie de página termina -->

<!-- enlace del archivo JS personalizado -->
<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="./js/scrípt1.js"></script>
</body>
</html>
