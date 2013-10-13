<div class="one_full">
	<section class="title">
		<h4><?php echo lang($namespace.':label:custom_fields');?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if($is_empty):?>
				<div class="no_data">
					<?php echo lang($namespace.':message:no_entries');?>
				</div>
			<?php else:?>
				<table class="table-list" cellpadding="0" cellspacing="0">

					<thead>
						<tr>
							<th><?php echo lang($namespace.':label:name');?></th>
							<th><?php echo lang($namespace.':label:description');?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($assignments as $assignment):?>
							<tr>
								<td>
									<input type="hidden" name="action_to[]" value="<?php $assignment->field_id;?>" /><?php echo lang_label($assignment->field_name);?>
								</td>
								<td>
									<?php echo lang_label($assignment->instructions);?>
								</td>
								<td class="actions">
									<?php if($assignment->view_options):?>
										<a href="<?php echo site_url('admin/'.$namespace.'/'.$stream.'/disable_custom_field/'.$assignment->field_slug);?>" class="button"><?php echo lang($namespace.':label:disable');?></a>
									<?php else:?>
										<a href="<?php echo site_url('admin/'.$namespace.'/'.$stream.'/enable_custom_field/'.$assignment->field_slug);?>" class="button"><?php echo lang($namespace.':label:enable');?></a>
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