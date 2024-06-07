<?php include(APPPATH . 'Views/include/header.php')?>

<div class="page-wrapper">

<!-- Header Main Area -->
<header class="site-header header-style-1">
   <div class="pbmit-header-top-area">
	  <div class="container">
		 <div class="d-flex align-items-center">
			<div class="site-branding flex-grow-1">
			   <a href="index.html">
				  <img class="pbmit-main-logo" src="<?= base_url('assets/images/grevo-logo-new.svg')?>" alt="Grevo Demo1" title="Grevo Demo1" />
			   </a>
			</div>
			<div class="pbmit-header-info">
			   <div class="pbmit-header-info-inner">
				  <div class="pbmit-header-box pbmit-header-box-1">
					 <a href="tel:(+00)888.666.88">			
						<span class="pbmit-header-box-icon">
						   <i class="pbmit-grevo-icon pbmit-grevo-icon-time-call"></i>
						</span>					
						<span class="pbmit-header-box-title">Please Make a call</span>
						<span class="pbmit-header-box-content">(+00)888.666.88</span>
					 </a>			
				  </div>
				  <div class="pbmit-header-box pbmit-header-box-2">
					 <a href="contact-us.html">					
						<span class="pbmit-header-box-icon">
						   <i class="pbmit-grevo-icon pbmit-grevo-icon-open"></i>
						</span>					
						<span class="pbmit-header-box-title">E-mail Address</span>
						<span class="pbmit-header-box-content">grevoinfo@gmail.com</span>
					 </a>			
				  </div>
				  <div class="pbmit-header-box pbmit-header-box-3">
					 <a href="contact-us.html">					
						<span class="pbmit-header-box-icon">
						   <i class="pbmit-grevo-icon pbmit-grevo-icon-location"></i>
						</span>					
						<span class="pbmit-header-box-title">Our Office Address</span>
						<span class="pbmit-header-box-content">Los Angeles Gournadi</span>
					 </a>			
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
   </div>
   <div class="site-header-menu">
	  <div class="container">
		 <div class="row">
			<div class="col-md-12">
			   <div class="d-flex align-items-center justify-content-between">
				  <div class="site-navigation ml-auto pmbit-left-edpand d-flex align-items-center justify-content-between p-0">
					 <h1 class="site-title">
						<a href="index.html" rel="home">
						   <img class="pbmit-sticky-logo" src="<?= base_url('assets/images/grevo-logo-new.svg')?>" alt="Grevo Demo1" title="Grevo Demo1" />
						</a>
					 </h1>
					 <nav class="main-menu navbar-expand-xl navbar-light">
						<div class="navbar-header">
						   <!-- Toggle Button --> 
						   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							  <i class="pbmit-base-icon-menu-1"></i>
						   </button>
						</div>
						<div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
						   <ul class="navigation clearfix">
							  <li class="dropdown active">
								 <a href="index.html">Home</a>
								 <ul>
									<li class="active"><a href="index.html">Home page 01</a></li>
									<li><a href="index-02.html">Home page 02</a></li>
									<li><a href="index-03.html">Home page 03</a></li>
								 </ul>
							  <li class="dropdown">
								 <a href="#">Pages</a>
								 <ul>
									<li><a href="about-us.html">About Us</a></li>
									<li><a href="our-history.html">Our History</a></li>
									<li><a href="our-plans.html">Our Plans</a></li>                                             
									<li><a href="our-team-member.html">Our Team Member</a></li>
									<li><a href="team-member-detail.html">Team Member Detail</a></li>
									<li><a href="services.html">Services</a></li>
									<li><a href="faq.html">Faq</a></li>
								 </ul>
							  <li class="dropdown">
								 <a href="services.html">Services</a>
								 <ul>
									<li><a href="service-details.html">Service Detail</a></li>
								 </ul>
								 <li class="dropdown">
									<a href="#">Gallery</a>
									<ul>
									   <li><a href="project-style-1.html">Project Style 1</a></li>
									   <li><a href="project-style-2.html">Project Style 2</a></li>
									   <li><a href="project-style-3.html">Project Style 3</a></li>
									   <li><a href="project-details.html">Project Single Details</a></li>
									</ul>
							  <li class="dropdown">
								 <a href="#">Blog</a>
								 <ul>
									<li><a href="blog-classic.html">Blog Classic</a></li>
									<li><a href="blog-grid.html">Blog Grid View</a></li>
									<li><a href="blog-details.html">Blog Single Details</a></li>
								 </ul>
							  <li><a href="contact-us.html">Contact US</a></li>
						   </ul>
						</div>
					 </nav>
					 <div class="pbmit-right-box ml-auto">
						<div class="pbmit-search-cart-box">
						   <div class="pbmit-header-search-btn">
							  <a href="#"><i class="pbmit-base-icon-search-1"></i></a>
						   </div>
						</div>
					 </div>
				  </div>
				  <div class="menu-right-box d-flex align-items-center">
					 <div class="header-button">
						<a href="contact-us.html" class="pbmit-btn pbmit-btn-secondary pbmit-btn-hover-global">
						   <span>Get a quote</span>
						</a>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
   </div>

   <div>
   <div>
	<?php 
	 	//Adresa dané ROUTE pro redirect na katuální stránku
		$redirectUrl = '/';
		include(APPPATH . 'Views/include/contactForm.php')
	?>
   </div>
   </div>
   <!-- START Slider Demo 1 REVOLUTION SLIDER 6.5.25 -->
   <rs-module-wrap id="rev_slider_1_1_wrapper" data-alias="slider-demo-1" data-source="gallery" style="visibility:hidden;background:transparent;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
	  <rs-module id="rev_slider_1_1" style="" data-version="6.5.24">
		 <rs-slides>
			<rs-slide style="position: absolute;" data-key="rs-1" data-title="Slide" data-thumb="revolution/images/slider01-img1-50x100.jpg" data-in="o:0;" data-out="a:false;">
			   <img src="<?= base_url('assets/revolution/images/slider01-img1.jpg')?>" alt="" title="slider01-img1" width="1920" height="825" class="rev-slidebg tp-rs-img" data-no-retina>
<!--
			   --><rs-layer
				  id="slider-1-slide-1-layer-0" 
				  data-type="text"
				  data-color="#131419"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:-40px,-55px,-51px,-26px;"
				  data-text="w:normal;s:50,41,31,20;l:55,45,34,20;ls:-1px,0px,0px,0px;fw:700;"
				  data-dim="w:421px,359px,272px,181px;"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1000;sp:1000;sR:1000;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:7000;"
				  style="z-index:9;font-family:'Quicksand';"
			   >We believe travel shouldn't <span class="pbmit-globalcolor">damage the earth</span> 
			   </rs-layer><!--

			   --><a
				  id="slider-1-slide-1-layer-1" 
				  class="rs-layer rev-button rev-btn"
				  href="http://grevo-demo.pbminfotech.com/demo1/contact-us/" target="_self"
				  data-type="button"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:160px,115px,90px,48px;"
				  data-text="w:normal;s:13;l:60,55,50,45;fw:700;"
				  data-dim="minh:0px,none,none,none;"
				  data-padding="r:50,42,32,20;l:50,42,32,20;"
				  data-border="bor:20px,0px,20px,0px;"
				  data-frame_0="y:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:2340;sp:1200;sR:2340;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:5460;"
				  data-frame_hover="bgc:#8cc63f;bor:0px,25px,0px,0px;"
				  style="z-index:11;background-color:#131419;font-family:'Quicksand';text-transform:uppercase;"
			   ><span>Join Our Club</span> 
			   </a><!--

			   --><rs-layer
				  id="slider-1-slide-1-layer-5" 
				  data-type="shape"
				  data-rsp_ch="on"
				  data-xy="xo:30px;y:m;yo:35px,0,0,0;"
				  data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
				  data-dim="w:550px,457px,347px,249px;h:450px,374px,296px,212px;"
				  data-border="bor:50px,0,50px,0;"
				  data-frame_0="x:0,0,0,0px;y:0,0,0,0px;"
				  data-frame_1="x:0,0,0,0px;y:0,0,0,0px;e:power4.inOut;sp:1500;"
				  data-frame_999="o:0;st:w;sR:8700;"
				  style="z-index:8;background-color:rgba(255,255,255,0.9);"
			   > 
			   </rs-layer><!--

			   --><rs-layer
				  id="slider-1-slide-1-layer-6" 
				  data-type="text"
				  data-color="#666666"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,40px;y:m;yo:80px,45px,30px,18px;"
				  data-text="w:normal;s:24,19,16,9;l:30,24,18,11;"
				  data-vbility="t,t,t,f"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1580;sp:1000;sR:1580;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:6420;"
				  style="z-index:10;font-family:'Nunito';"
			   >Eiusmod tempor incididunt ut labore et. 
			   </rs-layer><!--
-->						</rs-slide>
			<rs-slide style="position: absolute;" data-key="rs-17" data-title="Slide" data-thumb="revolution/images/slider01-img2-50x100.jpg" data-in="o:0;" data-out="a:false;">
			   <img src="<?= base_url('assets/revolution/images/slider01-img2.jpg')?>" alt="" title="slider01-img2" width="1920" height="825" class="rev-slidebg tp-rs-img" data-no-retina>
<!--
			   --><rs-layer
				  id="slider-1-slide-17-layer-0" 
				  data-type="text"
				  data-color="#131419"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:-40px,-55px,-51px,-26px;"
				  data-text="w:normal;s:50,41,31,20;l:55,45,34,20;ls:-1px,0px,0px,0px;fw:700;"
				  data-dim="w:421px,359px,272px,181px;"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1000;sp:1000;sR:1000;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:7000;"
				  style="z-index:9;font-family:'Quicksand';"
			   >We believe travel shouldn't <span class="pbmit-globalcolor">damage the earth</span> 
			   </rs-layer><!--

			   --><a
				  id="slider-1-slide-17-layer-1" 
				  class="rs-layer rev-button rev-btn"
				  href="http://grevo-demo.pbminfotech.com/demo1/contact-us/" target="_self"
				  data-type="button"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:160px,115px,90px,48px;"
				  data-text="w:normal;s:13;l:60,55,50,45;fw:700;"
				  data-dim="minh:0px,none,none,none;"
				  data-padding="r:50,42,32,20;l:50,42,32,20;"
				  data-border="bor:20px,0px,20px,0px;"
				  data-frame_0="y:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:2340;sp:1200;sR:2340;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:5460;"
				  data-frame_hover="bgc:#8cc63f;bor:0px,25px,0px,0px;"
				  style="z-index:11;background-color:#131419;font-family:'Quicksand';text-transform:uppercase;"
			   ><span>Join Our Club</span> 
			   </a><!--

			   --><rs-layer
				  id="slider-1-slide-17-layer-5" 
				  data-type="shape"
				  data-rsp_ch="on"
				  data-xy="xo:30px;y:m;yo:35px,0,0,0;"
				  data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
				  data-dim="w:550px,457px,347px,249px;h:450px,374px,296px,212px;"
				  data-border="bor:50px,0,50px,0;"
				  data-frame_0="x:0,0,0,0px;y:0,0,0,0px;"
				  data-frame_1="x:0,0,0,0px;y:0,0,0,0px;e:power4.inOut;sp:1500;"
				  data-frame_999="o:0;st:w;sR:8700;"
				  style="z-index:8;background-color:rgba(255,255,255,0.9);"
			   > 
			   </rs-layer><!--

			   --><rs-layer
				  id="slider-1-slide-17-layer-6" 
				  data-type="text"
				  data-color="#666666"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,40px;y:m;yo:80px,45px,30px,18px;"
				  data-text="w:normal;s:24,19,16,9;l:30,24,18,11;"
				  data-vbility="t,t,t,f"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1580;sp:1000;sR:1580;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:6420;"
				  style="z-index:10;font-family:'Nunito';"
			   >Eiusmod tempor incididunt ut labore et. 
			   </rs-layer><!--
-->						</rs-slide>
			<rs-slide style="position: absolute;" data-key="rs-18" data-title="Slide" data-thumb="revolution/images/slider01-img3-50x100.jpg" data-in="o:0;" data-out="a:false;">
			   <img src="<?= base_url('assets/revolution/images/slider01-img3.jpg')?>" alt="" title="slider01-img3" width="1920" height="825" class="rev-slidebg tp-rs-img" data-no-retina>
<!--
			   --><rs-layer
				  id="slider-1-slide-18-layer-0" 
				  data-type="text"
				  data-color="#131419"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:-40px,-55px,-51px,-26px;"
				  data-text="w:normal;s:50,41,31,20;l:55,45,34,20;ls:-1px,0px,0px,0px;fw:700;"
				  data-dim="w:421px,359px,272px,181px;"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1000;sp:1000;sR:1000;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:7000;"
				  style="z-index:9;font-family:'Quicksand';"
			   >We believe travel shouldn't <span class="pbmit-globalcolor">damage the earth</span> 
			   </rs-layer><!--

			   --><a
				  id="slider-1-slide-18-layer-1" 
				  class="rs-layer rev-button rev-btn"
				  href="http://grevo-demo.pbminfotech.com/demo1/contact-us/" target="_self"
				  data-type="button"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,65px;y:m;yo:160px,115px,90px,48px;"
				  data-text="w:normal;s:13;l:60,55,50,45;fw:700;"
				  data-dim="minh:0px,none,none,none;"
				  data-padding="r:50,42,32,20;l:50,42,32,20;"
				  data-border="bor:20px,0px,20px,0px;"
				  data-frame_0="y:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:2340;sp:1200;sR:2340;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:5460;"
				  data-frame_hover="bgc:#8cc63f;bor:0px,25px,0px,0px;"
				  style="z-index:11;background-color:#131419;font-family:'Quicksand';text-transform:uppercase;"
			   ><span>Join Our Club</span> 
			   </a><!--

			   --><rs-layer
				  id="slider-1-slide-18-layer-5" 
				  data-type="shape"
				  data-rsp_ch="on"
				  data-xy="xo:30px;y:m;yo:35px,0,0,0;"
				  data-text="w:normal;s:20,16,12,7;l:0,20,15,9;"
				  data-dim="w:550px,457px,347px,249px;h:450px,374px,296px,212px;"
				  data-border="bor:50px,0,50px,0;"
				  data-frame_0="x:0,0,0,0px;y:0,0,0,0px;"
				  data-frame_1="x:0,0,0,0px;y:0,0,0,0px;e:power4.inOut;sp:1500;"
				  data-frame_999="o:0;st:w;sR:8700;"
				  style="z-index:8;background-color:rgba(255,255,255,0.9);"
			   > 
			   </rs-layer><!--

			   --><rs-layer
				  id="slider-1-slide-18-layer-6" 
				  data-type="text"
				  data-color="#666666"
				  data-rsp_ch="on"
				  data-xy="xo:95px,80px,65px,40px;y:m;yo:80px,45px,30px,18px;"
				  data-text="w:normal;s:24,19,16,9;l:30,24,18,11;"
				  data-vbility="t,t,t,f"
				  data-frame_0="x:100%;"
				  data-frame_0_mask="u:t;"
				  data-frame_1="st:1580;sp:1000;sR:1580;"
				  data-frame_1_mask="u:t;"
				  data-frame_999="o:0;st:w;sR:6420;"
				  style="z-index:10;font-family:'Nunito';"
			   >Eiusmod tempor incididunt ut labore et. 
			   </rs-layer><!--
-->						</rs-slide>
		 </rs-slides>
		 <rs-static-layers><!--
		 --></rs-static-layers>
	  </rs-module>
	  <script>
		 
	  </script>
<script>
if(typeof revslider_showDoubleJqueryError === "undefined") {function revslider_showDoubleJqueryError(sliderID) {console.log("You have some jquery.js library include that comes after the Slider Revolution files js inclusion.");console.log("To fix this, you can:");console.log("1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on");console.log("2. Find the double jQuery.js inclusion and remove it");return "Double Included jQuery Library";}}
</script>
   </rs-module-wrap>
   <!-- END REVOLUTION SLIDER -->
</header>
<!-- Header Main Area End Here -->

<!-- Page Content -->
<div class="page-content">
   
   <!-- Welcome -->
   <section class="section-lg pb-4">
	  <div class="container">
		 <div class="row g-0">
			<div class="col-md-6 col-lg-6 col-xl-3">
			   <div class="pbmit-ihbox pbmit-ihbox-style-1">
				  <div class="pbmit-ihbox-box">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-image">
						   <img src="<?= base_url('assets/images/icon/icon-img-01.png')?>" class="img-fluid" alt="EV Charging" />
						</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">
						   <a href="project-details.html">
							  <span> EV Charging</span>
						   </a>
						</h2>
						<div class="pbmit-heading-desc">Sed sed condimentum massa. Morbi auctor vestibulum urna, ut interdum.</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3">
			   <div class="pbmit-ihbox pbmit-ihbox-style-1">
				  <div class="pbmit-ihbox-box">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-image">
						   <img src="<?= base_url('assets/images/icon/icon-img-02.png')?>" class="img-fluid" alt="Our Network " />
						</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">
						   <a href="project-details.html">
							  <span>Our Network </span>
						   </a>
						</h2>
						<div class="pbmit-heading-desc">Sed sed condimentum massa. Morbi auctor vestibulum urna, ut interdum.</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3">
			   <div class="pbmit-ihbox pbmit-ihbox-style-1">
				  <div class="pbmit-ihbox-box">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-image">
						   <img src="<?= base_url('assets/images/icon/icon-img-03.png')?>" class="img-fluid" alt="Charge Points" />
						</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">
						   <a href="project-details.html">
							  <span>Charge Points</span>
						   </a>
						</h2>
						<div class="pbmit-heading-desc">Sed sed condimentum massa. Morbi auctor vestibulum urna, ut interdum.</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3">
			   <div class="pbmit-ihbox pbmit-ihbox-style-1">
				  <div class="pbmit-ihbox-box">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-image">
						   <img src="<?= base_url('assets/images/icon/icon-img-04.png')?>" class="img-fluid" alt="Electric Driving" />
						</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">
						   <a href="project-details.html">
							  <span>Electric Driving</span>
						   </a>
						</h2>
						<div class="pbmit-heading-desc">Sed sed condimentum massa. Morbi auctor vestibulum urna, ut interdum.</div>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
   </section> 
   <div class="container">
	  <div class="text-center section-text-style">
		 <div class="pbmit-text-style-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
			<a class="text-btn" href="contact-us.html">Accept</a>
		 </div>
	  </div>
   </div>
   <!-- Welcome end -->  

   <!-- About Start -->
   <section class="section-lgx">
	  <div class="container">
		 <div class="row">
			<div class="col-md-6 col-sm-12">
			   <div class="home1-section-about-bg">
				  <div class="button-wrapper">
					 <a href="https://www.youtube.com/watch?v=3SAxXUIre28" target="_blank" class="button-link pbmin-lightbox-video" role="button">
						<span class="button-content-wrapper">
						   <span class="button-icon align-icon-left">
							  <i class="fa fa-youtube-play"></i>
						   </span>
						   <span class="button-text">Watch Our Video</span>
						</span>
					 </a>
				  </div>
			   </div>
			</div>
			<div class="col-md-6 col-sm-12 section-about-contact">
			   <div class="pbmit-heading-subheading">
				  <h4 class="pbmit-subtitle">What we do!</h4>
				  <h2 class="pbmit-title">Our mission is to put an electric vehicle charge</h2>
				  <div class="pbmit-heading-desc">Charge your electric vehicle at home using one of our smart home charge solutions or gain access to over 3,000 public charging bays across the country using our intuitive app.</div>
			   </div>
			   <div class="pbmit-ihbox pbmit-ihbox-style-2">
				  <div class="pbmit-ihbox-box d-flex align-items-center">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-text">01.</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title"> Our mission is to put an electric charge.</h2>
					 </div>
				  </div>
			   </div>
			   <div class="pbmit-ihbox pbmit-ihbox-style-2">
				  <div class="pbmit-ihbox-box d-flex align-items-center">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-text">02.</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">Access control put an electric vehicle charge.</h2>
					 </div>
				  </div>
			   </div>
			   <div class="pbmit-ihbox pbmit-ihbox-style-2">
				  <div class="pbmit-ihbox-box d-flex align-items-center">
					 <div class="pbmit-ihbox-icon">
						<div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-text">03.</div>
					 </div>
					 <div class="pbmit-ihbox-contents">
						<h2 class="pbmit-element-title">Free Support an electric vehicle charge.</h2>
					 </div>
				  </div>
			   </div>
			   <a href="contact-us.html" class="pbmit-btn pbmit-btn-secondary pbmit-btn-hover-global mt-3">
				  <span> Read  More</span>
			   </a>
			</div>
		 </div>
	  </div>
   </section>            
   <!-- About End -->  

   <!-- Service Start -->
   <section class="pbmit-bg-color-light section-lg home1-service-section">
	  <div class="container">
		 <div class="pbmit-heading-subheading center-align text-center">
			<h4 class="pbmit-subtitle">OUR SERVICES</h4>
			<h2 class="pbmit-title">We are best service Provider for the electric vehicle</h2>
		 </div>
		 <div class="col-12">
			<div class="swiper-slider" data-autoplay="false" data-dots="true" data-arrows="false" data-columns="3" data-margin="30" data-effect="slide">
			   <div class="swiper-wrapper">
				  <div class="swiper-slide">
					 <!-- Slide1 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-01.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Home Charging</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide2 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-02.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Public Stations</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide3 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-03.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Commercial Systems</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide4 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-04.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Hybrid Car Watches</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide5 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-05.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Corporate Business</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide6 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-06.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Electric Car Sale</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide7 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-07.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">EV Charging Points</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide8 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-08.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Compact Executive Car</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
				  <div class="swiper-slide">
					 <!-- Slide9 -->
					 <article class="pbmit-service-style-1">
						<div class="pbminfotech-post-item">
						   <div class="pbmit-service-img-wrapper">
							  <div class="pbmit-featured-wrapper">
								 <img src="<?= base_url('assets/images/services/service-09.jpg')?>" class="img-fluid" alt="" />
							  </div>
							  <div class="pbminfotechi-box-overlay"></div>
						   </div>
						   <div class="pbminfotech-box-content">
							  <div class="pbminfotech-box-content-inner">
								 <h3 class="pbmit-service-title"><a href="service-details.html">Solar & Clean Energy</a></h3>
								 <div class="pbmit-service-content">
									<p>There are many variations of pass ages of Lorem Ipsum available but the majority.</p>
								 </div>
								 <div class="pbmit-service-btn"> 
									<a class="btn-arrow" href="service-details.html"><span>View More</span></a>
								 </div>
							  </div>
						   </div>
						</div>
					 </article>
				  </div>
			   </div>
			</div>
		 </div>
	  </div>
   </section>
   <!-- Service End --> 

   <!-- About Safety Start -->
   <section class="section-lgt">
	  <div class="container">
		 <div class="row section-about-safety">
			<div class="col-xl-12 col-xxl-6">
			   <div class="pbmit-heading-subheading">
				  <h4 class="pbmit-subtitle">ABOUT SAFETY</h4>
				  <h2 class="pbmit-title">We care about your safety.</h2>
				  <div class="pbmit-heading-desc pe-3">Charge your electric vehicle at home using one of our smart home charge solutions or gain access to over 3,000 public charging bays across the country using our intuitive app.</div>
			   </div>
			   <div class="row g-0">
				  <div class="col-md-4">
					 <div class="pbminfotech-ele-fid-style-1 ">
						<div class="pbmit-fld-contents">
						   <div class="pbmit-sbox-icon-wrapper">
							  <i class="pbmit-grevo-icon pbmit-grevo-icon-car-1"></i>
						   </div>
						   <div class="pbmit-fld-wrap">
							  <h4 class="pbmit-fid-inner">
								 <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="1582" data-interval="5" data-before="" data-before-style="" data-after="" data-after-style="">1582</span><span class="pbmit-fid"><sup>+</sup></span>
							  </h4>
							  <div class="pbmit-fid-contents">
								 <div class="pbmit-fid-title"><span>Charging sessions</span></div>
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
				  <div class="col-md-4">
					 <div class="pbminfotech-ele-fid-style-1 ">
						<div class="pbmit-fld-contents">
						   <div class="pbmit-sbox-icon-wrapper">
							  <i class="pbmit-grevo-icon pbmit-grevo-icon-placeholder"></i>
						   </div>
						   <div class="pbmit-fld-wrap">
							  <h4 class="pbmit-fid-inner">
								 <span class="pbmit-number-rotate numinate " data-appear-animation="animateDigits" data-from="0" data-to="650" data-interval="5" data-before="" data-before-style="" data-after="" data-after-style="">650</span><span class="pbmit-fid"><sup>+</sup></span>
							  </h4>
							  <div class="pbmit-fid-contents">
								 <div class="pbmit-fid-title"><span>Green kms driven</span></div>
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
				  <div class="col-md-4">
					 <div class="pbminfotech-ele-fid-style-1 ">
						<div class="pbmit-fld-contents">
						   <div class="pbmit-sbox-icon-wrapper">
							  <i class="pbmit-grevo-icon pbmit-grevo-icon-electric-car"></i>
						   </div>
						   <div class="pbmit-fld-wrap">
							  <h4 class="pbmit-fid-inner">
								 <span class="pbmit-number-rotate numinate " data-appear-animation="animateDigits" data-from="0" data-to="1582" data-interval="5" data-before="" data-before-style="" data-after="" data-after-style="">1582</span><span class="pbmit-fid"><sup>+</sup></span>
							  </h4>
							  <div class="pbmit-fid-contents">
								 <div class="pbmit-fid-title"><span>Quality Service</span></div>
							  </div>
						   </div>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
			<div class="col-xl-12 col-xxl-6 section-about-safety-img">
			   <img src="<?= base_url('assets/images/img-02.png')?>" alt="" />
			</div>
		 </div>
	  </div>
   </section>
   <!-- About Safety End -->

   <!-- Testimonial Start -->
   <section class="section-lg home1-testimonail-section-main">          
	  <div class="position-relative ">
		 <div class="home1-test-section"></div>
		 <div class="pbmit-vertical-heading">
			<div class="pbmit-custom-heading left-align">
			   <h2 class="pbmit-test-title">Reviews</h2>
			</div>
		 </div>
		 <div class="container home1-testimonail-section">
			<div class="row">
			   <div class="col-xl-12 col-xxl-5 text-xl-center ">
				  <img src="<?= base_url('assets/images/img-03.jpg')?>" class="border-radius-top" alt="" />
			   </div>
			   <div class="col-xl-12 col-xxl-7 ps-3 ps-sm-0 pt-sm-4">
				  <div class="pbmit-heading-subheading">
					 <h4 class="pbmit-subtitle">TESTIMONAILS </h4>
					 <h2 class="pbmit-title">What Client's Say about</h2>
				  </div>
				  <div class="swiper-slider" data-autoplay="false" data-dots="false" data-arrows="true" data-columns="1" data-margin="30" data-effect="slide">
					 <div class="swiper-wrapper">
						<div class="swiper-slide">
						   <article class="pbmit-testimonial-style-1 pbmit-odd pbmit-col-odd">
							  <div class="pbminfotech-post-item">
								 <div class="pbminfotech-box-content">
									<div class="pbminfotech-box-desc">
									   <blockquote class="pbminfotech-testimonial-text">
										  <p>“After being forced to move twice within five years, our customers had a hard time finding us and our sales plummeted. The Trydus Co. not only revitalized our brand, but saved our nearly 100-year-old family business”</p>
									   </blockquote>
									</div>
									<div class="pbminfotech-author-wrapper">
									   <div class="pbminfotech-box-img">
										  <div class="pbmit-featured-wrapper">
											 <img src="<?= base_url('assets/images/testimonial/testimonial-01.jpg')?>" class="img-fluid" alt="" />
										  </div>
										  <div class="pbminfotech-box-author">
											 <h3 class="pbminfotech-box-title">Rhett Kinedy</h3>
											 <div class="pbminfotech-testimonial-detail">Head of Marketing</div>
										  </div>
									   </div>
									</div>
									<div class="pbminfotech-box-star-ratings">
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									</div>
								 </div>
							  </div>
						   </article>
						</div>
						<div class="swiper-slide">
						   <article class="pbmit-testimonial-style-1 pbmit-odd pbmit-col-odd">
							  <div class="pbminfotech-post-item">
								 <div class="pbminfotech-box-content">
									<div class="pbminfotech-box-desc">
									   <blockquote class="pbminfotech-testimonial-text">
										  <p>“After being forced to move twice within five years, our customers had a hard time finding us and our sales plummeted. The Trydus Co. not only revitalized our brand, but saved our nearly 100-year-old family business”</p>
									   </blockquote>
									</div>
									<div class="pbminfotech-author-wrapper">
									   <div class="pbminfotech-box-img">
										  <div class="pbmit-featured-wrapper">
											 <img src="<?= base_url('assets/images/testimonial/testimonial-02.jpg')?>" class="img-fluid" alt="" />
										  </div>
										  <div class="pbminfotech-box-author">
											 <h3 class="pbminfotech-box-title">Richard Powers</h3>
											 <div class="pbminfotech-testimonial-detail">CEO Co-Founder</div>
										  </div>
									   </div>
									</div>
									<div class="pbminfotech-box-star-ratings">
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									</div>
								 </div>
							  </div>
						   </article>
						</div>
						<div class="swiper-slide">
						   <article class="pbmit-testimonial-style-1 pbmit-odd pbmit-col-odd">
							  <div class="pbminfotech-post-item">
								 <div class="pbminfotech-box-content">
									<div class="pbminfotech-box-desc">
									   <blockquote class="pbminfotech-testimonial-text">
										  <p>“After being forced to move twice within five years, our customers had a hard time finding us and our sales plummeted. The Trydus Co. not only revitalized our brand, but saved our nearly 100-year-old family business”</p>
									   </blockquote>
									</div>
									<div class="pbminfotech-author-wrapper">
									   <div class="pbminfotech-box-img">
										  <div class="pbmit-featured-wrapper">
											 <img src="<?= base_url('assets/images/testimonial/testimonial-03.jpg')?>" class="img-fluid" alt="" />
										  </div>
										  <div class="pbminfotech-box-author">
											 <h3 class="pbminfotech-box-title">Maria Rusconi</h3>
											 <div class="pbminfotech-testimonial-detail">Managing Director</div>
										  </div>
									   </div>
									</div>
									<div class="pbminfotech-box-star-ratings">
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									   <i class="pbmit-base-icon-star pbmit-active"></i>
									</div>
								 </div>
							  </div>
						   </article>
						</div>
					 </div>
				  </div>
			   </div>
			</div>
		 </div>                  
		 <div class="container swiper-slider home1-client-section" data-autoplay="false" data-dots="false" data-arrows="false" data-columns="6" data-margin="30" data-effect="slide">
			<div class="swiper-wrapper">
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 1</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-01.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-01.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 2</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-02.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-02.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 3</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-03.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-03.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 4</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-04.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-04.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 5</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-05.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-05.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			   <div class="swiper-slide">
				  <article class="pbmit-ele pbmit-ele-client pbmit-client-style-1 white">
					 <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
						<h4 class="pbmit-hide">client 6</h4>
						<div class="pbmit-client-hover-img">
						   <img src="<?= base_url('assets/images/client/client-logo-06.png')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/client/client-white-06.png')?>" class="img-fluid" alt="" />
						</div>
					 </div>
				  </article>
			   </div>
			</div>
		 </div>
	  </div>
   </section>
   <!-- Testimonial End -->

   <!-- Service Points Start -->
   <section >
	  <div class="container">
		 <div class="row">
			<div class="col-md-7">
			   <img src="<?= base_url('assets/images/img-n-08.png')?>" class="img-fluid w-100" alt="" /> 
			</div>
			<div class="col-md-5 section-service-points-contant">
			   <div class="pbmit-heading-subheading">
				  <h4 class="pbmit-subtitle">SERVICE POINTS</h4>
				  <h2 class="pbmit-title">2.400 public charging points in your app</h2>
				  <div class="pbmit-heading-desc">Aliquam erat volutpat. Integer malesuada turpis id fringilla suscipit. Maecenas ultrices, orci vitae convallis mattis, quam nulla vehicula felis, eu cursus sem tellus eget elit. Proin lacinia gravida elit, et sollicitudin velit.</div>
			   </div>
			   <div  class="row g-2 ">
				  <div class="col-lg-12 col-xl-4">
					 <img src="<?= base_url('assets/images/apple-stroe.png')?>" class="img-fluid" alt="" />
				  </div>
				  <div class="col-lg-12 col-xl-4">
					 <img src="<?= base_url('assets/images/play-store.png')?>" class="img-fluid" alt="" />
				  </div>
			   </div>
			</div>                  
		 </div>
	  </div>
   </section>
   <!-- Service Points End -->

   <!-- Appointment Start -->
   <section class="section-lgt overflow-hidden">
	  <div class="container g-0">
		 <div class="row g-4">
			<div class="col-md-9">
			   <div class="pmbit-left-edpand">
				  <div class="row align-items-center">
					 <div class="col-lg-8 col-md-7">
						<div class="pbmit-ihbox pbmit-ihbox-style-3">
						   <div class="pbmit-ihbox-box">
							  <div class="pbmit-ihbox-icon">
								 <div class="pbmit-ihbox-icon-wrapper">
									<i class="pbmit-grevo-icon pbmit-grevo-icon-plugin"></i>
								 </div>
							  </div>
							  <div class="pbmit-ihbox-contents">
								 <h2 class="pbmit-element-title">Designed for the our roads.</h2>
								 <div class="pbmit-heading-desc text-white pe-5">Consectetur adipiscing elit sed do tempor labor dolore magna aliqua quis suspendisse.</div>
							  </div>
						   </div>
						</div>
					 </div>
					 <div  class="col-lg-4 col-md-5"> 
						<a href="contact-us.html" class="pbmit-btn pbmit-btn-outline pbmit-btn-hover-white">
						   <span> Book Now</span>
						</a>        
					 </div>
				  </div>
			   </div>
			</div>   
			<div class="col-md-3">
			   <div class="pmbit-right-edpand p-0">
				  <div class="pmbit-right-edpand-bg"></div>
			   </div>
			</div>
		 </div>
	  </div>
   </section>
   <!-- Appointment End -->

   <!-- Blog Start -->
   <section class="section-lgx">
	  <div class="container">
		 <div class="row align-items-center">
			<div class="col-md-6 pbmit-heading-subheading text-left">
			   <h4 class="pbmit-subtitle">FRESH NEWS</h4>
			   <h2 class="pbmit-title">Our recent article for the electric vehicle systems</h2>
			</div>
			<div class="col-md-6 text-md-end mb-5 mb-md-0">
			   <a href="blog-grid.html" class="pbmit-btn pbmit-btn-outline blog-btn-outline">
				  <span>View More Blog</span>
			   </a>
			</div>
		 </div>
		 <div class="row">
			<div class="col-md-4">
			   <article class="pbmit-blog-style-1">
				  <div class="post-item">
					 <div class="pbmit-featured-container">
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/blog/blog-01.jpg')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-meta-date-wrapper">					
						   <span class="pbmit-date">03</span> 
						   <span class="pbmit-month">Jun</span> 
						</div>
					 </div>
					 <div class="pbminfotech-box-content">
						<div class="pbmit-meta-container">
						   <div class="pbmit-meta-author-wrapper pbmit-meta-line">					
							  <a href="#" title="Posted by admin" rel="author">
								 <i class="pbmit-base-icon-user"></i> admin
							  </a>
						   </div>
						   <div class="pbmit-meta-comment-wrapper pbmit-meta-line">	
							  <span class="pbmit-meta pbmit-meta-comments">
								 <i class="pbmit-base-icon-comment"></i> 2 
								 <span class="pbmit-meta pbmit-meta-comments">Comments</span>
							  </span>
						   </div>
						</div>
						<h3 class="pbmit-post-title">
						   <a href="blog-details.html">Energy Star Certified Electric Vehicle Chargers</a>
						</h3>
						<div class="pbmit-service-btn"> 
						   <a class="btn-arrow" href="blog-details.html">Read More</a>
						</div>
					 </div>
				  </div>
			   </article>
			</div>
			<div class="col-md-4">
			   <article class="pbmit-blog-style-1">
				  <div class="post-item">
					 <div class="pbmit-featured-container">
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/blog/blog-02.jpg')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-meta-date-wrapper">					
						   <span class="pbmit-date">03</span> 
						   <span class="pbmit-month">Jun</span> 
						</div>
					 </div>
					 <div class="pbminfotech-box-content">
						<div class="pbmit-meta-container">
						   <div class="pbmit-meta-author-wrapper pbmit-meta-line">					
							  <a href="#" title="Posted by admin" rel="author">
								 <i class="pbmit-base-icon-user"></i> admin
							  </a>
						   </div>
						</div>
						<h3 class="pbmit-post-title">
						   <a href="blog-details.html">Charging Solution for Electric Car & Hybrid Car</a>
						</h3>
						<div class="pbmit-service-btn"> 
						   <a class="btn-arrow" href="blog-details.html">Read More</a>
						</div>
					 </div>
				  </div>
			   </article>
			</div>
			<div class="col-md-4">
			   <article class="pbmit-blog-style-1 last">
				  <div class="post-item">
					 <div class="pbmit-featured-container">
						<div class="pbmit-featured-wrapper">
						   <img src="<?= base_url('assets/images/blog/blog-03.jpg')?>" class="img-fluid" alt="" />
						</div>
						<div class="pbmit-meta-date-wrapper">					
						   <span class="pbmit-date">03</span> 
						   <span class="pbmit-month">Jun</span> 
						</div>
					 </div>
					 <div class="pbminfotech-box-content">
						<div class="pbmit-meta-container">
						   <div class="pbmit-meta-author-wrapper pbmit-meta-line">					
							  <a href="#" title="Posted by admin" rel="author">
								 <i class="pbmit-base-icon-user"></i> admin
							  </a>
						   </div>
						</div>
						<h3 class="pbmit-post-title">
						   <a href="blog-details.html">Home Charging Station for a Electric Vehicles</a>
						</h3>
						<div class="pbmit-service-btn"> 
						   <a class="btn-arrow" href="blog-details.html">Read More</a>
						</div>
					 </div>
				  </div>
			   </article>
			</div>
		 </div>
	  </div>
   </section>
   <!-- Blog End -->

</div>
<!-- Page Content End -->

<!-- footer Top Start-->
<section class="footer-wrap pbmit-footer-big-area">
   <div class="container">
	  <div class="row">
		 <div class="col-sm-12 d-flex justify-content-between">
			<div class="pbmit-footer-contact-info pbmit-footer-contact-info-1">
			   <span class="pbmit-header-box-icon">
				  <i class="pbmit-grevo-icon pbmit-grevo-icon-time-call"></i>
			   </span>						
			   <div class="pbmit-footer-contact-info-wrap">
				  <span class="pbmit-label">Hot Line</span>
				  <span class="pbmit-desc">+(01) 1234-57-890</span>
			   </div>
			</div>
			<div class="pbmit-footer-contact-info pbmit-footer-contact-info-2">
			   <span class="pbmit-header-box-icon">
				  <i class="pbmit-grevo-icon pbmit-grevo-icon-email"></i>
			   </span>						
			   <div class="pbmit-footer-contact-info-wrap">
				  <span class="pbmit-label">E-mail Address</span>
				  <span class="pbmit-desc">grevoinfo@gmail.com</span>
			   </div>
			</div>
			<div class="pbmit-footer-contact-info pbmit-footer-contact-info-3">
			   <span class="pbmit-header-box-icon">
				  <i class="pbmit-grevo-icon pbmit-grevo-icon-location"></i>
			   </span>						
			   <div class="pbmit-footer-contact-info-wrap">
				  <span class="pbmit-label">Our Location</span>
				  <span class="pbmit-desc">101 Avenue, S.E. USA</span>
			   </div>
			</div>
		 </div>
	  </div>
   </div>
</section>
<!-- footer Top End-->

<!-- footer -->
<footer class="footer site-footer">
   <div class="pbmit-footer-widget-area">
	  <div class="container">
		 <div class="row">
			<div class=" col-sm-12 col-md-6 col-lg-4">
			   <div class="pbmit-footer-widget">
				  <aside class=" pbmit-footer-news widget">
					 <div class="textwidget">
						<form class="">
						   <div class="mc4wp-form-fields">
							  <div class="pbmit-footer-newsletter">
								 <i aria-hidden="true" class="pbmit-industrey-icon pbmit-base-icon-mail-box"></i>
								 <h4>Sign up for Electric Car, news &amp; inslights</h4>
								 <div class="pbmit-footer-newsletter-form">
									<label>Email address</label>  
									<input type="email" name="EMAIL" placeholder="Email address" required="">
									<button type="submit" value="Sign up"><span>Subscribe</span></button> 
								 </div>
							  </div>
						   </div>
						</form>
					 </div>
				  </aside>
			   </div>
			</div>
			<div class=" col-sm-12 col-md-6 col-lg-3">
			   <div class="pbmit-footer-widget">
				  <aside class="widget">
					 <h2 class="widget-title">Grevo WP Theme</h2>
					 <div class="textwidget">
						<p>A leading developer of A-grade commercial, electric car and bike projects in USA. Since its foundation the company has doubled its turnover year on year, with its staff numbers.<br>
						   <a class="btn-arrow" href="#"><span>Get a quote</span></a>
						</p>
					 </div>
				  </aside>
			   </div>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-2">
			   <div class="pbmit-footer-widget ">
				  <aside class=" widget widget_nav_menu">
					 <h2 class="widget-title">Company info</h2>
					 <div class="menu-information-container">
						<ul id="menu-information" class="menu">
						   <li class="menu-item "> <a href="#">About Us</a> </li>
						   <li class="menu-item "> <a href="#">Our Projects</a> </li>
						   <li class="menu-item "> <a href="#">Meet Our Team</a> </li>
						   <li class="menu-item "> <a href="#">News &amp; Media</a> </li>
						   <li class="menu-item "> <a href="#">Contact Us</a> </li>
						   <li class="menu-item "> <a href="#">Careers</a> </li>
						</ul>
					 </div>
				  </aside>
			   </div>
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
			   <div class="pbmit-footer-widget">
				  <aside class="widget">
					 <h2 class="widget-title">Quick Contact</h2>
					 <div class="textwidget">
						<p>2307 Beverley Rd Brooklyn, New York 11226 United States.</p>
						<p>If you have any questions or need help, feel free to contact with our team.</p>
						<h3 class="footer-phone">(002) 01061245741</h3>
					 </div>
				  </aside>
			   </div>
			</div>
		 </div>
	  </div>
   </div>
   <div class="pbmit-footer-style-2 pbmit-footer-section pbmit-footer-text-area pbmit-bg-color-transparent">
	  <div class="container">
		 <div class="pbmit-footer-text-inner">
			<div class="row align-items-center">
			   <div class="col-md-5">
				  <div class="pbmit-footer-menu-area"> 
					 <div class="menu-quick-links-container"> 
						<ul class="pbmit-footer-menu"> 
						   <li class="menu-item">
							  <a href="#">Where to Find Us</a> 
						   </li>
						   <li class="menu-item"> 
							  <a href="#">Terms of Payment</a> 
						   </li>
						   <li class="menu-item">
							  <a href="#">Stats Element</a>
						   </li>
						</ul>
					 </div>
				  </div>
				  <div class="pbmit-footer-copyright-text-area"> Copyright © 2021
					 <a href="#">Grevo</a>, All Rights Reserved.
				  </div>
			   </div>
			   <div class="col-md-3">
				  <div class="pbmit-footer-logo-box">
					 <div class="pbmit-footer-logo">
						<img class="pbmit-footer-logo" src="<?= base_url('assets/images/footer-logo.svg')?>" alt="Grevo Demo1" />
					 </div>
				  </div>
			   </div>
			   <div class="col-md-4">
				  <div class=" pbmit-footer-menu-area pbmit-footer-copyright-text ">
					 <ul class="pbmit-social-links">
						<li class="pbmit-social-li pbmit-social-facebook ">
						   <a href="#">
							  <span>
								 <i class="pbmit-base-icon-facebook-squared"></i>
							  </span>
						   </a>
						</li>
						<li class="pbmit-social-li pbmit-social-twitter ">
						   <a href="#">
							  <span>
								 <i class="pbmit-base-icon-twitter"></i>
							  </span>
						   </a>
						</li>
						<li class="pbmit-social-li pbmit-social-youtube ">
						   <a href="#">
							  <span>
								 <i class="pbmit-base-icon-youtube-play"></i>
							  </span>
						   </a>
						</li>
						<li class="pbmit-social-li pbmit-social-linkedin ">
						   <a href="#">
							  <span>
								 <i class="pbmit-base-icon-linkedin-squared"></i>
							  </span>
						   </a>
						</li>
					 </ul>
				  </div>
			   </div>					    
			</div>							
		 </div>	
	  </div>
   </div>
</footer>
<!-- footer End -->

</div>
<!-- page wrapper End -->

<!-- Search Box Start Here -->
<div class="pbmit-search-overlay">
   <div class="pbmit-icon-close"></div>
	  <div class="pbmit-search-outer">
		 <div class="pbmit-search-logo"><img class="logo-img" alt="Grevo" src="<?= base_url('assets/images/logo-white.svg')?>"></div>
		 <form class="pbmit-site-searchform">
			<input type="search" class="form-control field searchform-s" name="s" placeholder="Type Word Then Press Enter">
			<button type="submit"><i class="pbmit-base-icon-search-1"></i></button>
		 </form>
	  </div>
</div>
<!-- Search Box End Here -->

<?php include(APPPATH . 'Views/include/footer.php')?>