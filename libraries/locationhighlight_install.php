<?php
/**
 * File Upload - Install
 *
 * @author	   John Etherton
 * @package	   File Upload
 */

class Locationhighlight_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = Database::instance();
	}

	/**
	 * Creates the required database tables for the actionable plugin
	 */
	public function run_install()
	{
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'adminareas` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(10) unsigned DEFAULT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  `file` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
				
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'adminareas_level_names` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `level` int(10) unsigned NOT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		
		
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'location_highlight_cities` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `adminarea_id` int(10) DEFAULT NULL,
			  `latitude` double NOT NULL DEFAULT \'0\',
  			  `longitude` double NOT NULL DEFAULT \'0\',
			  `name` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
	}

	/**
	 * Deletes the database tables for the actionable module
	 */
	public function uninstall()
	{
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'adminareas`');
	}

}