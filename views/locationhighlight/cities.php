<?php 
/**
 *  Cities view
 *
 * This plugin was written for Ushahidi Liberia, by the contractors of Ushahidi Liberia
 * 2011
 *
 * @package  Location Highlight plugin
 * @author     John Etherton <john@ethertontech.com>
 * 
 */
?>
				

							<table  class="table">
								<thead>
									<tr>
										<th class="col-1" style="width:20px;">&nbsp;</th>
										<th class="col-2" style="width:50px;"><?php echo Kohana::lang('layer.cityname');?></th>
										<th class="col-3" style="width:200px;"><?php echo Kohana::lang('layer.adminarea');?></th>
										<th class="col-4" style="width:200px;"><?php echo Kohana::lang('layer.lat_long');?></th>
										<th class="col-4" style="width:200px;"><?php echo Kohana::lang('ui_main.actions');?></th>
									</tr>
								</thead>
								<tfoot>
									<tr class="foot">
										<td colspan="5">
											---
										</td>
									</tr>
								</tfoot>
								<tbody id="citytable">
									<?php
									if ( count ($cities) == 0)
									{
									?>
										<tr id="nocitynames">
											<td colspan="5" class="col">
												<h3><?php echo Kohana::lang('ui_main.no_results');?></h3>
											</td>
										</tr>
									<?php	
									}
									foreach ($cities as $city)
									{
										
									?>
										<tr id="city_row_<?php echo $city->id; ?>">
											<td class="col-1" style="width:20px;">&nbsp;</td>
											<td class="col-2" style="width:50px;">
												<input type="text" id="city_name_<?php echo $city->id; ?>" name="city_name_<?php echo $city->id; ?>" value="<?php echo $city->name; ?>"/>
											</td>
											<td class="col-3" style="width:200px;">
												<?php print form::dropdown('city_adminarea_'.$city->id, $city_admin_area_dropdown, $city->admin_id, 'style="width:150px;"'); ?>
											</td>
											<td class="col-3" style="width:250px;">
												<?php echo Kohana::lang("layer.lat");?>:
												<input type="text" id="city_lat_<?php echo $city->id; ?>" name="city_lat_<?php echo $city->id; ?>" value="<?php echo $city->latitude; ?>"/>
												<br/>
												<?php echo Kohana::lang("layer.lon");?>:
												<input type="text" id="city_lon_<?php echo $city->id; ?>" name="city_lon_<?php echo $city->id; ?>" value="<?php echo $city->longitude; ?>"/>
											</td>
											<td class="col-4" style="width:150px;">
												<span id="city_status_<?php echo $city->id; ?>"></span>
												<ul>
													<li class="none-separator"><a id="save_city_btn_<?php echo $city->id; ?>" href="#" ><?php echo Kohana::lang('layer.save');?></a></li>
													<li><a id="del_city_btn_<?php echo $city->id; ?>" href="#" ><?php echo Kohana::lang('layer.delete');?></a></li>
												</ul>
											</td>
										</tr>
										<?php									
									}
									?>
								</tbody>
							</table>
			