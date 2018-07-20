<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Permise și Înmatriculări</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">

  <!-- Database connection -->
  <?php
    include "database/connection.php";
    include "include/function_pack.php";
  ?>
</head>

<body>

  <!-- Navigation -->
  <?php
    include "include/components/main_nav.php";
  ?>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-0">Bine ați venit pe site-ul Permise și Înmatriculari!</h1>
          <h3 class="mb-0">Realizați în câțiva pași simpli o programare online!</h3>
        </div>
          <!--
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form>
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                </div>
              </div>
            </form>
          </div>-->
        </div>
      </div>
    </header>

    <!--  Second nav  -->
    <nav class="navbar navbar-expand-lg navbar-light nav-content" style="z-index: 10;">
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  		</button>
  		<div class="collapse navbar-collapse" id="navbarNav">
	    	<ul class="navbar-nav">
		      	<li class="nav-item">
		        	<a class="nav-link" href="#inmatriculare">Înmatriculare</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="nav-link" href="#radiere">Radiere</a>
		      	</li>
		      	<li class="nav-item">
		       		<a class="nav-link" href="#duplicare">Duplicare certificat</a>
		      	</li>
		       	<li class="nav-item">
	       			<a class="nav-link" href="#placute">Păcuțe pierdute</a>
	      		</li>
		       	<li class="nav-item">
	       			<a class="nav-link" href="#preschimbare_permise">Preschimbare permise</a>
	      		</li>
		       	<li class="nav-item">
	       			<a class="nav-link" href="#dosar_examinare">Dosar examinare</a>
	      		</li>
	    	</ul>
	  	</div>
	</nav>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center" style="z-index: 1;">
      <div class="container">
        <div class="row">

          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-screen-desktop m-auto text-primary"></i>
              </div>
              <h3>Ușor de folosit</h3>
              <p class="lead mb-0">Acum puteți face rezervări de pe orice dispozitiv, indiferent de mărime!</p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-layers m-auto text-primary"></i>
              </div>
              <h3>Ați uitat când aveți programare?</h3>
              <p class="lead mb-0">Vă oferim posibilitatea de a afla imediat!</p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-check m-auto text-primary"></i>
              </div>
              <h3>Protejează datele personale</h3>
              <p class="lead mb-0">Aveți încredere în noi! Datele dumneavoastră sunt în siguranță!</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Image Showcases -->
    <section class="showcase" id="programare">
      <div class="container-fluid p-0">

        <div class="row no-gutters" id="inmatriculare">
          <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/bg-showcase-1.jpg');" onclick="window.location.href = 'formular_inmatriculari.php';" alt="Programare înmatriculare"></div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>Programare înmatriculare</h2>
            <p class="lead mb-0">Realizați o programare pentru Înmatricularea unei mașini!</p>
            <a href="formular_inmatriculari.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>

        <div class="row no-gutters" id="radiere">
          <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/bg-showcase-2.jpg');" onclick="window.location.href = 'formular_inmatriculari.php';"></div>
          <div class="col-lg-6 my-auto showcase-text">
            <h2>Radiere vehicul</h2>
            <p class="lead mb-0">Dacă aveți un vehicul avariat și doriți să-l radiați, realizați o programare!</p>
            <a href="formular_inmatriculari.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>

        <div class="row no-gutters" id="duplicare">
          <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/bg-showcase-3.jpg');" onclick="window.location.href = 'formular_inmatriculari.php';" ></div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>Duplicare certificat</h2>
            <p class="lead mb-0">Realizați o programare pentru duplicarea unui certificat de înmatriculare!</p>
            <a href="formular_inmatriculari.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>

        <div class="row no-gutters" id="placute">
          <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/bg-showcase-4.jpg');" onclick="window.location.href = 'formular_inmatriculari.php';"></div>
          <div class="col-lg-6 my-auto showcase-text">
            <h2>Placuțe pierdute</h2>
            <p class="lead mb-0">Programare pentru pierderea plăcuțelor!</p>
            <a href="formular_inmatriculari.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>

        <div class="row no-gutters" id="preschimbare_permise">
          <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/bg-showcase-5.jpg');"  onclick="window.location.href = 'formular_permise.php';"></div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>Preschimbare permise</h2>
            <p class="lead mb-0">Permisele expirate trebuie preschimbate!</p>
            <a href="formular_permise.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>

        <div class="row no-gutters" id="dosar_examinare">
          <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/bg-showcase-6.jpg');"  onclick="window.location.href = 'formular_permise.php';"></div>
          <div class="col-lg-6 my-auto showcase-text">
            <h2>Dosar examinare</h2>
            <p class="lead mb-0">Este timpul pentru marele examen de permis! Nu ezitați și programați-vă din timp!</p>
            <a href="formular_permise.php" type="submit" class="btn btn-primary">Realizează programarea</a>
          </div>
        </div>


      </div>
    </section>


    <!-- Modal Preschimbare permise + Dosare Examinare -->
    <div id="preschimbare_permise_modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Dorești să faci o programare?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Preschimbare permise/Dosar examinare</h5>
            <h6>Pasul 1: Completează câmpurile cu datele cerute!</h6>
            <p>
              <button class="btn-xs btn-info" data-toggle="collapse" data-target="#info1">Informații</button>
              <div id="info1" class="collapse">
                Lorem ipsum dolor text....
              </div>
            </p>
            <form action="" method="post">

              <div class="form-group">
                <label for="nume_prenume">Nume prenume<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="nume_prenume" name="nume_prenume" placeholder="Nume Prenume">
              </div>

              <div class="form-group">
                <label for="email">E-mail (pentru trimiterea fișei de programare):</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
              </div>

              <div class="form-group">
                <label for="serie_CI">Număr C.I (ex. XT312134)<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="serie_CI" name="serie_CI" placeholder="Serie C.I.">
              </div>

              <div class="form-group">
                <label class="radio-inline"><input type="radio" name="rd_preschimbare" value="preschimbare" checked>Preschimbare permise</label>
              </div>
              
              <div class="form-group">
                <label class="radio-inline"><input type="radio" name="rd_preschimbare" value="dosare">Examinare dosare</label>
              </div>

              <div class="form-group">
                <label for="data1">Data in care se realizează rezervarea<span class="text-danger">*</span>:</label>
                <input type="date" class="form-control" id="data1" name="data">
              </div>

              <div class="form-group">
                <button type="submit" class="btn-primary btn-md" name="preschimbare_permise">Terminat</button>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
      <div class="container">
        <h2 class="mb-5">What people are saying...</h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-1.jpg" alt="">
              <h5>Margaret E.</h5>
              <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-2.jpg" alt="">
              <h5>Fred S.</h5>
              <p class="font-weight-light mb-0">"Bootstrap is amazing. I've been using it to create lots of super nice landing pages."</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-3.jpg" alt="">
              <h5>Sarah	W.</h5>
              <p class="font-weight-light mb-0">"Thanks so much for making these free resources available to us!"</p>
            </div>
          </div>
        </div>
      </div>
    </section>
	

    <!-- Call to Action -->
    <!--
    <section class="call-to-action text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h2 class="mb-4">Ready to get started? Sign up now!</h2>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form>
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
	-->

    <!--Footer -->
    <?php
      include "include/components/footer.php";
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>
