<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
if (!function_exists('getmenu')) {
	function getmenu($level)
	{
		$menus = array();
		switch ($level):
			case 'admin':
				$menus = array();
				break;
			case 'dosen':
				$menus = array(
					(object)array('name' => 'Bimbingan',
						'icon' => 'collection',
						'color' => 'pink',
						'href' => site_url('bimbingan')),
					(object)array('name' => 'Seminar',
						'icon' => 'calendar-grid-58',
						'color' => 'green',
						'href' => site_url('sidang')),
					(object)array('name' => 'Peserta Seminar',
						'icon' => 'building',
						'color' => 'orange',
						'href' => site_url('seminarpeserta'))
				);
				break;
			case 'mahasiswa':
				$menus = array(
					(object)array('name' => 'Magang',
						'icon' => 'building',
						'color' => 'orange',
						'href' => site_url('magang')),
					(object)array('name' => 'Bimbingan',
						'icon' => 'collection',
						'color' => 'pink',
						'href' => site_url('bimbingan?m=konsultasi')),
					(object)array('name' => 'Sidang',
						'icon' => 'calendar-grid-58',
						'color' => 'green',
						'href' => site_url('sidang')),
					(object)array('name' => 'Kelengkapan berkas',
						'icon' => 'book-bookmark',
						'color' => 'info',
						'href' => site_url('kelengkapan'))
				);
				break;
			case 'peserta':
				$menus = array(
					(object)array('name' => 'Jadwal Seminar',
						'icon' => 'calendar-grid-58',
						'color' => 'green',
						'href' => site_url('seminarpeserta')),
				);
				break;
			default:
				break;
		endswitch;
		return $menus;
	}
}
