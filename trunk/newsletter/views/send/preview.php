<? include '_header.php'?>
		<table>
			<tr>
				<th><?=lang('module_newsletter_title')?>&nbsp;&nbsp;</th>
				<td><?=$preview['title']?></td>
			</tr>
			
			<tr>
				<th><?=lang('module_newsletter_content')?>&nbsp;&nbsp;</th>
				<td><?=$preview['content']?></td>
			</tr>
		</table>	
		<?=$form?>
<? include '_footer.php'?>
