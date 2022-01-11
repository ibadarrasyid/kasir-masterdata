<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
            
            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                <img src="<?= $imglogin ?>" alt="me" class="online" /> 
                <span>
                    <?= $spanlogin ?>
                    <small><?= $subLeftTitle ?></small>
                </span>
            </a> 
            
        </span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive-->
    <nav>
        <!-- 
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->

        <ul>

            <?php
            foreach ($page_nav as $key => $nav_item) {
                //process parent nav
                $nav_htm = $adasub = $arrow = '';
                $url = (isset($nav_item["url"]) && $nav_item["url"] != '#') ? 'href="' . $nav_item["url"] . '"' : 'href="#"';
                $icon = isset($nav_item["icon"]) ? '<i class="fa ' . $nav_item["icon"] . '"></i>' : "";
                $nav_title = isset($nav_item["title"]) ? $nav_item["title"] : "(No Name)";
                $nav_name = isset($nav_item["name"]) ? $nav_item["name"] : "(No Name)";
                if (isset($nav_item["sub"]) && $nav_item["sub"]) {
                    // $arrow = '<b class="caret pull-right"></b>';
                }
                $nav_htm .= '<a ' . $url . ' title="' . $nav_title . '">' . $icon . '<span class="menu-item-parent">' . $nav_name . '</span></a>';

                if (isset($nav_item["sub"]) && $nav_item["sub"]) {
                    $nav_htm .= process_sub_nav($nav_item["sub"]);
                    // $adasub = 'class="has-sub"';
                    $adasub = '';
                }
                echo '<li ' . $adasub . (isset($nav_item["active"]) ? $nav_item["active"] : '') . '>' . $nav_htm . '</li>';
            }

            function process_sub_nav($nav_item) {
                $sub_item_htm = "";
                if (isset($nav_item["sub"]) && $nav_item["sub"]) {
                    $sub_nav_item = $nav_item["sub"];
                    $sub_item_htm = process_sub_nav($sub_nav_item);
                } else {
                    $sub_item_htm .= '<ul class="sub-menu">';
                    foreach ($nav_item as $key => $sub_item) {
                        $url = isset($sub_item["url"]) ? $sub_item["url"] : "javascript:;";
                        $icon = isset($sub_item["icon"]) ? '<i class="fa ' . $sub_item["icon"] . '"></i>' : "";
                        $nav_title = isset($sub_item["title"]) ? $sub_item["title"] : "(No Name)";
                        $nav_name = isset($sub_item["name"]) ? $sub_item["name"] : "(No Name)";
                        $label_htm = isset($sub_item["label_htm"]) ? $sub_item["label_htm"] : "";
                        $sub_item_htm .= '<li ' . (isset($sub_item["active"]) ? 'class = "active"' : '') . '><a id="menu_nav" title="' . $nav_title . '" href="' . $url . '">' . $icon . ' ' . $nav_name . $label_htm . '</a>' . (isset($sub_item["sub"]) ? process_sub_nav($sub_item["sub"]) : '') . '</li>';
                    }
                    $sub_item_htm .= '</ul>';
                }
                return $sub_item_htm;
            }
            ?>
        </ul>
    </nav>
    

    <span class="minifyme" data-action="minifyMenu"> 
        <i class="fa fa-arrow-circle-left hit"></i> 
    </span>

</aside>
<!-- END NAVIGATION -->