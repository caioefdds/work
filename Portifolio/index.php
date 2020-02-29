<!DOCTYPE html>
<html>
<head>
	<title> Caio Fagundes </title>
</head>
<?php include 'header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<body>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-md navbar-dark azul-escuro">
  <a class="navbar-brand titulo" href="#">PORTIFOLIO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link vertical-spacer text-light" href="#projects"><i class="fas fa-code mx-1"></i> My Projects</a>
      </li>
      <li class="nav-item">
        <a class="nav-link vertical-spacer text-light" href="#about"><i class="fas fa-pencil-alt mx-1"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link vertical-spacer text-light" href="#contact"><i class="fas fa-address-card mx-1"></i> Contact</a>
      </li>    
    </ul>
  </div>  
</nav>

<!-- FIRST CARD -->
<div class="container-fluid bg-dark horizontal-padding-b">
  <div class="container">
    <center>
      <span class="titulo-h1-d">Full Stack Developer</span><br>
      <p class="lead text-light pb-5">Eu amo codificar e aplicar minhas ideias no desenvolvimento de softwares.<br>
                                 Me sinto incrivelmente bem, vendo todas linhas de código ao final do programa!</p>
      <img src="img/caio.png" class="img-fluid img-rounded mb-5" width="300px"> 
    </center>   
  </div>
</div>

<!-- PRESENTATION SECTION -->
<div class="container-fluid bg-indigo py-5">
  <div class="container py-5 mb-5">
    <center>
      <h1 class="display-5 mb-5 text-light">Olá! Meu nome é Caio Fagundes</h1>
      <p class="lead font-weight-normal text-light">
        Desde o começo da minha jornada como desenvolvedor, sempre fui apaixonado por estudar a tecnologia, procurava sempre como me aprofundar ainda mais nessa área. Então, aos meus 16 anos, realizei um curso de informática para internet, onde tive os primeiros contatos com as linguagens de programação.<br>
         A partir desse ponto, cada dia mais, fui adquirindo conhecimento e interesse no desenvolvimento. Iniciei a faculdade de Análise e Desenvolvimento de Sistemas, estou atuando na área de Programação WEB, tanto no escritório da minha empresa quanto em Home Offices
      </p>
    </center>
  </div>
</div>

<!-- CARDS -->
<div class="container-fluid">
  <div class="container-fluid row inside-up mx-auto">

      <div class="col-sm-12 col-md-6 col-lg-6 no-borders">
        <div class="card text-dark bg-light" style="width: 100%;">
          <div class="card-header text-center"><h2>Developer</h2></div>
          <div class="card-body text-dark"><br>
            <center><i class="fas fa-code icone text-indigo"></i></center><br>
            <p class="lead text-center">O essencial para um bom desenvolvimento é a organização e um código auto-explicativo</p><br>
            <h5 class="text-center text-indigo">Linguagens de programação:</h5>
            <p class="lead text-center">HTML, JavaScript, PHP, SQL, CSS, Bootstrap, AJAX e Jquery</p><br>
            <h5 class="text-center text-indigo">DEVTools:</h5>
            <p class="lead text-center">
              VIM <br>
              Sublime Text 3 <br>
              MySQL Workbench <br>
              GitHUB <br>
              Bootstrap <br>
              Terminal <br>
            </p><br>
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-6 no-borders">
        <div class="card text-dark bg-light" style="width: 100%;">
          <div class="card-header text-center"><h2>Designer</h2></div>
          <div class="card-body text-dark"><br>
            <center><i class="fas fa-pen-nib icone text-indigo"></i></center><br>
            <p class="lead text-center">As principais ferramentas para o Design são: Criatividade, Imaginação e Conhecimento.</p><br>
            <h5 class="text-center text-indigo">Itens que faço design:</h5>
            <p class="lead text-center">WebSites, Logos, Imagens, Vídeos e Projetos</p><br>
            <h5 class="text-center text-indigo">Design Tools:</h5>
            <p class="lead text-center">
              Adobe Photoshop <br>
              Adobe After Effects <br>
              Adobe Premiere <br>
              Cinema 4D <br>
              Sony Vegas <br>
              Canvas <br>
            </p><br>
          </div>
        </div>
      </div>

  </div>
</div>

<!-- Meus Projetos -->
<div class="container-fluid">
<h1 class="display-5 text-center"> Meus projetos </h1><br>
  <div class="container-fluid row mx-auto">

    <div class="col-sm-12 col-md-6 col-lg-4 my-1">
    <center>
      <div class="proj-container">
        <div class="figure">
          <img src="img/p1.png" class="figure-img rounded proj-img">
          <div class="proj-over rounded">
            <div class="proj-text">
              <p class="proj-size">Plataforma de preparação de candidatos para concursos públicos.</p>
              <a href="https://sistema.coachingconcurseiros.net" target="_blank"><button class="btn btn btn-outline-light">Visualizar</button></a>
            </div>
          </div>
        </div>
      </div>
    </center>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-1">
    <center>
      <div class="proj-container">
        <div class="figure">
          <img src="img/p2.png" class="figure-img rounded proj-img">
          <div class="proj-over rounded">
            <div class="proj-text">
              <p class="proj-size">E-commerce de venda de produto para emagrecimento.</p>
              <a href="http://lipoturbox.com.br/" target="_blank"><button class="btn btn btn-outline-light">Visualizar</button></a>
            </div>
          </div>
        </div>
      </div>
    </center>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 my-1">
    <center>
      <div class="proj-container">
        <div class="figure">
          <img src="img/p3.png" class="figure-img rounded proj-img">
          <div class="proj-over rounded">
            <div class="proj-text">
              <p class="proj-size">Faculdade de Tecnologia de Taubaté.</p>
              <a href="http://fatectaubate.edu.br/" target="_blank"><button class="btn btn btn-outline-light">Visualizar</button></a>
            </div>
          </div>
        </div>
      </div>
    </center>
    </div>

  </div>
</div>

<!-- Envio de Contato-->
<div class="container-fluid my-5">
  <h1 class="display-5 text-center"> Contato </h1><br>
    <div class="container">
      <form>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="user_name text-center">Nome</label>
            <input type="text" class="form-control" id="user_name" placeholder="Nome">
          </div>
          <div class="form-group col-md-6">
            <label for="user_email text-center">Email</label>
            <input type="email" class="form-control email" id="user_email" placeholder="Endereço de email">
          </div>
        </div>
        <center class="my-3">
          <button type="button" class="btn btn-outline-success">Enviar contato</button>
        </center>
      </form>
    </div>
  <div

</div>

</body>
</html>
