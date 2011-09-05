<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title_for_layout; ?></title>
	<meta property="og:title" content="Consumer Love" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://consumerlove.org" />
	<meta property="og:image" content="" />
	<meta property="og:site_name" content="Consumer Love" />
	<meta property="fb:admins" content="505549054" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->script(array(
		'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
		'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js',
		'global'
	));
	echo $this->Html->css(array(
		'http://fonts.googleapis.com/css?family=Copse|Corben:700&v2',
		'style'
	));

	echo $scripts_for_layout;
	echo $this->element('external/google_analytics');
?>
</head>
<body>
<div id="user-bar">
<div class="container">
	<a href="/" id="site-title">Consumer Love <span class="heart"> &hearts;</span></a>
	<?php if(!isset($disableSidebar)) echo $this->element('search');?>
	<div id="user">
		<?php if(isset($userData)): ?>
		<a class="nav-toggle"><?php echo $userData['username'];?><span class="nav-triangle">&#9662;</span></a>
		<?php else: ?>
		<span class="guest">
			<?php echo $this->Html->link('Register', array('plugin' => null, 'controller' => 'users', 'action' => 'signup')); ?> or
			<?php echo $this->Html->link('Login', array('plugin' => null, 'controller' => 'users', 'action' => 'login')); ?> to participate!
		</span>
		<?php endif; ?>
	</div>
</div></div>
<nav>
	<div class="container">
		<ul id="menu"<?php echo isset($hideNav) ? ' style="display: none;' : ' class="show"';?>>
			<li><?php echo $this->Html->link('Todays Activity', '/');?></li>
			<li><?php echo $this->Html->link('Browse Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => false, 'plugin' => false, 'escape' => false)); ?></li>
			<?php if(isset($userData)): ?>
			<li><?php echo $this->Link->user($userData, 'Your Profile'); ?></li>
			<li><?php echo $this->Link->inventory($userData, 'Your Inventory'); ?></li>
			<li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
			<?php endif; ?>
		</ul>
	</div>
</nav>
<div id="main" role="main">
<div class="container<?php echo isset($pageClass) ? ' '.$pageClass: '';?>">
	<div id="content" class="<?php echo isset($disableSidebar) ? 'no-sidebar' : ''; ?>">
		<?php if(!empty($this->Html->_crumbs)): ?>
		<div id="breadcrumbs">
			<?php echo $this->Html->getCrumbs(' > ','Consumer Love');?>
		</div>
		<?php endif;?>
		<?php echo $content_for_layout; ?>
	</div>
	<?php if(!isset($disableSidebar)): ?>
	<div id="side">
		<?php
		// Setup Widgets
		if(isset($userData)) {
			if($userData['is_admin'] == true) {
				$pageWidgets['admin'] =  false;
			}
		} else {
			array_unshift($pageWidgets, 'guest_welcome');
		}
		foreach($pageWidgets as $widget => $vars):
			if(is_int($widget)) $widget = $vars;?>
		<div class="widget <?php echo $widget;?>">
		<?php echo $this->element('widgets/'.$widget, (array) $vars);?>
		</div>
	<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div></div>
<footer>
	<div id="footer-links-wrapper">
		<ul id="footer-links">
			<li class="first">Popular Categories
				<ul class="sub">
					<li>nothing</li>
				</ul>
			</li>
			<li>Trending Today
				<ul class="sub">
					<li>nada</li>
				</ul>
			</li></li>
			<li>Hot Forum Topics
				<ul class="sub">
					<li>diddly-squat</li>
				</ul>
			</li></li>
			<li class="last">Latest Posts
				<ul class="sub">
					<li>not a lot</li>
				</ul>
			</li></li>
		</ul>
	</div>
	<p>Copyright &copy; 2011 consumerlove.org</p>
</footer>
<?php if(!isset($userData)): ?>
<div id="register-login" title="You must Login or Register to participate">
	<div>
		<h3>Create a new account</h3>
		<p class="footnote">Sign up in 1 minute flat!</p>
		<?php echo $this->element('forms/signup');?>
	</div>
	<div>
		<h3>Login</h3>
		<p class="footnote">Login to your existing account.</p>
		<?php echo $this->element('forms/login'); ?>
	</div>
</div>
<?php endif; ?>
<div id="flashses" style="display: none;">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Session->flash('auth');?>
</div>
<?php echo $this->Js->writeBuffer(); ?>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>