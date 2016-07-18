<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    @include("layouts.navs.header", ["title" => "MAIN NAVIGATION"])
    @include("layouts.navs.level2", ["name" => "Layout Options", "active" => false, "num" => 4, "color" => "primary", "symbol" => "files-o", "children" => [["name" => "Top Navigation", "href" => "pages/layout/top-nav.html", "symbol" => "circle-o"], ["name" => "Boxed", "href" => "pages/layout/boxed.html", "symbol" => "circle-o"], ["name" => "Fixed", "href" => "ppages/layout/fixed.html", "symbol" => "circle-o"], ["name" => "Collapsed Sidebar", "href" => "pages/layout/collapsed-sidebar.html", "symbol" => "circle-o"],]])
    @include("layouts.navs.level1", ["href" => "pages/widgets.html", "name" => "Widgets", "symbol" => "th", "num" => "new", "color" => "green"])
    @include("layouts.navs.level2", ["name" => "Charts", "active" => false, "symbol" => "pie-chart", "children" => [["name" => "ChartJS", "href" => "pages/charts/chartjs.html", "symbol" => "circle-o"], ["name" => "Morris", "href" => "pages/charts/morris.html", "symbol" => "circle-o"], ["name" => "Flot", "href" => "pages/charts/flot.html", "symbol" => "circle-o"], ["name" => "Inline charts", "href" => "pages/charts/inline.html", "symbol" => "circle-o"],]])
    @include("layouts.navs.level2", ["name" => "UI Elements", "active" => false, "symbol" => "laptop", "children" => [["name" => "General", "href" => "pages/UI/general.html", "symbol" => "circle-o"], ["name" => "Icons", "href" => "pages/UI/icons.html", "symbol" => "circle-o"], ["name" => "Buttons", "href" => "pages/UI/buttons.html", "symbol" => "circle-o"], ["name" => "Sliders", "href" => "pages/UI/sliders.html", "symbol" => "circle-o"], ["name" => "Timeline", "href" => "pages/UI/timeline.html", "symbol" => "circle-o"], ["name" => "Modals", "href" => "pages/UI/modals.html", "symbol" => "circle-o"],]])
    @include("layouts.navs.level2", ["name" => "Forms", "active" => false, "symbol" => "edit", "children" => [["name" => "General Elements", "href" => "pages/forms/general.html", "symbol" => "circle-o"], ["name" => "Advanced Elements", "href" => "pages/forms/advanced.html", "symbol" => "circle-o"], ["name" => "Editors", "href" => "pages/forms/editors.html", "symbol" => "circle-o"],]])
    @include("layouts.navs.level2", ["name" => "Tables", "active" => false, "symbol" => "table", "children" => [["name" => "Simple tables", "href" => "pages/tables/simple.html", "symbol" => "circle-o"], ["name" => "Data tables", "href" => "pages/tables/data.html", "symbol" => "circle-o"],]])
    @include("layouts.navs.level1", ["href" => "pages/calendar.html", "name" => "Calendar", "symbol" => "calendar", "num" => 3, "color" => "blue"])
    @include("layouts.navs.level1", ["href" => "pages/mailbox/mailbox.html", "name" => "Mailbox", "symbol" => "envelope", "num" => 12, "color" => "yellow"])
    <li class="treeview">
        <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li>
                <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
        </ul>
    </li>
    <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
    <li class="header">LABELS</li>
    <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
</ul>