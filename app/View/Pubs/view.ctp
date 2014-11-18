<div class="pubs view">
<h2><?php  echo __('Pub');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pub['User']['id'], array('controller' => 'users', 'action' => 'view', $pub['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['question']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Point/user'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['point/user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reste'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['reste']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tranche'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['tranche']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sexe'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['sexe']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ville'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['ville']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($pub['Pub']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
