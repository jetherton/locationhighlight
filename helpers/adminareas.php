<?php
/**
 * Admin Areas helper
 * 
 * @package    Admin Map
 * @author     John Etherton
 */
class adminareas_Core {


	public static function get_admin_areas_for_dropdown($parent_id = NULL)
	{
		$adminareas = ORM::factory("adminareas")
			->orderby('name')
			->where('parent_id', $parent_id)
			->find_all();
		
		$dropdown = array();
		foreach($adminareas as $adminarea)
		{
			$dropdown[$adminarea->id."|".$adminarea->file] = $adminarea->name;
		}
		return $dropdown;

	}
	
	
	public static function get_admin_area_kml($key)
	{
	}
	

}//end class locationhighlight_core



