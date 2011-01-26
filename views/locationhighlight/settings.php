<?php 
/**
 * Layers view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Layers view
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
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
					<!-- tabset -->
					<a name="add"></a>
					<ul class="tabset">
						<li><a href="#" class="active"><?php echo Kohana::lang('ui_main.add_edit');?></a></li>
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
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('ui_main.layer_name');?>:</strong><br />
							<?php print form::input('name', '', ' class="text"'); ?>
						</div>
						<div class="tab_form_item">
							<strong>Parent Admin Area:</strong><br />
							<?php print form::dropdown('parent_id', $parent_dropdown, 'standard'); ?>
						</div>
						<div style="clear:both"></div>
						<div class="tab_form_item">
							<strong><?php echo Kohana::lang('ui_main.kml_kmz_upload');?>:</strong><br />
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
						<input type="hidden" name="action_id" id="action_id" value="">
						<input type="hidden" name="adminarea_id" id="adminarea_id_action" value="">
						<div class="table-holder">
							<table class="table">
								<thead>
									<tr>
										<th class="col-1">&nbsp;</th>
										<th class="col-2">Admin Areas</th>
										<th class="col-4"><?php echo Kohana::lang('ui_main.actions');?></th>
									</tr>
								</thead>
								<tfoot>
									<tr class="foot">
										<td colspan="4">
											<?php echo $pagination; ?>
										</td>
									</tr>
								</tfoot>
								<tbody>
									<?php
									if ($total_items == 0)
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
				
			</div>
