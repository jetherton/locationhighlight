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
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory(array_merge($_POST,$_FILES));

			 //	 Add some filters
			$post->pre_filter('trim', TRUE);

			if ($post->action == 'a')		// Add Action
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

				if( $post->action == 'd' )
				{ // Delete Action

					// Delete KMZ file if any
					$file = $adminarea->file;
					if ( ! empty($file)
					AND file_exists(Kohana::config('upload.directory', TRUE).$file))
						unlink(Kohana::config('upload.directory', TRUE) . $file);

					$adminarea->delete( $adminarea_id );
					$form_saved = TRUE;
					$form_action = strtoupper(Kohana::lang('ui_admin.deleted'));

				}
				elseif( $post->action == 'v' )
				{ // Show/Hide Action
					if ($adminarea->loaded==true)
					{
						if ($adminarea->layer_visible == 1) {
							$adminarea->layer_visible = 0;
						}
						else {
							$adminarea->layer_visible = 1;
						}
						$adminarea->save();
						$form_saved = TRUE;
						$form_action = strtoupper(Kohana::lang('ui_admin.modified'));
					}
				}
				elseif( $post->action == 'i' )
				{ // Delete KMZ/KML Action
					if ($adminarea->loaded==true)
					{
						$file = $adminarea->file;
						if ( ! empty($file)
							AND file_exists(Kohana::config('upload.directory', TRUE).$file))
						{
							unlink(Kohana::config('upload.directory', TRUE) . $file);
						}

						$adminarea->file = null;
						$adminarea->save();
						$form_saved = TRUE;
						$form_action = strtoupper(Kohana::lang('ui_admin.modified'));
					}
				}
				elseif( $post->action == 'a' )
				{ // Save Action
					$adminarea->name = $post->name;
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

						$adminarea->file = $file_name.".".$file_ext;
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

		// Pagination
		$pagination = new Pagination(array(
							'query_string' => 'page',
							'items_per_page' => (int) Kohana::config('settings.items_per_page_admin'),
							'total_items'	 => ORM::factory('adminareas')
													->count_all()
						));

		$adminareas = ORM::factory('adminareas')
						->orderby('name', 'asc')
						->find_all((int) Kohana::config('settings.items_per_page_admin'),
							$pagination->sql_offset);

		$this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
		$this->template->content->form_action = $form_action;
		$this->template->content->pagination = $pagination;
		$this->template->content->total_items = $pagination->total_items;
		$this->template->content->adminareas = $adminareas;

		// Javascript Header
		$this->template->colorpicker_enabled = TRUE;
		$this->template->js = new View('locationhighlight/settings_js');
	}

}//end class
