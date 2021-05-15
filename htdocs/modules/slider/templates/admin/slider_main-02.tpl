<{if $xoops_page == "index"}>

<style>
#logo-sgdb91 {
 position:absolute;
 top:0;
 right:0;

}
</style>



<!-- ********************** -->

<div id="myCarousel" class="carousel slide slideshow" data-ride="carousel">

    __Slides__

    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="icon-prev"></span></a>
    <a data-slide="next" href="#myCarousel" class="right carousel-control"><span class="icon-next"></span></a>



<{if $xoops_page == "index"}>
<{* JJDai - Ajout d'une 2eme banniere *}>
<style>
.banniere{
  position: absolute;
  /* left: 1250px; */
  right: 50px;
  /* top: 485px; */
  bottom: 10px;
}
.banniere_cds{
  position: absolute;
  /* left: 1250px; */
  left: 380px;
  //right: 150px;
  /* top: 485px; */
  bottom: 10px;
}

</style>

    <{if $xoops_banner != ""}>
        <div class="banniere">
          <{$xoops_banner}>
        </div>
    <{/if}>

    <{if $xoops_banner_cds != ""}>
        <div class="banniere_cds">
          <{$xoops_banner_cds}>
        </div>
    <{/if}>

<{/if}>


</div><!-- .carousel -->
<{/if}>

