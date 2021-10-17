    <!-- Indicators -->
    <!-- Fichier slider.tpl genere avec le module slider (JJDai) -->
    
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

<div id="sliderCarousel" class="<{$sldOptions.slider_transition}> carousel slide mb-4" data-ride="carousel"> 


  <ol class="carousel-indicators carousel-indicators-bis">
      <{assign var="index" value="0"}>
      <{foreach item=slide from=$slides key=num_item}>
        <li <{if $index==0}>class="active"<{/if}> data-slide-to="<{$index}>" data-target="#sliderCarousel"></li>
        <{assign var=index value=$index+1}> 
      <{/foreach}>
      
  </ol>
  
<{*
  <ol class="carousel-indicators carousel-indicators-bis">
      <{assign var="index" value="0"}>
      <{foreach item=slide from=$slides key=num_item}>
        <li <{if $index==0}>class="active"<{/if}> data-slide-to="<{$index}>" data-target="#myCarousel"></li>
        <{assign var=index value=$index+1}> 
      <{/foreach}>
      
  </ol>
*}>  
  
  
  <div class="carousel-inner">
       <{assign var="index" value="0"}>
      <{foreach item=slide from=$slides key=num_item}>       
          <{* <img src="<{$slide.image_fullName}>" ><br>  *}>   
          <div class="carousel-item <{if $index==0}> active<{/if}> " >       
                <img class="d-block w-100" src="<{$slide.image_fullName}>" alt="slide-<{$index}>">       

                <div class="carousel-caption d-none d-md-block">       
       
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
  
        <{* horizontal controls
        <a class="carousel-control-prev" href="#sliderCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"<{$smarty.const.THEME_CONTROL_PREVIOUS}>/span>
        </a>
        <a class="carousel-control-next" href="#sliderCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"<{$smarty.const.THEME_CONTROL_NEXT}>/span>
        </a>
        *}>
</div><!-- .carousel -->  
