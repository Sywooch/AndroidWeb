<?php
$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;

$path = Yii::$app->request->baseUrl;

?>
<div class="container animated fadeIn" style="background-color: #f7f7f7;">

  <div class="row">
    <h1 class="header-title"><b>Contact Us</b></h1>
     <div class="container second-portion">
	<div class="row">
        <!-- Boxes de Acoes -->
    	<div class="col-xs-12 col-sm-6 col-lg-3">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-envelope" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">MAIL & WEBSITE</h3>
						<p>
							<i class="fa fa-envelope" aria-hidden="true"></i> &nbsp <b>info@autokartz.com</b>
							<br>
							<br>
						</p>
					
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-3">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-mobile" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">CONTACT</h3>
    					<p>
							<i class="fa fa-mobile" aria-hidden="true"></i> &nbsp <b>(+91)-97079 97079</b>
							<br>
							<br>
							<i class="fa fa-mobile" aria-hidden="true"></i> &nbsp  <b>(+91)-8527467283</b>
						</p>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-3">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">ADDRESS</h3>
    					<p>
							 <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp <b>AutoKartz Pvt. Ltd., NWA 35, Punjabi Bagh West ;New Delhi.</b>
						</p>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>	

		 <div class="col-xs-12 col-sm-6 col-lg-3">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-comments" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">LIVE CHAT</h3>
    					<p>
							 <i class="fa fa-comments-o" aria-hidden="true"></i> &nbsp <b>Monday-Friday:8A.M. to 8P.M.<br>Saturday:8A.M. to 5:30P.M.</b>
						</p>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>		    
		<!-- /Boxes de Acoes -->
		
		<!--My Portfolio  dont Copy this -->
	    
	</div>
	<hr>
</div>
    <div class="col-sm-12" id="parent">
    	<div class="col-sm-6">
    	<iframe width="100%" height="320px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3500.767759942609!2d77.12181691468115!3d28.666671682404274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d0f33d1094d25%3A0x610b1d225aaa4275!2sAutoKartz.com!5e0!3m2!1sen!2sin!4v1519794758020" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    	</div>

    	<div class="col-sm-6">
    		<form action="form.php" class="contact-form" method="post">
	
		        <div class="form-group">
		          <input type="text" class="form-control" id="name" name="nm" placeholder="Name" required="" autofocus="">
		        </div>
		    
		    
		        <div class="form-group form_left">
		          <input type="email" class="form-control" id="email" name="em" placeholder="Email" required="">
		        </div>
		    
		      <div class="form-group">
		           <input type="text" class="form-control" id="phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Mobile No." required="">
		      </div>
		      <div class="form-group">
		      <textarea class="form-control textarea-contact" rows="5" id="comment" name="FB" placeholder="Type Your Message/Feedback here..." required=""></textarea>
		      <br>
	      	  <button class="btn btn-default btn-send"> <span class="glyphicon glyphicon-send"></span> Send </button>
		      </div>
     		</form>
    	</div>
    </div>
  </div>

</div>
<br>