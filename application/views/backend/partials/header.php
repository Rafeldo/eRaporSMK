<?php
$uri = $this->uri->segment_array();
$settings = Setting::first();
$title = $settings->site_title;
$version = $settings->version;
$sekolah = Datasekolah::first();
$templates = array(
	1	=> array('key' => 'blue', 'value' => 'Blue'),
	2	=> array('key' => 'blue-light', 'value' => 'Blue Light'),
	3	=> array('key' => 'black', 'value' => 'Black'),
	4	=> array('key' => 'black-light', 'value' => 'Black Light'),
	5 	=> array('key' => 'green', 'value' => 'Green'),
	6	=> array('key' => 'green-light', 'value' => 'Green Light'),
	7	=> array('key' => 'purple', 'value' => 'Purple'),
	8	=> array('key' => 'purple-light', 'value' => 'Purple Light'),
	9	=> array('key' => 'red', 'value' => 'Red'),
	10	=> array('key' => 'red-light', 'value' => 'Red Light'),
	11	=> array('key' => 'yellow', 'value' => 'Yellow'),
	12	=> array('key' => 'yellow-light', 'value' => 'Yellow Light'),
	);
$user = $this->ion_auth->user()->row();
?>
<style>
.box.box-info{min-height:580px;}
</style>
<div class="noty"></div>
<header class="main-header">
<?php //echo anchor(base_url(), $title. ' <sub>v.1.0.0</sub>', "class='logo'");  ?>
<!-- Logo -->
<a href="<?php echo site_url(); ?>" class="logo">
	<!-- mini logo for sidebar mini 50x50 pixels -->
	<span class="logo-mini"><b><?php echo $title; ?></b></span>
	<!-- logo for regular state and mobile devices -->
	<span class="logo-lg"><b><?php echo $title; ?></b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
	  <div class="navbar-left">
		<?php echo (isset($sekolah) && $sekolah->nama != '') ? anchor(base_url(), $sekolah->nama, "class='logo_sekolah logo'") : '';  ?>
	</div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="templates">Tema <span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="templates">
				<?php foreach($templates as $template){ ?>
					<li><a tabindex="-1" href="<?php echo site_url('admin/dashboard/skin').'/'.$template['key']; ?>"><?php echo $template['value']; ?></a></li>
				<?php } ?>
				</ul>
			</li>
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php $img = ($user->photo!= '')  ? site_url(PROFILEPHOTOSTHUMBS.$user->photo) : site_url('assets/img/avatar3.png'); ?>
                <img src="<?php echo $img;?>" class="user-image" alt="User Image" />
              <span class="hidden-xs"><?php echo $user->username; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
				<?php $img = ($user->photo!= '')  ? site_url(PROFILEPHOTOSTHUMBS.$user->photo) : site_url('assets/img/avatar3.png'); ?>
                <img src="<?php echo $img;?>" class="user-circle" alt="User Image" />
                <p><?php echo $user->username; ?></p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/profil/user'); ?>" class="btn btn-default btn-flat">Profil</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('admin/auth/logout'); ?>" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>