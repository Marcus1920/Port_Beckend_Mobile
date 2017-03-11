<!DOCTYPE html>
<html>
<head>
  <!-- Site made with Mobirise Website Builder v3.10.4, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v3.10.4, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="assets/images/logo-139x128-92.jpg" type="image/x-icon">
  <meta name="description" content="">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">

       <link href="{{ asset('assets/bootstrap-material-design-font/css/material.css') }}" rel="stylesheet">
     <link href="{{ asset('assets/web/assets/mobirise-icons/mobirise-icons.css') }}" rel="stylesheet">
     <link href="{{ asset('assets/et-line-font-plugin/style.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/tether/tether.min.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	  
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dropdown/css/style.css') }}" rel="stylesheet">

<link href="{{ asset('assets/theme/css/style.css') }}" rel="stylesheet">

<link href="{{ asset('assets/mobirise/css/mbr-additional.css') }}" rel="stylesheet">
  
  
  
</head>


<body>
<section id="menu-4">

    <nav class="navbar navbar-dropdown bg-color transparent navbar-fixed-top">
        <div class="container">

            <div class="mbr-table">
                <div class="mbr-table-cell">

                    <div class="navbar-brand">
                        <a href="#" class="navbar-logo"><img src="assets/images/logo-139x128dsdsdsdfsdfssd-92.png" alt="Mobirise"></a>
                        <a class="navbar-caption" href="#">ConnectU Media</a>
                    </div>

                </div>
                <div class="mbr-table-cell">

                    <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                        <div class="hamburger-icon"></div>
                    </button>


                    <ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-sm" id="exCollapsingNavbar"><li class="nav-item"><a class="nav-link link" href="home">HOME &nbsp;</a></li><li class="nav-item"><a class="nav-link link" href="coporate">CORPORATE&nbsp;</a></li><li class="nav-item"><a class="nav-link link" href="medical">MEDICAL &nbsp;PRACTICES&nbsp;</a></li><li class="nav-item"><a class="nav-link link" href="contactus">CONTACT &nbsp;US &nbsp;&nbsp;</a></li></ul>
                    <button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                        <div class="close-icon"></div>
                    </button>

                </div>
            </div>

        </div>
    </nav>

</section>

<section class="engine"><a rel="external" href="https://mobirise.com">simple responsive site creator software</a></section><section class="mbr-section mbr-parallax-background mbr-after-navbar" id="content8-v" style="background-image: url(assets/images/jumbotron-2000x1500-75.jpg); padding-top: 120px; padding-bottom: 120px;">

    <div class="mbr-overlay" style="opacity: 0.2; background-color: rgb(0, 0, 0);">
    </div>

    <div class="container">


    </div>

</section>

<section class="mbr-section mbr-parallax-background" id="form1-w" style="background-image: url(assets/images/jumbotron.jpg); padding-top: 120px; padding-bottom: 120px;">

    <div class="mbr-section mbr-section__container mbr-section__container--middle">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-xs-center">
                    <h3 class="mbr-section-title display-2">CONTACT FORM</h3>

                </div>
            </div>
        </div>
    </div>
    <div class="mbr-section mbr-section-nopadding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1" data-form-type="formoid">

@if (session('status'))
    <div class="alert alert-success">



        <span class="glyphicon glyphicon-thumbs-up">    {{ session('status') }}   </span>
    </div>
@endif
                    <div data-form-alert="true">
                        <div hidden="" data-form-alert-success="true" class="alert alert-form alert-success text-xs-center">Thanks for filling out form!</div>
                    </div>


                    <form action="getdataform" method="post" data-form-title="CONTACT FORM">

                     {{ csrf_field() }}

                        <input type="hidden" value="ogWJddT234Jzvwm6YKS0lZcVGytd5RH1hkx7VOyRrbhVPeMs4Eavx35cdSItxqt9lepkLZXCJzi4UlYIsw+fkpIblR/MnQ9I2sO9lHp0PjmjiJQUOQuf+uc8Qg9oJ3g4" data-form-email="true">

                        <div class="row row-sm-offset">

                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="form1-w-name">Name<span class="form-asterisk">*</span></label>
                                    <input type="text" class="form-control" name="name" required="" data-form-field="Name" id="form1-w-name">
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="form1-w-email">Email<span class="form-asterisk">*</span></label>
                                    <input type="email" class="form-control" name="email" required="" data-form-field="Email" id="form1-w-email">
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="form1-w-phone">Phone</label>
                                    <input type="tel" class="form-control" name="phone" data-form-field="Phone" id="form1-w-phone">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="form1-w-message">Message</label>
                            <textarea class="form-control" name="message" rows="7" data-form-field="Message" id="form1-w-message"></textarea>
                        </div>

                        <div><button type="submit" class="btn btn-primary">CONTACT US</button></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section mbr-section-md-padding mbr-footer footer1 mbr-parallax-background" id="contacts1-b" style="background-image: url(assets/images/jumbotron.jpg); padding-top: 60px; padding-bottom: 30px;">
    <div class="mbr-overlay" style="opacity: 0.8; background-color: rgb(60, 60, 60);"></div>
    <div class="container">
        <div class="row">
            <div class="mbr-footer-content col-xs-12 col-md-3">
                <div><img src="assets/images/logo-139x128dsdsdsdfsdfssd-92.png"></div>
            </div>
            <div class="mbr-footer-content col-xs-12 col-md-4">
                <p>About us<br><br>ConnectU is a marketing company that specializes in the medical field.Our vision is to be the leading marketing company in Africa by installing digital screens all over the continent in renowned hospitals and medical practices.Our goal is to create a company that benefits all aspects of the Industry, ConnectU provides an opportunity for the general public, medical practices and multinational companies to benefit from each other in their own unique way. We pride our selves in the education and well being of others.<br></p>
            </div>

            <div class="mbr-footer-content col-xs-12 col-md-3">
                <p>Contacts<br><br>Email: greg@connectumedia.co.za<br>Phone: +27827982660<br><br></p>
            </div>

        </div>
    </div>
</section>




  <script src="{{ asset('assets/web/assets/jquery/jquery.min.js') }}"></script> 
  
  <script src="{{ asset('assets/tether/tether.min.js') }}"></script> 

  <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script> 
 <script src="{{ asset('assets/smooth-scroll/SmoothScroll.js') }}"></script> 
<script src="{{ asset('assets/viewportChecker/jquery.viewportchecker.js') }}"></script> 
   <script src="{{ asset('assets/dropdown/js/script.min.js') }}"></script> 
  
  
  <script src="{{ asset('assets/bootstrap-carousel-swipe/bootstrap-carousel-swipe.js') }}"></script> 
  <script src="{{ asset('assets/touchSwipe/jquery.touchSwipe.min.js') }}"></script> 
   <script src="{{ asset('assets/theme/js/script.js') }}"></script> 
<script src="{{ asset('assets/jarallax/jarallax.js') }}"></script>


  <input name="animation" type="hidden">
  </body>
</html>