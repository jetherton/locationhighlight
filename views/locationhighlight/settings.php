<?php 
/**
 *  Location Highlight English Language file
 *
 * This plugin was written for Ushahidi Liberia, by the contractors of Ushahidi Liberia
 * 2011
 *
 * @package  Location Highlight plugin
 * @author     Carter Draper <carjimdra@gmail.com>
 * 
 */
?>
			<div class="bg">
				<h2>
					<?php //admin::manage_subtabs("layers"); ?>
				</h2>
				<?php
				if ($form_error) {
				?>
					<!-- red-box -->
					<div class="red-box">
						<h3><?php echo Kohana::lang('ui_main.error');?></h3>
						<ul>
						<?php
						foreach ($errors as $error_item => $error_description)
						{
							// print "<li>" . $error_description . "</li>";
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
						?>
						</ul>
					</div>
				<?php
				}

				if ($form_saved) {
				?>
					<!-- green-box -->
					<div class="green-box">
						<h3><?php echo Kohana::lang('ui_main.layer_has_been');?> <?php echo $form_action; ?>!</h3>
					</div>
				<?php
				}
				?>
				
				
				
				
				
								<!-- tabs -->
				<div class="tabs">
				
				
				<!-- Level Names -->
				<div style="margin-bottom:20px;">
				<h3><?php echo Kohana::lang('layer.admin');?></h3>
				<p><?php echo Kohana::lang('layer.admin_explain');?></p>
				<a href="#" onclick="addNewLevelName(); return false;" style="border:solid grey 1px; background:#f2f7fa; float:right; padding:5px; margin 5px;"><?php echo Kohana::lang('layer.new');?></a>
				
				
				<!-- level-table -->
				<div class="report-form">
						<div>
							<table  class="table">
								<thead>
									<tr>
										<th class="col-1" style="width:20px;">&nbsp;</th>
										<th class="col-2" style="width:50px;"><?php echo Kohana::lang('layer.level');?></th>
										<th class="col-3" style="width:200px;"><?php echo Kohana::lang('layer.level_name');?></th>
										<th class="col-4" style="width:200px;"><?php echo Kohana::lang('ui_main.actions');?></th>
									</tr>
								</thead>
								<tfoot>
									<tr class="foot">
										<td colspan="4">
											---
										</td>
									</tr>
								</tfoot>
								<tbody id="levelnametable">
									<?php
									if ( count ($level_names) == 0)
									{
									?>
										<tr id="nolevelnames">
											<td colspan="4" class="col">
												<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
											</td>
										</tr>
									<?php	
									}
									foreach ($level_names as $level_name)
									{
										
									?>
										<tr>
											<td class="col-1" style="width:20px;">&nbsp;</td>
											<td class="col-2" style="width:50px;">
														<?php echo $level_name->level; ?>
											</td>
											<td class="col-3" style="width:200px;">
												<input type="text" id="level_name_form_<?php echo $level_name->level; ?>" name="level_name_form_<?php echo $level_name->level; ?>" value="<?php echo $level_name->name; ?>"/>
											</td>
											<td class="col-4" style="width:200px;">
												<span id="name_level_status<?php echo $level_name->level; ?>"></span>
												<ul>
													<li class="none-separator"><a href="#" onclick="saveLevelName('<?php echo $level_name->level; ?>'); return false;"><?php echo Kohana::lang('layer.save');?></a></li>
													<li><a href="#" onclick="deleteLevelName('<?php echo $level_name->level; ?>'); return false;"><?php echo Kohana::lang('layer.delete');?></a></li>
												</ul>
											</td>
										</tr>
										<?php									
									}
									?>
								</tbody>
							</table>
						</div>
				</div>
				
				<!-- /Level Names-->
				
				
				</div>
				
					<!-- tabset -->
					<a name="add"></a>
					<ul class="tabset">
						<li><a href="#" class="active"><?php echo Kohana::lang('layer.add_edit_area');?></a></li>
					</ul>
					<!-- tab -->
					<div class="tab">
						<?php print form::open(NULL,array('enctype' => 'multipart/form-data', 
							'id' => 'layerMain', 'name' => 'layerMain')); ?>
						<input type="hidden" id="adminarea_id" 
							name="adminarea_id" value="" />
						<input type="hidden" name="action" 
							id="action" value="a"/>
						<input type="hidden" name="layer_file_old" 
							id="layer_file_old" value=""/>
						<div style="margin:10px;"><?php echo Kohana::lang('layer.add_edit_area_explain');?>:</div>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('layer.admin_area_name');?>:</strong><br />
							<?php print form::input('name', '', ' class="text"'); ?>
						</div>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('layer.parent');?></strong><br />
							<?php print form::dropdown('parent_id', $parent_dropdown, 'standard'); ?>
						</div>
						<div style="clear:both"></div>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('layer.kml_kmz_upload');?>:</strong><br />
							<div style="margin-left:10px;"><?php echo Kohana::lang('layer.kml_kmz_upload_optional');?>:</div>
							<?php print form::upload('file', '', ''); ?>
						</div>
						<div style="clear:both"></div>
						<div class="tab_form_item">
							&nbsp;<br />
							<input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save.gif" class="save-rep-btn" />
						</div>
						<?php print form::close(); ?>			
					</div>
				</div>

				
				
				
				
				
				
				
				<!-- report-table -->
				<div class="report-form">
					<?php print form::open(NULL,array('id' => 'layerListing',
					 	'name' => 'layerListing')); ?>
						<input type="hidden" id="next_level"  name="next_level" value="<?php echo $next_level; ?>" />
						<input type="hidden" id="level_action"  name="level_action" value="" />

						<input type="hidden" name="action_id" id="action_id" value="">
						<input type="hidden" name="adminarea_id" id="adminarea_id_action" value="">
						<div class="table-holder">
							<table class="table">
								<thead>
									<tr>
										<th class="col-1">&nbsp;</th>
										<th class="col-2"><?php echo Kohana::lang('layer.area');?></th>
										<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
									</tr>
								</thead>
								<tfoot>
									<tr class="foot">
										<td colspan="4">
										
										</td>
									</tr>
								</tfoot>
								<tbody>
									<?php
									if (count($area_hierarchy) == 0)
									{
									?>
										<tr>
											<td colspan="4" class="col">
												<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
											</td>
										</tr>
									<?php	
									}
									foreach ($area_hierarchy as $area_data)
									{
										$adminarea = $area_data['area'];
										$indents = $area_data['indent'];
										
										$adminarea_id = $adminarea->id;
										$adminarea_name = $adminarea->name;
										$adminarea_file = $adminarea->file;
										$adminarea_parent_id = $adminarea->parent_id;
										
										//handle nulls
										if($adminarea_parent_id == "")
										{
											$adminarea_parent_id = "NULL";
										}
										?>
										<tr>
											<td class="col-1">&nbsp;</td>
											<td class="col-2">
												<div class="post">
													<h4>
														<?php 
															for($i = 0; $i < $indents; $i++)
															{
																echo "&gt;&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
															}
															echo $adminarea_name; 
														?>
													</h4>
												</div>
												<ul class="info">
													<?php
													if($adminarea_file)
													{
														?><li class="none-separator">
															<?php echo Kohana::lang('ui_main.kml_kmz_file');?>: <strong><?php echo $adminarea_file; ?></strong>
														</li>
														<?php
													}
													?>
												</ul>
											</td>
											<td class="col-4">
												<ul>
													<li class="none-separator"><a href="#add" onClick="fillFields('<?php echo(rawurlencode($adminarea_id)); ?>','<?php echo(rawurlencode($adminarea_name)); ?>','<?php echo(rawurlencode($adminarea_parent_id)); ?>','','<?php echo(rawurlencode($adminarea_file)); ?>')"><?php echo Kohana::lang('ui_main.edit');?></a></li>
													
<li><a href="javascript:layerAction('d','DELETE','<?php echo(rawurlencode($adminarea_id)); ?>')" class="del"><?php echo Kohana::lang('ui_main.delete');?></a></li>
												</ul>
											</td>
										</tr>
										<?php									
									}
									?>
								</tbody>
							</table>
						</div>
					<?php print form::close(); ?>
				</div>
				
				<!-- Cities -->
				<div class="tabs">
				<h3><?php echo Kohana::lang('layer.cities');?></h3>
				<strong><?php echo Kohana::lang('layer.viewing_cities');?>: </strong><?php print form::dropdown('city_span', $cities_drop_down, $cities_drop_down_selected, 'style="width:150px;" onchange="changeCities();"'); ?><span id="change_cities_wait"></span> 
				<a href="#" onclick="addNewCity(); return false;" style="border:solid grey 1px; background:#f2f7fa; float:right; padding:5px; margin 5px;"><?php echo Kohana::lang('layer.newcity');?></a>

				<!-- level-table -->
				<div class="report-form">
						<div id="city_table_holder">
							<?php
									$view = new View('locationhighlight/cities');
									$view->cities = $cities;
									$view->city_admin_area_dropdown = $city_admin_area_dropdown;
									$view ->render(TRUE); 
							?>
						</div>
				</div>
				
				<!-- /Cities -->
				<br/>
				<h3>
				<a href="<?php echo url::base()."/admin/locationhighlight_settings/upload"?>" ><?php echo Kohana::lang('layer.csv_upload');?></a>
				</h3>	
			</div>
			