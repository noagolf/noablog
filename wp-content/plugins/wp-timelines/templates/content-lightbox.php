
<div class="extl-lightbox-info">
	<div class="lb-image"><?php the_post_thumbnail('full'); ?></div>
    <div class="lb-info">
        <h3 class="lb-title"><?php the_title(); ?></h3>
        <?php
        echo '<span><i class="fa fa-calendar"></i>'.wpex_date_tl().'</span>';
        if(exwptl_get_option('exwptl_disable_social','exwptl_advanced_options')!='yes'){?>
        	<div class="wpex-social-share"><?php  echo wptl_social_share();?></div>
        <?php }?>
        <div class="exp-lightbox-meta"></div>
        <p><?php the_content(); ?></p>
    </div>
</div>