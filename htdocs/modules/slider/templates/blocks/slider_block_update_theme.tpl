<div id='block_slides' name='block_slides' class='media_block' width="100%">

<{if $block.hide}>
<script>

jQuery(document).ready(function(){
      //$("#block_slides").parent().children('h4:first').html('');
      $("#block_slides").parent().hide();
});

//alert("masquage du titre");
</script>

<{else}>

    <center><b><{$smarty.const._MB_SLIDER_SELECTED}></b></center>
    <center><b><{$block.generation}></b></center>
    <center><b><{$block.now}></b></center>


    
    <table class='table table-<{$table_type}>'>
        <thead>
            <tr class='head'>
                <th>&nbsp;</th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_SHORT_NAME}></th>
                <{* <th class='center'><{$smarty.const._MB_SLIDER_SLD_TITLE}></th> *}>
                <{* <th class='center'><{$smarty.const._MB_SLIDER_SLD_SUBTITLE}></th> *}>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_WEIGHT}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_ACTIF}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_HAS_PERIODE}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_DATE_BEGIN}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_DATE_END}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_THEME}></th>
                <th class='center'><{$smarty.const._MB_SLIDER_SLD_IMAGE}></th>
            </tr>
        </thead>
        <{if count($block)}>
        <tbody>
            <{foreach item=slide from=$block.slides}>
            <tr class='<{cycle values="odd, even"}>'>
                <td class='center'><{$slide.id}></td>
                <td class='center'><{$slide.short_name}></td>
                <{* <td class='center'><{$slide.title}></td> *}>
                <{* <td class='center'><{$slide.subtitle}></td> *}>
                <td class='center'><{$slide.weight}></td>
                <td class='center'><{$slide.actif_yn}></td>
                <td class='center'><{$slide.periodicity_yn}></td>
                <td class='center'><{$slide.str_date_begin}></td>
                <td class='center'><{$slide.str_date_end}></td>
                <td class='center'><{$slide.theme}></td>
                <td class='center'><img src="<{$slider_upload_url}>/images/slides/<{$slide.image}>" alt="slides" width='150px'> /</td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
        <tfoot><tr><td>&nbsp;</td></tr></tfoot>
    </table>
<{/if}>

</div>