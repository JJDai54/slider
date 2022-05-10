<!-- Header -->
<{include file='db:slider_admin_header.tpl' }>

<{if $themes_list}>
	<table id='slider_tbl_theme' name='slider_tbl_theme' class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center width5""><{$smarty.const._AM_SLIDER_ID}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_FOLDER}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_NAME}></th>
				<th class="center width10"><{$smarty.const._AM_SLIDER_THEME_VERSION}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_THEME_TPL_SLIDER}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_THEME_XSWATCH4E}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_THEME_WHITE_CSS}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_THEME_DARK_CSS}></th>
				<th class="center"><{$smarty.const._AM_SLIDER_THEME_SLIDER}></th>
				<th class="center width10""><{$smarty.const._AM_SLIDER_THEME_TRANSITION}></th>
				<th class="center width10""><{$smarty.const._AM_SLIDER_THEME_RANDOM}></th>
				<th class="center width5"><{$smarty.const._AM_SLIDER_GENERER}></th>
				<th class="center width5"><{$smarty.const._AM_SLIDER_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $themes_count}>
		<tbody>
			<{foreach item=theme from=$themes_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$theme.id}></td>
				<td class='left'>
					<a href="themes.php?op=edit&amp;theme_id=<{$theme.id}>" title="<{$smarty.const._EDIT}>"><{$theme.folder}></a>
                </td>
				<td class='left'>
					<a href="themes.php?op=edit&amp;theme_id=<{$theme.id}>" title="<{$smarty.const._EDIT}>"><{$theme.name}></a>
                </td>
                
				<td class='center'><{$theme.version}></td>
				<td class='left'><{$theme.tpl_slider}></td>
				<td class='center'>
                    <{if $theme.isXswatch4E}>
                        <img src="<{xoModuleIcons16 green.gif}>" alt="" />
                    <{else}>
                        <img src="<{xoModuleIcons16 red.gif}>" alt="" />
                    <{/if}>
                </td>
				<td class='left'><{$theme.css}></td>
				<td class='left'><{$theme.darkCss}></td>
                
				<td class='center'>
                    <{if $theme.isXswatch4E}>
                    <{if $theme.isSliderAllowed}>
					    <a href="themes.php?op=allowed_slider&theme_id=<{$theme.id}>&theme_folder=<{$theme.folder}>&etat=0" title="<{$smarty.const._AM_SLIDER_THEME_DESACTIVER_SLIDER}>">           
                            <img src="<{xoModuleIcons16 green.gif}>" alt="" />
                        </a>
                    <{else}>
					    <a href="themes.php?op=allowed_slider&theme_id=<{$theme.id}>&theme_folder=<{$theme.folder}>&etat=1" title="<{$smarty.const._AM_SLIDER_THEME_ACTIVER_SLIDER}>">           
                            <img src="<{xoModuleIcons16 red.gif}>" alt="" />
                        </a>
                    <{/if}>
                    <{else}>
                            <img src="<{xoModuleIcons16 green_off.gif}>" alt="" />
                    <{/if}>
                </td>
                
				<td class='center'><{$theme.transition_caption}></td>
				<td class='left'><{$theme.random_caption}></td>
				<td class='center'>
                    <{if $theme.actif == 1}>
					    <a href="themes.php?op=generer_old_slider&theme_id=<{$theme.id}>&theme_folder=<{$theme.folder}>" title="<{$smarty.const._AM_SLIDER_THEME_DESACTIVER}>">
                        <img src="<{$modPathIcon16}>/retour-1.png" title="<{$smarty.const._AM_SLIDER_THEME_DESACTIVER}>" />
                        </a>
                        <img src="<{$modPathIcon16}>/blank.png"   title=""/>

                        <{if $theme.nbSlides > 0}>
    					    <a href="themes.php?op=generer_new_slider&theme_id=<{$theme.id}>&theme_folder=<{$theme.folder}>"" title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER_2}>">
                            <img src="<{$modPathIcon16}>/generer-2.png"   title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER_2}>"/>
                            </a>
                        <{else}>
                            <img src="<{$modPathIcon16}>/status4.png"   title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER}>"/>
                        <{/if}>
                    <{else}>
                        <img src="<{$modPathIcon16}>/status4.png"   title="<{$smarty.const._AM_SLIDER_ORIGINAL}>"/>
                        <img src="<{$modPathIcon16}>/blank.png"   title=""/>

                        <{if $theme.nbSlides > 0}>
      					    <a href="themes.php?op=generer_new_slider&theme_id=<{$theme.id}>&theme_folder=<{$theme.folder}>"" title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER}>">
                            <img src="<{$modPathIcon16}>/generer-1.png"   title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER}>"/>
                            </a>
                        <{else}>
                            <img src="<{$modPathIcon16}>/status4.png"   title="<{$smarty.const._AM_SLIDER_GENERER_SLIDER}>"/>
                        <{/if}>
                    <{/if}>
                </td>
				<td class="center  width5">
					<a href="themes.php?op=edit&amp;theme_id=<{$theme.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> themes" /></a>
					<a href="logo.php?op=logo-form&theme_id=<{$theme.id}>" title="<{$smarty.const._AM_SLIDER_THEME_LOGO}>"><img src="<{xoModuleIcons16 attach.png}>" alt="<{$smarty.const._AM_SLIDER_THEME_LOGO}> themes" /></a>
					
                    <{* pas besoin de supprimer
                    <a href="themes.php?op=delete&amp;theme_id=<{$theme.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> themes" /></a>
                    *}>
                    <a href="themes.php?op=edit_mycss&amp;theme_id=<{$theme.id}>" title="<{$smarty.const._EDIT}>">
                        <img src="<{xoModuleIcons16 view.png}>" alt="<{$smarty.const._AM_SLIDER_THEME_SURCHARGER}>" />
                    </a>
                    
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
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
