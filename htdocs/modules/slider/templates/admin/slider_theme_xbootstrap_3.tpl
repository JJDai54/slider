    <!-- Indicators -->
<style>
.carousel-indicators-bis li {
<{$sldOptions.slider_style_points}>
}
.carousel-indicators-bis .active {
<{$sldOptions.slider_style_point_active}>

}

@keyframes <{$sldOptions.clignotement_name}> {
<{$sldOptions.slider_style_clignotement}>
}
</style>

<div id="myCarousel" class="carousel slide slideshow" data-ride="carousel">

  <ol class="carousel-indicators carousel-indicators-bis">
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
              <{if $slide.subtitle <> ''}>
                <h1 <{if $slide.style_title_name <> ''}>id="<{$slide.style_title_name}>"<{/if}> ><{$slide.title}></h1>
                <div <{if $slide.style_subtitle_name <> ''}>id="<{$slide.style_subtitle_name}>"<{/if}> ><{$slide.subtitle}></div>
              <{else}>
                <div <{if $slide.style_title_name <> ''}>id="<{$slide.style_title_name}>"<{/if}> ><{$slide.title}></div>
              <{/if}>
              
                <{if $slide.read_more != ''}>
                <p><a <{if $slide.style_button_name <> ''}>id="<{$slide.style_button_name}>"<{/if}> href="<{$slide.read_more}>" class="btn btn-large btn-primary" target='_blank'>
                  <{if $slide.button_title <> ''}><{$slide.button_title}><{else}><{$smarty.const.THEME_READMORE}><{/if}>
                </a></p>
                <{/if}>                             
            </div>
        </div>
        <{assign var=index value=$index+1}>
      <{/foreach}>
      
      
  </div>

  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="icon-prev"></span></a>
  <a data-slide="next" href="#myCarousel" class="right carousel-control"><span class="icon-next"></span></a>
</div><!-- .carousel -->  
