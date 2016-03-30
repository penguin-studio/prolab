<?php
add_action('penguin-footer','penguin_footer',10,2);
function penguin_footer($template_url,$pengstud_url){

    echo '
        <div class="penguin-footer-div">

                <span>Разработали в </span>
                <a href="'.$pengstud_url.'"><img src="'.$template_url.'pengstud-footer/logo.png"></a>
        </div>
    ';
}