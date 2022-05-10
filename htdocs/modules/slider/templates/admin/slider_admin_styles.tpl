<!-- Header -->
<{include file='db:slider_admin_header.tpl' }>

<{if $styles_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_SLIDER_ID}></th>
                <th class="center"><{$smarty.const._AM_SLIDER_STYLE_NAME}></th>
                <{*  <th class="center"><{$smarty.const._AM_SLIDER_STYLE_OBJECT}></th> *}>
                <th class="center"><{$smarty.const._AM_SLIDER_STYLE_CSS}></th>
                <th class="center width5"><{$smarty.const._AM_SLIDER_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $styles_count|default:''}>
        <tbody>
            <{foreach item=style from=$styles_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$style.id}></td>
                <td class='left'>
                <a href="styles.php?op=edit&amp;sty_id=<{$style.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><{$style.name}></a>
                </td>
                
                <{* <td class='center'><{$style.object}></td> *}>
                <td class='left'><{$style.css_short}></td>
                <td class="center  width5">
                    <a href="styles.php?op=edit&amp;sty_id=<{$style.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> styles" ></a>
                    <a href="styles.php?op=clone&amp;sty_id_source=<{$style.id}>" title="<{$smarty.const._CLONE}>"><img src="<{xoModuleIcons16 editcopy.png}>" alt="<{$smarty.const._CLONE}> styles" ></a>
                    <{if $style.id>3}>
                    <a href="styles.php?op=delete&amp;sty_id=<{$style.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> styles" ></a>
                    <{/if}>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:slider_admin_footer.tpl' }>
