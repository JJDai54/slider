<!-- Header -->
<{include file='db:slider_admin_header.tpl' }>

<{if $form}>
	<{$form}>
<{/if}>

<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:slider_admin_footer.tpl' }>

<br><script>
tth_set_value('last_asc', true);
tth_trierTableau('slider_tbl_theme', 2, '1-2-3-4-5');  
</script>
