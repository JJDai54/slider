<div id='block_slides' name='media_menu_h' class='media_block' width="100%">


sfklsjfh sdkjfh klsh fklsfh lskjdfh klsdjfh slkjfh skljdfh ksdf<br>

<table class='table table-<{$table_type}>'>
    <thead>
        <tr class='head'>
            <th>&nbsp;</th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_SHORT_NAME}></th>
            <{* <<th class='center'><{$smarty.const._MB_SLIDER_SLD_TITLE}></th></th> *}>
            <{* <th class='center'><{$smarty.const._MB_SLIDER_SLD_DESCRIPTION}></th> *}>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_WEIGHT}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_DATE_BEGIN}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_DATE_END}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_ACTIF}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_ALWAYS_VISIBLE}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_THEME}></th>
            <th class='center'><{$smarty.const._MB_SLIDER_SLD_IMAGE}></th>
        </tr>
    </thead>
    <{if count($block)}>
    <tbody>
        <{foreach item=slide from=$block}>
        <tr class='<{cycle values="odd, even"}>'>
            <td class='center'><{$slide.id}></td>
            <td class='center'><{$slide.short_name}></td>
            <{* <td class='center'><{$slide.title}></td> *}>
            <{* <td class='center'><{$slide.description}></td> *}>
            <td class='center'><{$slide.weight}></td>
            <td class='center'><{$slide.date_begin}></td>
            <td class='center'><{$slide.date_end}></td>
            <td class='center'><{$slide.actif}></td>
            <td class='center'><{$slide.always_visible}></td>
            <td class='center'><{$slide.theme}></td>
            <td class='center'><img src="<{$slider_upload_url}>/images/slides/<{$slide.image}>" alt="slides" /></td>
        </tr>
        <{/foreach}>
    </tbody>
    <{/if}>
    <tfoot><tr><td>&nbsp;</td></tr></tfoot>
</table>



<script>

jQuery(document).ready(function(){
      $("#block_slides").parent().children('h4:first').html('');
});

a//lert("masquage du titre");
</script>

