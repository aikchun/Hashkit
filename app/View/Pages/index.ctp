<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="/img/wallpaper6.jpg" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <!-- <h1>HashKit</h1> -->
          <img src="/img/hash_logo.png">
          <?php if($authUser):?>
          <h3>You are a click away to learn about hash functions and to start, press the any button below:</h3>

          <div class="btn-group">
          <a class="btn btn-lg btn-primary" href="/Pages/hash_information">Information</a>
          <a class="btn btn-lg btn-warning" href="/Questionnaires/questionnaire">Quiz</a>
          </div>
          <?php endif;?>
          
          <?php if(!$authUser):?>
          <h3>Want to learn more about hash functions? Now, You can by just clicking the buttons below:</h3>
          <div class="btn-group">
          <a class="btn btn-lg btn-primary" href="/Users/register">Register</a>
          <a class="btn btn-lg btn-warning" href="/Users/login">Login</a>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
    <div class="item">
      <img src="/img/wallpaper3.jpg" class="img-responsive">
      <div class="container">
        <div class="carousel-caption" id="blackfrontforcarousel">
          <h1>Facts about Hash functions</h1>
          
          <?php if($authUser):?>
          <h3>Find out more about Hash functions by clicking the button below:</h3>
          <button type="button" id="btlogin" class="btn btn-lg btn-warning" href="/Pages/hash_information">start</button>
          <?php endif;?>

          <?php if(!$authUser):?>
          <h3>want to learn more ? Login and You can read up on information about Hash functions</h3>
          <button type="button" id="btlogin" class="btn btn-lg btn-warning" href="/Users/login">Login</button>
          <?php endif;?>

        </div>
      </div>
    </div>
    <div class="item">
      <img src="/img/wallpaper4.jpg" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>Reverse look-up.. Comparison between hash functions</h1>
          <p>And many more.. Come and try out our tools by logging in..</p>
          <?php if(!$authUser):?>
          <button type="button" id="btlogin" class="btn btn-lg btn-warning" href="/Users/login">Login</button>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
  <!-- Controls -->
  <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="icon-prev"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="icon-next"></span>
  </a> -->  
</div>
<!-- /.carousel -->

<section class="container-fluid" id="section1">
  <h1 class="text-center v-center">About Us</h1>
  <h3 class="text-center v-center">We are a group of university students from UOW (University of Wollongong), who are dedicated to impart information to users on the topic of hash functions by giving users a new holistic web environment for better understanding. 
  <br>  
  </h3>
  <br>
    <div class="row"> 
      <div class="col-sm-4"><img src="/img/schoolbuilding.jpg" class="img-responsive"></div>
      <div class="col-sm-4"><img src="/img/group.jpg" class="img-responsive"></div>
      <div class="col-sm-4"><img src="/img/uow.jpg" class="img-responsive"></div>
    </div>
  <br>
  <br>
</section>

<section class="container-fluid" id="section2">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2 text-center">
        <h1>What is Bootstrap1?</h1>
        <br>
    <p class="lead" id="section2paragraph">Bootstrap is a free collection of tools for creating websites and web applications. It contains HTML and CSS-based design templates for typography, forms, buttons, navigation and other interface components, as well as optional JavaScript extensions. It is the No.1 project on GitHub with 65,000+ stars and 23,800 forks (as of March 2014) [1] and has been used by NASA and MSNBC, among many others..</p>
        <br> 
        <i style="font-size:120px" class="fa fa-camera fa-5x"></i>
        <p>Big 'ol Camera Icon</p>
    </div>
  </div>
</section>

<section class="container-fluid" id="section3">
  <h1 class="text-center">Bootstrap is Responsive</h1>
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <p class="text-center lead">Vertical scrolling has become a popular and lasting trend in Web design. The question becomes, is it here to stay?</p>
        <div class="row">
          <div class="col-xs-6">Some brand-tacular designs even have home page content that is taller that 12,000 pixels. That's a lotta content.</div>
          <div class="col-xs-6 text-right">Anyhoo, this is just some random blurb of text, and Bootply.com is a playground and code editor for Bootstrap.</div>
        </div>
        <p class="text-center">
          <!-- <img src="/assets/example/img_mtnpeople.png" class="img-responsive center-block "> -->
        </p>
      </div>
   </div>
</section>

<section class="container-fluid" id="section4">
  <h2 class="text-center">Change this Content. Change the world.</h2>
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
      <!-- <img src="/assets/example/bg_smartphones.jpg" class="img-responsive center-block "> -->
      <p class="text-center">Images will scale down proportionately as browser width narrows.</p>
      </div>
    </div>
</section>

<section class="container-fluid" id="section5">
  <h2 class="text-center">Do you see what I mean?</h2>
    <p class="text-center lead">Add some compelling information here</p>
    <!-- <img src="/assets/example/bg_iphone.png" class="img-responsive center-block "> -->
</section>

<script type="text/javascript">

    $('#myCarousel').carousel({ interval: 3000 })   

</script>
