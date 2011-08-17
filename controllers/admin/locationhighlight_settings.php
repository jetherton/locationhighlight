<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller is used to add/ remove admin areas for the Location Hightlight plugin
 *
 */


class LocationHighlight_settings_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'manage';

		// If user doesn't have access, redirect to dashboard
		if ( ! admin::permissions($this->user, "manage"))
		{
			url::redirect(url::site().'admin/dashboard');
		}
	}

	/*
	Add Edit Layers (KML, KMZ, GeoRSS)
	*/
	function index()
	{
		$this->template->content = new View('locationhighlight/settings');
		$this->template->content->title = Kohana::lang('ui_admin.layers');

		// setup and initialize form field names
		$form = array
		(
			'action' => '',
			'adminarea_id'		=> '',
			'name'	  => '',
			'file'  => '',
		);

		// copy the form as errors, so the errors will be stored with keys corresponding to the form field names
		$errors = $form;
		$form_error = FALSE;
		$form_saved = FALSE;
		$form_action = "";
		$parents_array = array();

		// check, has the form been submitted, if so, setup validation
		if ($_POST)
		{
		
			//echo Kohana::debug($_POST);
			
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory(array_merge($_POST,$_FILES));

			 //	 Add some filters
			$post->pre_filter('trim', TRUE);
			
			
			//check if we're deleting a layer name
			$level_action = isset($_POST['level_action']) ? $_POST['level_action'] : "";
			
			if ($level_action == 'delete')		
			{
				//get the id of the layer to delete
				$del_level_id = $_POST['next_level'];
				$del_level = 0;
			
				//get the item and blow it out of the water
				$level_name = ORM::factory('adminareas_level_names')->where("level", $del_level_id)->find();
				if($level_name)
				{
					$del_level = $level_name->level;
					$level_name->delete();				
					
					//now fix the gap this just made in the hierarchy
					$level_names = ORM::factory('adminareas_level_names')->find_all();
					foreach($level_names as $level_name)
					{
						if($level_name->level > $del_level)
						{
							$level_name->level = $level_name->level - 1;
							$level_name->save();
						}
					}
				}
			}

			
			$action = isset($_POST['action_id']) ? $_POST['action_id'] : $_POST['action'];

			if ($action == 'a')		// Add Action
			{
				// Add some rules, the input field, followed by a list of checks, carried out in order
				$post->add_rules('name','required', 'length[3,80]');
				$post->add_rules('file', 'upload::valid','upload::type[kml,kmz]');
			}

			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				
				$adminarea_id = $post->adminarea_id;
				$adminarea = new Adminareas_Model($adminarea_id);
				if( $action == 'd' )
				{ // Delete Action
					//get the parent Id of this area we're deleting
					$parent_id = $adminarea->parent_id;
					//move all of this area's kids to its parent
					$adminareas = ORM::factory("adminareas")
						->orderby('name')
						->where('parent_id', $adminarea_id)
						->find_all();
					
					foreach($adminareas as $area)
					{
						$area->parent_id = $parent_id;
						$area->save();
					}
					
					// Delete KMZ file if any
					$file = $adminarea->file;
					if ( ! empty($file)
					AND file_exists(Kohana::config('upload.directory', TRUE).$file))
						unlink(Kohana::config('upload.directory', TRUE) . $file);

					$adminarea->delete( $adminarea_id );
					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.deleted'));

				}
				elseif( $action == 'a' )
				{ // Save Action
					$adminarea->name = $post->name;
					$parent_id = $post->parent_id;
					if($parent_id == "NULL")
					{
						$parent_id = NULL;
					}
					$adminarea->parent_id = $parent_id;
					$adminarea->save();

					// Upload KMZ/KML
					$path_info = upload::save("file");
					if ($path_info)
					{
						
						$path_parts = pathinfo($path_info);
						$file_name = $path_parts['filename'];
						$file_ext = $path_parts['extension'];

						if (strtolower($file_ext) == "kmz")
						{ // This is a KMZ Zip Archive, so extract
							$archive = new Pclzip($path_info);
							if ( TRUE == ($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)) )
							{
								foreach ($archive_files as $file)
								{
									$ext_file_name = $file['filename'];
								}
							}

							if ( $ext_file_name AND
									$archive->extract(PCLZIP_OPT_PATH, Kohana::config('upload.directory')) == TRUE )
							{ // Okay, so we have an extracted KML - Rename it and delete KMZ file
								rename($path_parts['dirname']."/".$ext_file_name,
									$path_parts['dirname']."/".$file_name.".kml");

								$file_ext = "kml";
								unlink($path_info);
							}
						}

						$adminarea->file = url::base().Kohana::config('upload.relative_directory')."/".$file_name.".".$file_ext;
						$adminarea->save();
					}
					else //no file was saved, so use the default
					{
						$adminarea->file = url::base()."plugins/locationhighlight/kml/blank.kml";
						$adminarea->save();
					}

					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.added_edited'));
				}
			}
			// No! We have validation errors, we need to show the form again, with the errors
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());

			   // populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('layer'));
				$form_error = TRUE;
			}
		}



		$adminareas = ORM::factory('adminareas')
						->orderby('name', 'asc')
						->find_all();
							
		
		//turn the admin areas into a hierarchy
		$pre_hierarchy = array();
		foreach($adminareas as $area)
		{
			if(!isset($pre_hierarchy[$area->parent_id]))
			{
				$pre_hierarchy[$area->parent_id] = array($area);
			}
			else
			{
				$pre_hierarchy[$area->parent_id][] = $area;
			}
		}
		
		
		$area_hierarchy = $this->hierarchy_stack($pre_hierarchy, '', 0);
		
							
		$parent_dropdown = array();
		$parent_dropdown['NULL']="--None--";
		$city_admin_area_dropdown = array();
		foreach($adminareas as $area)
		{
			$parent_dropdown[$area->id] = $area->name;
			$city_admin_area_dropdown[$area->id] = $area->name;
		}
		
		//get level names
		$level_names = ORM::factory('adminareas_level_names')
			->orderby("level", "asc")
			->find_all();
			
			
		//get cities
		$cities = ORM::factory('location_highlight_cities')
			->select("location_highlight_cities.*, adminareas.id as admin_id, adminareas.name as admin_name")
			->join('adminareas', 'location_highlight_cities.adminarea_id', 'adminareas.id')
			->find_all();
			
		
		//figure out the next level
		$next_level = 1;
		foreach($level_names as $level_name)
		{
			$next_level = $level_name->level + 1;
		}
		
		$this->template->content->next_level = $next_level;
		$this->template->content->level_names = $level_names;
		$this->template->content->area_hierarchy = $area_hierarchy;
		$this->template->content->parent_dropdown = $parent_dropdown;
		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->form_action = $form_action;
		$this->template->content->adminareas = $adminareas;
		$this->template->content->cities = $cities;
		$this->template->content->city_admin_area_dropdown = $city_admin_area_dropdown;

		// Javascript Header
		$this->template->colorpicker_enabled = TRUE;
		$this->template->js = new View('locationhighlight/settings_js');
	}
	
	
	
	//creates a mess of nested arrays to represent our hierarchies of stuff
	private function hierarchy_stack($flat_array, $key, $indent)
	{
		$retVal = array();
		
		//end condition
		if(!isset($flat_array[$key]))
		{
			return $retVal;
		}
	
		foreach($flat_array[$key] as $area)
		{
			$retVal[] = array("area"=>$area, "indent"=>$indent);
		
			$kids = $this->hierarchy_stack($flat_array, $area->id, $indent+1);
			if(count($kids) > 0)
			{
				$retVal = array_merge($retVal, $kids);
			}
			
		}
		
		return $retVal;
	}//end hierarchy_stack
	
	/*********************************************
	* Return html for a new level name 
	*********************************************/
	public function new_level_name($next_level)
	{
	
		$this->template = "";
		$this->auto_render = FALSE;
		
		//figure out the next level
		//$next_level = 1;
		
		$view = new View('locationhighlight/new_level_name');
		$view->next_level = $next_level;
		$view ->render(TRUE);
	
	}//end function new_level_name
	
	
	/************************************************
	* Save info of a level name
	************************************************/
	public function save_level_name($level, $name)
	{
	
		$this->template = "";
		$this->auto_render = FALSE;
		
		$level_name = ORM::factory('adminareas_level_names')->where("level", $level)->find();
		if(!$level_name)
		{
			//doesn't exists so make a new one
			$level_name = ORM::factory('adminareas_level_names');
		}
		
		$level_name->name = $name;
		$level_name->level = $level;
		$level_name->save();
		
		echo "success";
	}
	
	
	
	/*********************************************
	* Return html for a new city 
	*********************************************/
	public function new_city()
	{
	
		$this->template = "";
		$this->auto_render = FALSE;
		
		$adminareas = ORM::factory('adminareas')
						->orderby('name', 'asc')
						->find_all();
						
		$city_admin_area_dropdown = array();
		foreach($adminareas as $area)
		{		
			$city_admin_area_dropdown[$area->id] = $area->name;
		}
							
		
		$view = new View('locationhighlight/new_city');
		$view->id = 'A';
		$view->city_admin_area_dropdown = $city_admin_area_dropdown;
		$view ->render(TRUE);
	
	}//end function new_level_name	
	
	
	
	/************************************************
	* Save info of a city
	************************************************/
	public function save_city()
	{
		
		$name = $_POST['name'];
		$admin_id = $_POST['admin_id'];
		$lat = $_POST['lat'];
		$lon = $_POST['lon'];
		$id = $_POST['id'];
	
		$this->template = "";
		$this->auto_render = FALSE;
		
		
		if($id == 'A')
		{
			//doesn't exists so make a new one
			$city = ORM::factory('location_highlight_cities');
		}
		else 
		{
			$city = ORM::factory('location_highlight_cities')->where("id", $id)->find();	
		}
		
		$city->name = $name;
		$city->adminarea_id = $admin_id;
		$city->latitude = $lat;
		$city->longitude = $lon;
		$city->save();
		
		echo $city->id;
	}

	
	/************************************************
	* Delete info of a city
	************************************************/
	public function del_city()
	{
		
		
		$id = $_POST['id'];
	
		$this->template = "";
		$this->auto_render = FALSE;
		
		
		if($id == 'A')
		{
			echo "Worked, deleted $id";
			return;
		}
		else 
		{
			ORM::factory('location_highlight_cities')->where("id", $id)->delete_all();	
		}
		
		echo "Worked, deleted $id";
	}	

}//end class
