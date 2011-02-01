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
		if(count($adminareas)<1)
		{
			return;
		}
		
		$level_name_text = "administrative area";
		$level_name = ORM::factory('adminareas_level_names')->where("level", $level)->find();
		if($level_name->loaded)
		{
			$level_name_text = $level_name->name;
		}
		
		
	
		// Load the View		
		$form = View::factory('locationhighlight/sub_admin_areas');
		$form->level_name_text = $level_name_text;
		$form->admin_areas = $adminareas;
		$form->parent_name = ORM::factory('adminareas')->where("id", $parent_id)->find()->name;
		$form->level = $level;
		$form->render(TRUE);
	}

	

}//end class
