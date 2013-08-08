<?php defined('KOOWA') or die('Restricted access') ?>
<?php if ( !$viewer->eql($item) ) : ?>
<h2><?= @name($item) ?></h2>

<h3><?= @text('COM-ACTORS-EDIT-NOTIFICATION-SETTINGS') ?></h3>

<?php if ( $item->authorize('subscribe') ) : ?>
<form action="<?=@route($item->getURL())?>" method="post">
	<label class="control-label"><?= @text('COM-ACTORS-RECIEVE-NOTIFICATIONS')?></label>                   
    <input type="hidden" name="action" value="togglesubscription" />
    <select onchange="this.form.ajaxRequest().post()" >
    	<?= @html('options', array(@text('COM-ACTORS-RECIEVE-NOTIFICATIONS-NEW-SB'),@text('COM-ACTORS-RECIEVE-NOTIFICATIONS-ONLY-SB')),$item->subscribed($viewer) ? 0 : 1) ?>
    </select>
</form>  
<?php endif; ?>
<?php 
	$setting = @service('repos:notifications.setting')->findOrAddNew(array(
                'person' => $viewer,
                'actor'  => $item
    ))->reset();      
?>
<form action="<?= @route('option=com_notifications&view=setting&oid='.$item->id)?>" method="post">                      
	<label class="control-label"><?= @text('COM-ACTORS-SEND-EMAIL')?></label>
	<label class="checkbox">
		<input onclick="this.form.ajaxRequest().post()" id="notification-email" name="email" <?= $setting->getValue('posts', 1) == 2 ? 'disabled="true"' : ''?> <?= $setting->sendEmail('posts', 1) && $setting->getValue('posts', 1) < 2 ? 'checked' : ''?> value="1" type="checkbox" />
		<?= $viewer->email?><a href="<?=@route($viewer->getURL().'&get=settings&edit=account')?>" class="btn-mini"><?= @text('COM-ACTORS-NOTIFICATION-CHANGE-EMAIL') ?></a>
	</label>
</form>
<?php endif; ?>
