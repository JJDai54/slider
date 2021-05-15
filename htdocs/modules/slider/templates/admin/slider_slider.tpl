    <!-- Indicators -->
    <ol class="carousel-indicators">
        <{assign var="index" value="0"}>
        <{foreach item=slide from=$slides key=num_item}>
          <li <{if $index==0}> class="active"<{/if}> data-slide-to="<{$index}>" data-target="#myCarousel"></li>
          <{assign var=index value=$index+1}> 
        <{/foreach}>
        
    </ol>
    <div class="carousel-inner">
         <{assign var="index" value="0"}>
        <{foreach item=slide from=$slides key=num_item}>
          <div class="item <{if $index==0}> active<{/if}>" ><img alt="XOOPS" src="<{$slide.image_fullName}>">
              <div class="carousel-caption hidden-xs">
                  <h1><{$slide.title}></h1>
                  <p><{$slide.description}></p>
                  <{if $slide.read_more != ''}>
                  <p><a href="javascript:location.href='<{$slide.read_more}>';" class="btn btn-large btn-primary" target='blank'><{$smarty.const.THEME_READMORE}></a></p>
                  <{/if}>                             
              </div>
          </div>
          <{assign var=index value=$index+1}>
        <{/foreach}>
        
    </div>
