<!DOCTYPE html>
<html>

	<head>

		<title>Hashkit</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  	<?php 
	  	
	  		echo $this->Html->script('jquery-2.1.0.js');
	  		echo $this->Html->script('bootstrap.js');

			echo $this->Html->css(array('bootstrap','styles'));
			echo $this->fetch('script');
			echo $this->fetch('meta');
			echo $this->fetch('css');

	  	?>

	</head>

	<body>
		<div class = "navbar navbar-inverse navbar-fixed-top ">
			<div class = "container">
				<a href = "/" class = "navbar-brand">Hashkit</a>
				<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>

				</button>
				<div class="collapse navbar-collapse navHeaderCollapse">
					
					<ul class="nav navbar-nav navbar-left">
						
						<li><a href="/">Home</a></li>
						<?php  if($authUser['group_id'] == 1) :?>
						<li class="dropdown">
								
							<a href="/" class="dropdown-toggle" data-toggle="dropdown">Admin tools<b class="caret"></b></a>

								<ul class="dropdown-menu">

									<li><a href="/Users/">List Users</a></li>
									<li><a href="/Users/admin_add">Add Users</a></li>
								</ul>
						</li>
						<?php endif;?>
						<?php if($authUser):?>						
						<li class="dropdown">
								
							<a href="" class="dropdown-toggle" data-toggle="dropdown">Hash Functions<b class="caret"></b></a>

								<ul class="dropdown-menu">
									<li><a href="/HashTests/basic_hashing">Hash generator</a></li>
									<li><a href="/HashTests/compute_and_compare">Hash algorithm recommendation</a></li>
									<li><a href="/HashTests/hash_analyser">Message digest analyser</a></li>
									<li><a href="/HashTests/calculate_probability_of_collision">Collision probability calculator</a></li>
									<li><a href="/HashTests/birthday_attack">Collision generator</a></li>
									<li><a href="/HashTests/reverse_look_up">Reverse look-up</a></li>
									<li><a href="/HashTests/avalanche_effect">Avalanche effect</a></li>
								</ul>

						</li>
						<li><a href="/Pages/hash_information">Hash Information</a></li>
						<li><a href="/Questionnaires/questionnaire">Questionnaire</a></li>
						<?php endif;?>
						<li><a href="/Pages/about_us">About Us</a></li>
						<li><a href="/contact_us">Contact Us</a></li>

					</ul>

					<ul class = "nav navbar-nav navbar-right">

						<?php if($authUser):?>

						<li style="float:right;"><a href="/Users/Logout">Logout</a></li>
						<li><a href="/Users/view_my_own_profile"><?php echo $authUser['name'];?></a></li>
						
						<?php endif;?>
						
						<?php if(!$authUser):?>

						<li><a href="/Users/Login">Login</a></li>
						<li><a href="/Users/Register">Register</a></li> 
						
						<?php endif;?>

					</ul>

				</div>

			</div>

		</div>

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>

		<div class="navbar navbar-default navbar-fixed-bottom">
			
			<div class="container">
				
				<p class="navbar-text pull-left">Site Built by Hashkit Team @2014</p>

				<a class="navbar-text btn btn-danger pull-right" href="http://hashkitproject.blogspot.sg/"><font style="color:#FFFFFF">Visit our blog!</font></a>

			</div>

		</div>
	</body>

	<script type="text/javascript">
		$(document).ready(function () {
        $('a[href="' + this.location.pathname + '"]').parent().addClass('active');
    });
	</script>
</html>
