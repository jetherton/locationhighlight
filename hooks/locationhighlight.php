<?php defined('SYSPATH') or die('No direct script access.');
/**
 * File Upload - sets up the hooks
 *
 * @author	   John Etherton
 * @package	   File Upload
 */

class locationhighlight {
	
	/**
	 * Registers the main event add method
	 */
	 
	 
	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
		$this->post_data = null; //initialize this for later use
		
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
	
	// Only add the events if we are on that controller
		if (Router::$controller == 'reports')
		{
			switch (Router::$method)
			{
				// Hook into the Report Add/Edit Form in Admin
				case 'edit':

					// Hook into the form itself on the admin side
					Event::add('ushahidi_action.report_form_admin_location', array($this, '_highlight'));
					plugin::add_stylesheet('locationhighlight/media/css/locationhighlight');
					break;
				
				//Hook into frontend Submit View
				case 'submit':
					//Hook into the form on the frontend
					Event::add('ushahidi_action.report_form_location', array($this, '_highlight'));
					Event::add('ushahidi_action.report_form_admin_location', array($this, '_highlight')); //for backwards compatibility
					plugin::add_stylesheet('locationhighlight/media/css/locationhighlight');
					break;
					
				default:
					break;
			}//end of switch
		}//end of if reports
	}
	
	
	/**
	 * Show the web form to edit what files are to be added and deleted
	 */
	public function _highlight()
	{				
		// Load the View		
		$form = View::factory('locationhighlight/incident_edit');
		
		$level_1_name = "administrative area";
		$level_name = ORM::factory('adminareas_level_names')->where("level", 0)->find();
		if($level_name->loaded)
		{
			$level_1_name = $level_name->name;
		}
		$form->level_name = $level_1_name;
		$form->admin_areas = adminareas::get_admin_areas_for_dropdown();
		$form->render(TRUE);
	}//end method
	
	
}

new locationhighlight;
