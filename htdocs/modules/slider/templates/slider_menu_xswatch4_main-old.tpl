<{*
<{if $smarty.const.NEWS_SHOW_TPL_NAME==1 || true}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>
<{assign var="$catOk" value=($block.module.nbCatItems > 0)}>
*}>


<{if $block.module.level == 1}>
            <{* ///////////////// level 1 - sousmenu //////////////////// *}>

      <div class="dropdown-submenu ">
  <{if $block.module.nbMainMenu > 0}>
          <a class="dropdown-item" href="#" ><{$block.module.lib}></a>
          <ul class="dropdown-menu dropdown-submenu">
              <{foreach from=$block.main key=kItem item=mainItem}>
                  <{if !empty($mainItem.submenu) }>
                    <div class="dropdown-submenu ">
                        <a class="dropdown-item" href="<{$mainItem.url}>"><{$mainItem.lib}></a>
                        <ul class="dropdown-menu dropdown-submenu">
                            <{foreach from=$mainItem.submenu key=kSubmenu item=subMenu}>
                              <li><a href="<{$subMenu.url}>"><{$subMenu.lib}></a></li>
                            <{/foreach}>
                        </ul>
                    </div>
                  <{else}>
                    <li><a class="dropdown-item" href="<{$mainItem.url}>"><{$mainItem.lib}></a></li>  
                  <{/if}>
              <{/foreach}>
      <{if $block.module.nbCatItems > 0}>
        <hr>
      <{else}>  
          </ul>
      <{/if}>     
  <{/if}>
    <{* ******************************************************************* *}>
    <{if $block.module.nbCatItems > 0 }>
        <{if $block.module.nbMainMenu == 0}>
          <ul class="dropdown-menu dropdown-submenu">
                        <a class="dropdown-item" href="<{$catItem.url}>">4444444</a>
        <{/if}>     
            <{foreach from=$block.catItems key=k item=catItem}>
                <{if !empty($catItem.submenu) }>
                    <div class="dropdown-submenu ">
                        <a class="dropdown-item" href="<{$catItem.url}>"><{$catItem.lib}></a>
                        <ul class="dropdown-menu dropdown-submenu">
                            <{foreach from=$catItem.submenu key=kSubmenu item=subMenu}>
                                <li><a class="dropdown-item" href="<{$subMenu.url}>"><{$subMenu.lib}></a></li>
                            <{/foreach}>
                        </ul>
                    </div>
                <{else}>
                  <li><a class="dropdown-item" href="<{$catItem.url}>"><{$catItem.lib}></a></li>
                <{/if}>
            <{/foreach}>
      <{if $block.module.nbMainMenu > 0}>
      <{/if}>
            </ul>
    
    <{/if}>
      </div>

<{else}>
    <{* ////////////////////// level 0 - menu principal //////////////////// *}>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="xswatch-custom-menu"><{$block.module.lib}><b class="caret"></b></a>
    <div class="dropdown-menu" aria-labelledby="xswatch-custom-menu">
    
    <{if $block.module.nbMainMenu > 0}>
            <{foreach from=$block.main key=kItem item=mainItem}>
                <{if !empty($mainItem.submenu) }>
                    <div class="dropdown-submenu ">
                        <a class="dropdown-item" href="<{$catItem.url}>"><{$catItem.lib}></a>
                        <ul class="dropdown-menu dropdown-submenu">
                            <{foreach from=$mainItem.submenu key=kSubmenu item=subMenu}>
                              <div><a href="<{$subMenu.url}>"><{$subMenu.lib}></a></div>
                            <{/foreach}>
                        </ul>
                    </div>
                <{else}>
                  <div><a class="dropdown-item" href="<{$mainItem.url}>"><{$mainItem.lib}></a></div>  
                <{/if}>
            <{/foreach}>
    
          <{if $block.module.nbCatItems > 0}><hr><{/if}>     
    <{/if}>
        
    <{* ******************************************************************* *}>
    
    <{if $block.module.nbCatItems > 0 }>
            <{foreach from=$block.catItems key=k item=catItem}>
                <{if !empty($catItem.submenu) }>
                    <div class="dropdown-submenu ">
                        <a class="dropdown-item" href="<{$catItem.url}>"><{$catItem.lib}></a>
                        <ul class="dropdown-menu dropdown-submenu">
                            <{foreach from=$catItem.submenu key=kSubmenu item=subMenu}>
                                <li><a class="dropdown-item" href="<{$subMenu.url}>"><{$subMenu.lib}>ooooooo</a></li>
                            <{/foreach}>
                        </ul>
                    </div>
                <{else}>
                  <a class="dropdown-item" href="<{$catItem.url}>"><{$catItem.lib}></a>
                <{/if}>
            <{/foreach}>
    
    <{/if}>
    </div>
    </li>
<{/if}>

