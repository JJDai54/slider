<!-- Header -->
<{include file='db:slider_admin_header.tpl' }>
<form id="theme_form"  name="theme_form" action="slides.php" method='get'>
    <{$smarty.const._AM_SLIDER_SLIDE_THEME}> : <{$sldThemeSelect}>
</form>

<{if $slides_list}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_ID}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_THEME}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_SHORT_NAME}></th>
                <{* <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_TITLE}></th> *}>
                <{* <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_DESCRIPTION}></th> *}>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_WEIGHT}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_ACTIF}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_HAS_PERIODE}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_DATE_BEGIN}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_DATE_END}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_CURRENT_STATUS}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_SLIDE_IMAGE}></th>
                <th class="center width5"><{$smarty.const._AM_SLIDER_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $slides_count}>
        <tbody>
            <{foreach item=slide from=$slides_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$slide.id}></td>
                <td class='left'><{$slide.theme}></td>
                <td class='left'> <a href="slides.php?op=edit&amp;sld_id=<{$slide.id}>" title="<{$smarty.const._EDIT}>"><{$slide.short_name}></a></td>
                <{* <td class='left'><{$slide.title}></td> *}>
                <{* <td class='center'><{$slide.description}></td> *}>
                
                <td class='center'>
                    <a href="slides.php?op=weight&sld_id=<{$slide.id}>&sens=asc&sld_theme=<{$slide.theme}>&sld_weight=<{$slide.weight}>">
                    <img src="<{$sysPathIcon16}>/ASC.png" title="<{$smarty.const._AM_SLIDER_UP}>">
                    </a>
                    <{$slide.weight}>
                    <a href="slides.php?op=weight&sld_id=<{$slide.id}>&sens=desc&sld_theme=<{$slide.theme}>&sld_weight=<{$slide.weight}>">
                    <img src="<{$sysPathIcon16}>/DESC.png" title="<{$smarty.const._AM_SLIDER_DOWN}>">
                    </a>
                </td>
                
                <{* <td class='center'><{$slide.actif}></td> *}>
                <td class='center'>
                <{if $slide.actif == 1}>
                    <a href="slides.php?op=bascule_actif&sld_id=<{$slide.id}>&value=0&sld_theme=<{$slide.theme}>">
                    <img src="<{$sysPathIcon16}>/on.png" title="<{$smarty.const._AM_SLIDER_DESACTIVATE}>">
                    </a>
                <{else}>
                    <a href="slides.php?op=bascule_actif&sld_id=<{$slide.id}>&value=1&sld_theme=<{$slide.theme}>">
                    <img src="<{$sysPathIcon16}>/off.png" title="<{$smarty.const._AM_SLIDER_ACTIVATE}>">
                    </a>
                <{/if}>
                </td>
                
                <{* <td class='center'><{$slide.has_periode}></td> *}>
                <td class='center'>
                <{if $slide.has_periode == 1}>
                    <a href="slides.php?op=bascule_has_periode&sld_id=<{$slide.id}>&value=0&sld_theme=<{$slide.theme}>">
                    <img src="<{$sysPathIcon16}>/on.png" title="<{$smarty.const._AM_SLIDER_DESACTIVATE}>">
                    </a>
                <{else}>
                    <a href="slides.php?op=bascule_has_periode&sld_id=<{$slide.id}>&value=1&sld_theme=<{$slide.theme}>">
                    <img src="<{$sysPathIcon16}>/off.png" title="<{$smarty.const._AM_SLIDER_ACTIVATE}>">
                    </a>
                <{/if}>
                </td>
                
                <td class='center'><{$slide.date_begin}></td>
                <td class='center'><{$slide.date_end}></td>
                
                <td class='center'>
                <{if $slide.current_status}>
                    <img src="<{$sysPathIcon16}>/on.png" title="<{$smarty.const._AM_SLIDER_ACTIF}>">
                <{else}>

                    <img src="<{$sysPathIcon16}>/off.png" title="<{$smarty.const._AM_SLIDER_NON_ACTIF}>">
                <{/if}>
                </td>
                
                <td class='center'><img src="<{$slider_upload_url}>/images/slides/<{$slide.image}>" alt="slides" style="max-width:100px" /></td>
                <td class="center  width5">
                    <a href="slides.php?op=edit&amp;sld_id=<{$slide.id}>" title="<{$smarty.const._EDIT}>">
                       <img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> slides" /></a>
                    <a href="slides.php?op=delete&amp;sld_id=<{$slide.id}>" title="<{$smarty.const._DELETE}>">
                       <img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> slides" /></a>
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
