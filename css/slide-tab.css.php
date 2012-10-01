/* TAB Settings */

#sliding-panel .tab {
    background: url(<?php sliding_panel_tab_b(); ?>) repeat-x 0 0;
  height: 42px;
  position: relative;
    top: 0;
    z-index: 999;
}

#sliding-panel .tab ul.login {
  display: block;
  position: relative;
    float: right;
    clear: right;
    height: 42px;
  width: auto;
  line-height: 42px;
  margin: 0;
  right: 150px;
  text-align: center;
}

#sliding-panel .tab ul.login li.left {
    background: url(<?php sliding_panel_tab_l(); ?>) no-repeat left 0;
    height: 42px;
  width: 30px;
  padding: 0;
  margin: 0;
    display: block;
  float: left;
}

#sliding-panel .tab ul.login li.right {
    background: url(<?php sliding_panel_tab_r(); ?>) no-repeat left 0;
    height: 42px;
  width: 30px;
  padding: 0;
  margin: 0;
    display: block;
  float: left;
}

#sliding-panel .tab ul.login li {
  text-align: left;
    padding: 0 6px;
  display: block;
  float: left;
  height: 42px;
    margin:0;
    background: url(<?php sliding_panel_tab_m(); ?>) repeat-x 0 0;
}

#sliding-panel .tab {
    font-family: <?php $ff('tab'); ?>;
    font-size: <?php $fs('tab'); ?>;
    font-weight: <?php $fw('tab'); ?>;
    font-style: <?php $fst('tab'); ?>;
}


#sliding-panel .tab ul.login {
    color: <?php $c('tab_link_hover'); ?>;
}

#sliding-panel .tab .sep {
  color:#414141
}

#sliding-panel .tab ul.login li a {
  color: <?php $c('tab_link'); ?>;
}

#sliding-panel .tab ul.login li a:hover {
  color: <?php $c('tab_link_hover'); ?>;
}

#sliding-panel .tab a.open, #sliding-panel .tab a.close {
  height: 20px;
  line-height: 20px !important;
  padding-left: 30px !important;
  cursor: pointer;
  display: block;
  position: relative;
  top: 11px;
}

#sliding-panel .tab a.open {background: url(<?php echo plugins_url('images/bt_open.png', __FILE__); ?>) no-repeat left 0;}
#sliding-panel .tab a.close {background: url(<?php echo plugins_url('images/bt_close.png', __FILE__); ?>) no-repeat left 0;}
#sliding-panel .tab a:hover.open {background: url(<?php echo plugins_url('images/bt_open.png', __FILE__); ?>) no-repeat left -19px;}
#sliding-panel .tab a:hover.close {background: url(<?php echo plugins_url('images/bt_close.png', __FILE__); ?>) no-repeat left -19px;}


