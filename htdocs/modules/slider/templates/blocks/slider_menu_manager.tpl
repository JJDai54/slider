<{*
<{if $smarty.const.NEWS_SHOW_TPL_NAME==1 || true}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>
<{assign var="$catOk" value=($block.module.nbCatItems > 0)}>
<{include file='db:$block.module.tpl' }>
<{$block.module.tpl}>
 

<{if  $block.module.tpl == 1}>
    <{include file='db:slider_menu_xbootstrap_main.tpl'}>
<{else}>
    <{include file='db:slider_menu_xswatch4_main.tpl'}>
<{/if}>


*}>

    <{include file=$block.module.tplMainMenu}>
