<div id="main_top_panel">
	<h2 class="ico ico_newsletter_send"><?=lang('module_newsletter_send_newletter')?></h2>
</div>
<div class="clear"></div>
<form method="post" action="" id="form">
<? if(isset($cancel) and $cancel) : ?>
<div id="action">
	<div id="filters">
	</div>
	<div class="buttonbar" id="actions">
		<ul>
			<li class="end"><a href="#" class="ico ico_cancel" id="cancel"><?=lang('module_newsletter_cancel')?></a></li>
			<script>
				$("a#cancel").click(function(){
					form = $(this).parent().parent().parent().parent().parent();
					hidden = $('<input />',{
						type :'hidden',
						value :'cancel',
						name : 'cancel'
					});
					form.append(hidden);
					form.submit();
					return false;
				});
			</script>
		</ul>		
	</div>
</div>
<? endif;?>
<div class="clear"></div>

<div id="notification" class="notification" style="margin">
	<?=$notifications?>
</div>
<div id="main_content" class="noaction">
	<div id="main_content_inner">