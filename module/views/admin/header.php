<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<?php $last_update = time() - 60; ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php echo meta('viewport', 'width=device-width, initial-scale=1'); ?>
	<?php $this->output->set_header("HTTP/1.0 200 OK"); ?>
	<?php $this->output->set_header("HTTP/1.1 200 OK"); ?>
	<?php $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT'); ?>
	<?php $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
	<?php $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false); ?>
	<?php $this->output->set_header("Pragma: no-cache"); ?>
	<?php echo header('Content-Type: text/html; charset=UTF-8'); ?>
	<?php echo meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
	<?php echo meta('description', $description); ?>
	<?php echo meta('keywords', $description); ?>
	<?php echo meta('author', $author); ?>
	<?php echo meta('robots', 'noodp,noydir'); ?>
	<?php echo link_tag('themes/default/images/favicon.ico', 'shortcut icon', 'image/x-icon'); ?>
	<?php echo link_tag('themes/default/images/favicon.ico', 'icon', 'image/x-icon'); ?>
	<?php echo link_tag('themes/default/css/bootstrap.min.css'); ?>
	<?php echo link_tag('themes/default/css/admin.css'); ?>
	<?php echo link_tag('themes/default/css/bootstrap3-wysihtml5.min.css'); ?>
	<?php echo link_tag('themes/default/css/_all-skins.min.css'); ?>
	
	<?php echo link_tag('themes/default/css/ionicons.min.css'); ?>
	
	<?php echo link_tag('themes/default/css/hover.css'); ?>
	<?php echo link_tag('themes/default/css/select2.min.css'); ?>
	<?php echo link_tag('themes/default/css/daterangepicker.css'); ?>
	<?php echo link_tag('themes/default/css/font-awesome.min.css'); ?>
	<?php echo link_tag('themes/default/css/admin-rg.css'); ?>
	<?php
		if ( ! empty($css))
		{
			foreach($css as $stylesheet)
			{
				echo link_tag(themes_url('css/'.$stylesheet.".css"));
			}
		}
	?>
	<title><?php echo $title; ?></title>
	<script type="text/javascript">
		document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/, '');
	</script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo base_url('admin/dashboard'); ?>" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>RG</b>Com</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>RG Community</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
 				</a>
 				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
 						<!-- Messages: style can be found in dropdown.less-->
 						<?php  
 								/********UNREAD Message Count**********/
 								$qu = QModel::sfwa('message',array('rgto','is_read'),array($this->session->userdata('hashcrash'),'0'));
								$quc = QModel::c($qu);
						?>
 						<li class="dropdown messages-menu">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span class="label label-success"><?php echo $quc; ?></span>
							</a>
							<ul class="dropdown-menu">

								<?php
								/*********************MESSAGE FUNCTION******************/
									$mq = QModel::sfwa('message',array('rgto','is_delete'),array($this->session->userdata('hashcrash'),'0'),'date_sent ASC','8,0');
									$mc = QModel::c($mq);

									if( ! $mc):
								?>
								<li class="header">You have (<?php echo $mc; ?>) messages <span class="pull-right"><a href="<?php echo base_url('admin/message?c=message&f=new'); ?>">New message</a></span></li>

								<li>
 									<!-- inner menu: contains the actual data -->
	 								<ul class="menu">
										<li>
											<a href="javascript:void(0);">
												<p>No Message </p>
											</a>
										</li>
									
									</ul>
								</li>
								<?php else: ?>
									<li class="header">You have (<?php echo $mc; ?>) messages <span class="pull-right"><a href="<?php echo base_url('admin/message?c=message&f=new'); ?>">New message</a></span></li>

									<li>
	 									<!-- inner menu: contains the actual data -->
		 								<ul class="menu">
											<?php
												foreach (QModel::g($mq, TRUE) as $g):
													$rgfrom = $g['rgfrom'];
													$message = $g['message'];
													$date_sent = $g['date_sent'];
													$is_read = $g['is_read'];

													$res = $this->wmodel->getInformation($rgfrom);
				
													$from = $res->firstname.', '.$res->lastname.' - '.$res->vest_no;

													if (strlen($message) > 40) 
													{
														// truncate string
														
														// make sure it ends in a word so assassinate doesn't become ass...
														$message_post = substr($website, 0, 40).'...'; 
													}
													else
													{
														$message_post = $message;
													}
											?>
											<li>
												<a href="javascript:void(0);">
													<div class="pull-left">
														<img src="<?php echo themes_url('images/profile/rgview.jpg'); ?>" class="img-circle" alt="User Image">
	 												</div>
	 												<h4>
														<?php echo $from; ?>
														<?php /*<small><i class="fa fa-clock-o"></i> 2 days</small>*/ ?>
	 												</h4>
													<p><?php echo $message_post; ?></p>
												</a>
											</li>
										
										</ul>
									</li>
								<?php endforeach; endif; ?>
								<?php if($mc > 8): ?>
									<li class="footer"><a href="javascript:void(0);">See All Messages</a></li>
								<?php endif; ?>
							</ul>
 						</li>
 						<!-- Notifications: style can be found in dropdown.less -->
						<li class="dropdown notifications-menu">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">10</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 10 notifications</li>
								<li>
									<!-- inner menu: contains the actual data -->
									<ul class="menu">
										<li>
											<a href="javascript:void(0);">
												<i class="fa fa-users text-aqua"></i> 5 new members joined today
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
 												<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
 												page and may cause design problems
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
												<i class="fa fa-users text-red"></i> 5 new members joined
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
												<i class="fa fa-shopping-cart text-green"></i> 25 sales made
											</a>
										</li>
										<li>
											<a href="javascript:void(0);">
												<i class="fa fa-user text-red"></i> You changed your username
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="javascript:void(0);">View all</a></li>
							</ul>
						</li>
						<!-- Tasks: style can be found in dropdown.less -->
						<?php /*<li class="dropdown tasks-menu">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-flag-o"></i>
								<span class="label label-danger">9</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 9 tasks</li>
								<li>
								<!-- inner menu: contains the actual data -->
									<ul class="menu">
										<li><!-- Task item -->
											<a href="javascript:void(0);">
												<h3>
													Design some buttons
													<small class="pull-right">20%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">20% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
										<li><!-- Task item -->
											<a href="javascript:void(0);">
												<h3>
													Create a nice theme
													<small class="pull-right">40%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">40% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
										<li><!-- Task item -->
											<a href="javascript:void(0);">
												<h3>
													Some task I need to do
													<small class="pull-right">60%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">60% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
										<li><!-- Task item -->
											<a href="javascript:void(0);">
												<h3>
													Make beautiful transitions
													<small class="pull-right">80%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">80% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
									</ul>
								</li>
								<li class="footer">
									<a href="javascript:void(0);">View all tasks</a>
								</li>
							</ul>
						</li>*/ ?>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo themes_url('images/profile/rgview.jpg'); ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo isset($username) ? $username : 'RG - Admin(3618)'; ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?php echo themes_url('images/profile/rgview.jpg'); ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo isset($username) ? $username : 'RG - Admin(3618)'; ?> - Web Developer
										<small>Member since Nov. 2012</small>
									</p>
								</li>
								<!-- Menu Body -->
								<?php /*<li class="user-body">
									<div class="row">
										<div class="col-xs-4 text-center">
											<a href="javascript:void(0);">Followers</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="javascript:void(0);">Sales</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="javascript:void(0);">Friends</a>
										</div>
									</div>
									<!-- /.row -->
								</li>*/ ?>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="javascript:void(0);" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="<?php echo base_url('admin/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
						<!-- Control Sidebar Toggle Button -->
					</ul>
				</div>
			</nav>
		</header>
