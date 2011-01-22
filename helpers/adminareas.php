<?php
/**
 * Admin Areas helper
 * 
 * @package    Admin Map
 * @author     John Etherton
 */
class adminareas_Core {


	public static function get_admin_areas_for_dropdown()
	{
		$adminareas = ORM::factory("adminareas")
			->orderby('name')
			->find_all();
		
		$dropdown = array();
		foreach($adminareas as $adminarea)
		{
			$dropdown[url::base().Kohana::config('upload.relative_directory').'/'.$adminarea->file] = $adminarea->name;
		}
		return $dropdown;

	}
	
	
	public static function get_admin_area_kml($key)
	{
	}
	

}//end class locationhighlight_core



