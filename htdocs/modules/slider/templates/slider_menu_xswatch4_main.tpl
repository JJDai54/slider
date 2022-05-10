<{*
<{if $smarty.const.NEWS_SHOW_TPL_NAME==1 || true}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>
<{assign var="$catOk" value=($block.module.nbCatItems > 0)}>
*}>


    <{foreach from=$block.main key=kMenuList item=menuList}>
    
      <{* ////////////////////// level 0 - menu principal //////////////////// *}>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="xswatch-custom-menu"><{$block.module.lib}><b class="caret"></b></a>
      <div class="dropdown-menu" aria-labelledby="xswatch-custom-menu">
      

              <{foreach from=$menuList key=kItemMenu item=mainItem}>
                  <{if !empty($mainItem.submenu) }>
                      <div class="dropdown-submenu ">
                          <a class="dropdown-item" href="<{$mainItem.url}>"><{$mainItem.lib}></a>
                          <ul class="dropdown-menu dropdown-submenu">
                              <{foreach from=$mainItem.submenu key=kSubmenu1 item=subMenu1}>
                                <div class='dropdown-item' ><a href="<{$subMenu1.url}>"><{$subMenu1.lib}></a></div>
                              <{/foreach}>
                          </ul>
                      </div>
                  <{else}>
                    <div><a class="dropdown-item" href="<{$mainItem.url}>"><{$mainItem.lib}></a></div>  
                  <{/if}>
  
              <{/foreach}>
      
            <{if $block.module.nbCatItems > 0}><hr><{/if}>     

      </div>
      </li>
    <{/foreach}>