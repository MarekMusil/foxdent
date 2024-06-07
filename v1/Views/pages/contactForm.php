
<div class="page-content">   
   <section class="contact-section-bg">
      <div class="container-fluid ">
         <div class="row">                       
            <div class="col-lg-6 col-md-12 col-sm-12 pbmit-bg-color-global">
               <div class="text-left">
                  <div class="pbmit-heading-subheading text-left">
                     <h4 class="pbmit-subtitle">Get in touch </h4>
                     <h2 class="pbmit-title text-white">Send Message Us</h2>
                     <p class="text-white">Just send us your questions or concerns to <br/> starting a new project.</p>
                  </div>
                  <div class="pbmit-ihbox pbmit-ihbox-style-11">
                     <div class="pbmit-ihbox-box d-flex align-items-center mb-4">
                        <div class="pbmit-ihbox-icon">
                           <div class="pbmit-ihbox-icon-wrapper pbmit-ihbox-icon-type-image">
                              <img src="<?= base_url('assets/images/img-07.png')?>" alt="Have a Question?" />
                           </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                           <h2 class="pbmit-element-title"> Have a Question?</h2>
                           <h4 class="pbmit-element-heading text-white">+888 445 55 678 &amp; 89</h4>
                        </div>
                     </div>
                     <div class="widget-container text-white">
                        Monday – Friday 9.00 – 6.00<br>
                        Sunday &amp; Public Holidays (Closed)
                     </div>
                     <div class="button-wrapper">
                        <a href="#" class="button-link">
                           <span class="button-content-wrapper">
                              <span class="button-text">Request a call back</span>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>                         
            </div>                        
            <div class="col-lg-6 col-md-12 pbmit-bg-color-light">
               <form class="contact-form"  method="post" action="<?= base_url('forms/contact'); ?>">
                  <div class="row mb-3 g-3">

                  <?php if (session()->getFlashdata('success')) : ?>
                     <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('success') ?>
                     </div>
                  <?php endif ?>

                  <?php if (session()->getFlashdata('errors')) : ?>
                     <div class="alert alert-danger" role="alert">
                        <ul>
                              <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                 <li><?= $error ?></li>
                              <?php endforeach ?>
                        </ul>
                     </div>
                  <?php endif ?>
                  
                     <input type="text" name="redirectUrl" value="<?= isset($redirectUrl) ? $redirectUrl : '/' ?>" hidden>
                     <div class="col-lg-12 col-md-12">
                        <input required type="text" class="form-control" placeholder="Name" name="contactName">
                     </div>
                     <div class="col-lg-6 col-md-6">
                        <input required type="email" class="form-control" placeholder="Email Address" name="contactEmail">
                     </div>
                     <div class="col-lg-6 col-md-6">
                        <input required type="text" class="form-control" placeholder="Phone" name="contactPhone">
                     </div>
                     <div class="col-lg-12 col-sm-12">
                        <textarea required class="form-control" name="contactMessage" rows="4" placeholder="Message Write Here"></textarea>
                     </div>
                     <div class="col-lg-12 col-sm-12">
                     <button type="submit" class="pbmit-btn pbmit-btn-secondary pbmit-btn-hover-global">
                           <span>Send Message</span>
                     </button>
                     </div>
                  </div>
               </form>  
            </div>
         </div>
      </div>
   </section>
</div>
        