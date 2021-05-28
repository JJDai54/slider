    <!-- Indicators -->
    <ol class="carousel-indicators">
        <{assign var="index" value="0"}>
        <{foreach item=slide from=$slides key=num_item}>
          <li <{if $index==0}>class="active"<{/if}> data-slide-to="<{$index}>" data-target="#myCarousel"></li>
          <{assign var=index value=$index+1}> 
        <{/foreach}>
        
    </ol>
    <div class="carousel-inner">
         <{assign var="index" value="0"}>
        <{foreach item=slide from=$slides key=num_item}>
          <div class="item <{if $index==0}> active<{/if}>" ><img alt="XOOPS" src="<{$slide.image_fullName}>">
              <div class="carousel-caption hidden-xs">
                  <h1 <{if $slide.style_title_name <> ''}>id="<{$slide.style_title_name}>"<{/if}> ><{$slide.title}></h1>
                  <p <{if $slide.style_description_name <> ''}>id="<{$slide.style_description_name}>"<{/if}> ><{$slide.description}></p>
                  <{if $slide.read_more != ''}>
                  <p><a <{if $slide.style_button_name <> ''}>id="<{$slide.style_button_name}>"<{/if}> href="javascript:location.href='<{$slide.read_more}>';" class="btn btn-large btn-primary" target='blank'>
                    <{if $slide.button_title <> ''}><{$slide.button_title}><{else}><{$smarty.const.THEME_READMORE}><{/if}>
                  </a></p>
                  <{/if}>                             
              </div>
          </div>
          <{assign var=index value=$index+1}>
        <{/foreach}>
        
    </div>
    
