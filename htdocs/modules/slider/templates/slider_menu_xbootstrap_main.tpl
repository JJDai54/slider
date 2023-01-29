<{if $smarty.const.SLIDER_SHOW_TPL_NAME==1}>
<div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>


<{if $block.module.level == 0}>
  <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"><{$block.module.lib}><b class="caret"></b></a>
      <ul class="dropdown-menu">
<{/if}>

    <{foreach from=$block.main key=kMenuList item=menuList}>
       
        <{* <{if $kMenuList > 0 AND $block.module.level == 0}><{/if}> *}>
        <{foreach from=$menuList key=kItemMenu item=itemMenu}>
            <{if !empty($itemMenu.submenu) }>
              <li class="dropdown-submenu">
                <a href="<{$itemMenu.url}>"><{$itemMenu.lib}></a>
                <ul class="dropdown-menu">
                  <{foreach from=$itemMenu.submenu key=kSubmenu1 item=submenu1}>
                  <{* ======================================== *}>
                  <{if !empty($submenu1.submenu) }>
                    <li class="dropdown-submenu">
                      <a href="<{$submenu1.url}>"><{$submenu1.lib}></a>
                      <ul class="dropdown-menu">
                        <{foreach from=$submenu1.submenu key=kSubmenu2 item=submenu2}>
                          <li><a href="<{$submenu2.url}>"><{$submenu2.lib}></a></li>
                        <{/foreach}>
                      </ul>
                    </li>
            
                  <{else}>
                    <li><a href="<{$submenu1.url}>"><{$submenu1.lib}></a></li>
                  <{/if}>
                  <{* ======================================== *}>
                  <{/foreach}>
                </ul>
              </li>
      
            <{else}>
              <li><a href="<{$itemMenu.url}>"><{$itemMenu.lib}></a></li>
            <{/if}>
        <{/foreach}>
        
    <{/foreach}>
        
<{if $block.module.level == 0}>
      </ul>
  </li>
<{/if}>
