<div class="one_full">
	<section class="title">
		<h4><?php echo lang($namespace.':label:addon_modules');?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if($addon_modules['total'] == 0):?>
				<div class="no_data">
					<?php echo lang($namespace.':message:no_entries');?>
				</div>
			<?php else:?>
				<table class="table-list" cellpadding="0" cellspacing="0">

					<thead>
						<tr>
							<th><?php echo lang($namespace.':label:name');?></th>
							<th><?php echo lang($namespace.':label:description');?></th>
							<th><?php echo lang($namespace.':label:version');?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($addon_modules['entries'] as $addon_module):?>
							<tr>
								<td>
									<input type="hidden" name="action_to[]" value="<?php $addon_module['id'];?>" /><?php echo $addon_module['name'];?>
								</td>
								<td>
									<?php echo $addon_module['description'];?>
								</td>
								<td>
									<?php echo $addon_module['version'];?>
								</td>
								<td class="actions">
									<?php if($entry['installed']):?>
										<?php /*if(!$entry['enabled']):?>
											<a href="<?php echo site_url('admin/nitrocart/modules/enable/').$addon_module['id'];?>" class="button"><?php echo lang($namespace.':label:enable');?></a>
										<?php else:?>
											<a href="<?php echo site_url('admin/nitrocart/modules/disable/').$addon_module['id'];?>" class="button"><?php echo lang($namespace.':label:disable');?></a>
										<?php endif;*/?>
										<a href="<?php echo site_url('admin/nitrocart/modules/disable/').$addon_module['id'];?>" class="button"><?php echo lang($namespace.':label:uninstall');?></a>
									<?php else:?>
										<a href="<?php echo site_url('admin/nitrocart/modules/disable/').$addon_module['id'];?>" class="button"><?php echo lang($namespace.':label:install');?></a>
									<?php endif;?>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>

				</table>
			<?php endif;?>
		</div>
	</section>
</div>

<div class="one_full">
	<section class="title">
		<h4><?php echo lang($namespace.':label:core_modules');?></h4>
	</section>

	<section class="item">
		<div class="content">
			<table class="table-list" cellpadding="0" cellspacing="0">

				<thead>
					<tr>
						<th><?php echo lang($namespace.':label:name');?></th>
						<th><?php echo lang($namespace.':label:description');?></th>
						<th><?php echo lang($namespace.':label:version');?></th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($core_modules['entries'] as $core_module):?>
						<tr>
							<td>
								<input type="hidden" name="action_to[]" value="<?php $core_module['id'];?>" /><?php echo $core_module['name'];?>
							</td>
							<td>
								<?php echo $core_module['description'];?>
							</td>
							<td>
								<?php echo $core_module['version'];?>
							</td>
							<td class="actions">		
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>

			</table>
		</div>
	</section>
</div>