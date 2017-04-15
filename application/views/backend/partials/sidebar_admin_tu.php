<?php
$settings 	= Setting::first();
$loggeduser = $this->ion_auth->user()->row();
$cari_rombel = Datarombel::find_by_guru_id($loggeduser->data_guru_id);
$uri = $this->uri->segment_array();
$user = $this->ion_auth->user()->row();
?>
<aside class="main-sidebar">              
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php $img = ($user->photo!= '')  ? site_url(PROFILEPHOTOSTHUMBS.$user->photo) : site_url('assets/img/avatar3.png'); ?>
                <img src="<?php echo $img;?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Halo, <?php echo $user->username; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
			<li class="header">KONTROL NAVIGASI UTAMA</li>
            <li class="treeview <?php echo (isset($activemenu) && $activemenu == 'dashboard') ?  'active' : ''; ?>">
                <a href="<?php echo site_url('admin/dashboard'); ?>">
                    <i class="fa fa-dashboard"></i> <span>Beranda</span>
                </a>
            </li>
			<?php if($settings->sinkronisasi == 1){?>
			<!--li class="treeview <?php echo (isset($activemenu) && $activemenu == 'sinkronisasi') ?  'active' : ''; ?>">
                <a href="<?php echo site_url('admin/sinkronisasi'); ?>">
                    <i class="fa fa-refresh"></i> <span>Sinkronisasi</span>
                </a>
            </li-->
			<?php } ?>
			<li class="treeview <?php echo (isset($activemenu) && $activemenu == 'config') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Konfigurasi</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'config' && isset($uri[3]) && $uri[3] == 'general') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/config/general'); ?>">
                	    <i class="fa fa-exchange"></i> <span>Konfigurasi Umum</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'config' && isset($uri[3]) && $uri[3] == 'backup') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/config/backup'); ?>">
                	    <i class="fa fa-exchange"></i> <span>Backup &amp; Restore</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'config' && isset($uri[3]) && $uri[3] == 'users' || 
					isset($uri[3]) && $uri[3] == 'edit') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/config/users'); ?>">
                	    <i class="fa fa-user"></i> <span>Hak Akses Pengguna</span>
		                </a>
        		    </li>
					<?php
					$data_siswa = Datasiswa::find('all', array('conditions' => "data_rombel_id != 0"));
					$ajaran = get_ta();
					foreach($data_siswa as $siswa){
						$anggota = Anggotarombel::find_by_ajaran_id_and_rombel_id_and_siswa_id($ajaran->id, $siswa->data_rombel_id, $siswa->id);
						if($anggota){ ?>
						<!--li>kosong</li-->
						<?php break;
						} else { ?>
						<li<?php echo (isset($activemenu) && $activemenu == 'config' && isset($uri[3]) && $uri[3] == 'generate_anggota_rombel' || 
					isset($uri[3]) && $uri[3] == 'edit') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/config/generate_anggota_rombel'); ?>">
                	    <i class="fa fa-user"></i> <span>Generate Anggota Rombel</span>
		                </a>
        		    </li>
						<?php
						break;
						}
					}
					?>
				</ul>
			</li>
			<li class="treeview <?php echo (isset($activemenu) && $activemenu == 'referensi') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-list"></i> <span>Referensi</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && isset($uri[2]) && $uri[2] == 'siswa') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/siswa'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Siswa</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && isset($uri[2]) && $uri[2] == 'guru') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/guru'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Guru</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && isset($uri[2]) && $uri[2] == 'rombel') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/rombel'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Rombel</span>
		                </a>
        		    </li>
					<!--li<?php echo (isset($activemenu) && $activemenu == 'referensi' && 
					isset($uri[3]) && $uri[3] == 'kurikulum' 
						|| 
					isset($uri[3]) && $uri[3] == 'add_kurikulum' 
						|| 
					isset($uri[3]) && $uri[3] == 'edit_kurikulum'
					) ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/kurikulum'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Pengampu</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && 
					isset($uri[3]) && $uri[3] == 'kkm' 
					|| 
					isset($uri[3]) && $uri[3] == 'add_kkm' 
					|| 
					isset($uri[3]) && $uri[3] == 'edit_kkm'
					) ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/kkm'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi KB (KKM)</span>
		                </a>
        		    </li-->
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && isset($uri[3]) && $uri[3] == 'kd') ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/kd'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Kompetensi Dasar</span>
		                </a>
        		    </li>
					<!--li<?php echo (isset($activemenu) && $activemenu == 'referensi' && 
					isset($uri[3]) && $uri[3] == 'mulok' 
					|| 
					isset($uri[3]) && $uri[3] == 'add_mulok' 
					|| 
					isset($uri[3]) && $uri[3] == 'edit_mulok'
					) ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/mulok'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Muatan Lokal</span>
		                </a>
        		    </li-->
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && 
					isset($uri[3]) && $uri[3] == 'ekskul' 
					|| 
					isset($uri[3]) && $uri[3] == 'add_ekskul' 
					|| 
					isset($uri[3]) && $uri[3] == 'edit_ekskul'
					) ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/ekskul'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Ekstrakurikuler</span>
		                </a>
        		    </li>
					<li<?php echo (isset($activemenu) && $activemenu == 'referensi' && 
					isset($uri[3]) && $uri[3] == 'metode' 
					|| 
					isset($uri[3]) && $uri[3] == 'add_metode' 
					|| 
					isset($uri[3]) && $uri[3] == 'edit_metode'
					) ?  ' class="active"' : ''; ?>>
        		        <a href="<?php echo site_url('admin/referensi/metode'); ?>">
                	    <i class="fa fa-hand-o-right"></i> <span>Referensi Teknik Penilaian</span>
		                </a>
        		    </li>
				</ul>
			</li>
            <!--li class="treeview <?php echo (isset($activemenu) && $activemenu == 'perencanaan') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-check-square-o"></i> <span>Perencanaan</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'perencanaan' && isset($uri[3]) && $uri[3] == 'pengetahuan' || 
					isset($uri[3]) && $uri[3] == 'add_pengetahuan' || 
					isset($uri[4]) && $uri[4] == '1')  ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/perencanaan/pengetahuan'); ?>"><i class="fa fa-hand-o-right"></i> <span>Penilaian Pengetahuan</span></a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'perencanaan' && 
					isset($uri[3]) && $uri[3] == 'keterampilan'  || 
					isset($uri[3]) && $uri[3] == 'add_keterampilan' || 
					isset($uri[4]) && $uri[4] == '2') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/perencanaan/keterampilan'); ?>"><i class="fa fa-hand-o-right"></i> <span>Penilaian Keterampilan</span></a>
					</li>
				</ul>
			</li-->
			<!--li class="treeview <?php echo (isset($activemenu) && $activemenu == 'penilaian') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Penilaian</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'sikap') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/sikap'); ?>"><i class="fa fa-hand-o-right"></i> Jurnal Sikap</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'pengetahuan') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/pengetahuan'); ?>"><i class="fa fa-hand-o-right"></i> Penilaian Pengetahuan</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'keterampilan') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/keterampilan'); ?>"><i class="fa fa-hand-o-right"></i> Penilaian Keterampilan</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'portofolio') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/portofolio'); ?>"><i class="fa fa-hand-o-right"></i> Portofolio</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'mulok') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/mulok'); ?>"><i class="fa fa-hand-o-right"></i> Penilaian Mulok</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'penilaian' && isset($uri[3]) && $uri[3] == 'deskripsi_mapel') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/asesmen/deskripsi_mapel'); ?>"><i class="fa fa-hand-o-right"></i> Deskripsi Per Mapel</a>
					</li>
				</ul>
			</li-->
			<!--li class="treeview <?php echo (isset($activemenu) && $activemenu == 'laporan') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-copy"></i> <span>Laporan Hasil Belajar</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) ||
					isset($uri[3]) && $uri[3] == 'catatan_wali_kelas' || 
					isset($uri[3]) && $uri[3] == 'add_deskripsi_antar_mapel') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/catatan_wali_kelas'); ?>"><i class="fa fa-hand-o-right"></i> Catatan Wali Kelas</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'absensi') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/absensi'); ?>"><i class="fa fa-hand-o-right"></i> Absensi</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'ekstrakurikuler') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/ekstrakurikuler'); ?>"><i class="fa fa-hand-o-right"></i> Ekstrakurikuler</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'prakerin') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/prakerin'); ?>"><i class="fa fa-hand-o-right"></i> Praktik Kerja Lapangan</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'prestasi') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/prestasi'); ?>"><i class="fa fa-hand-o-right"></i> Prestasi Siswa</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'rapor') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/rapor'); ?>"><i class="fa fa-hand-o-right"></i> Cetak Rapor</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'laporan' && isset($uri[3]) && $uri[3] == 'legger') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/laporan/legger'); ?>"><i class="fa fa-hand-o-right"></i> Cetak Legger</a>
					</li>
				</ul>
			</li-->
			<!--li class="treeview <?php echo (isset($activemenu) && $activemenu == 'monitoring') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-eye"></i> <span>Monitoring Dan Analisis</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					
					<li<?php echo (isset($activemenu) && $activemenu == 'monitoring' && isset($uri[3]) && $uri[3] == 'prestasi') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/monitoring/prestasi'); ?>"><i class="fa fa-hand-o-right"></i> <span>Prestasi Individu Siswa</span></a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'monitoring' && isset($uri[3]) && $uri[3] == 'analisis') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/monitoring/analisis'); ?>"><i class="fa fa-hand-o-right"></i> Analisis Hasil Penilaian</a>
					</li>
				</ul>
			</li-->
			<li class="treeview <?php echo (isset($activemenu) && $activemenu == 'profil') ?  'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Profil</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
					<li<?php echo (isset($activemenu) && $activemenu == 'profil' && isset($uri[3]) && $uri[3] == 'sekolah') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/profil/sekolah'); ?>"><i class="fa fa-hand-o-right"></i> Profil Sekolah</a>
					</li>
					<li<?php echo (isset($activemenu) && $activemenu == 'profil' && isset($uri[3]) && $uri[3] == 'user') ?  ' class="active"' : ''; ?>>
						<a href="<?php echo site_url('admin/profil/user'); ?>"><i class="fa fa-hand-o-right"></i> Profil User</a>
					</li>
                </ul>
            </li>
			<li class="treeview <?php echo (isset($activemenu) && $activemenu == 'dashboard') ?  'active' : ''; ?>">
                <a href="<?php echo site_url('admin/auth/logout'); ?>">
                    <i class="fa fa-power-off"></i> <span>Keluar dari Aplikasi</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>