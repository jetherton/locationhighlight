<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller is used to add/ remove admin areas for the Location Hightlight plugin
 *
 */


class LocationHighlight_Controller extends Controller
{




	function get_admin_areas($parent_id, $level)
	{
		$this->auto_render = FALSE;

		//get admin areas and see if there are any
		$adminareas = adminareas::get_admin_areas_for_dropdown($parent_id);
		$adminareas_count = count($adminareas);
		$level_name_text = "administrative area"; 
		if(count($adminareas)>0)
		{
		
		
			$level_name = ORM::factory('adminareas_level_names')->where("level", $level)->find();
			if($level_name->loaded)
			{
				$level_name_text = $level_name->name;
			}
		}
		
		//see if there are any cities
		$cities = ORM::factory("location_highlight_cities")
			->where("adminarea_id", $parent_id)
			->orderby('name', 'asc')
			->find_all();
		$cities_a = array();
		foreach($cities as $city)
		{
			$cities_a[$city->latitude."|".$city->longitude] = $city->name;
		}
	
		// Load the View		
		$form = View::factory('locationhighlight/sub_admin_areas');
		$form->adminareas_count = $adminareas_count;
		$form->level_name_text = $level_name_text;
		$form->cities = $cities_a;
		$form->admin_areas = $adminareas;
		$form->parent_name = ORM::factory('adminareas')->where("id", $parent_id)->find()->name;
		$form->level = $level;
		$form->render(TRUE);
	}

	

}//end class
