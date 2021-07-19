<?php


use App\Models\Permission;
use Illuminate\Support\Facades\Route;


// display routes
function sidebar()
{
    $routes         = Route::getRoutes();
    $routes_data    = [];
    $my_routes      = Permission::where('role_id', auth()->user()->role_id)->pluck('permission')->toArray();
    foreach ($routes as $route) {
        if ($route->getName())
            $routes_data['"'.$route->getName().'"'] = [
                'title'     => isset($route->getAction()['title']) ? $route->getAction()['title'] : null,
                'subTitle'  => isset($route->getAction()['subTitle']) ? $route->getAction()['subTitle'] : null,
                'icon'      => isset($route->getAction()['icon']) ? $route->getAction()['icon'] : null,
                'subIcon'   => isset($route->getAction()['subIcon']) ? $route->getAction()['subIcon'] : null,
                'name'      => $route->getName() ?? null,
            ];
    }


    foreach ($routes as $value) {
        if ($value->getName() !== null) {

            //display only parent routes
            if (isset($value->getAction()['title']) && isset($value->getAction()['icon']) && isset($value->getAction()['type']) && $value->getAction()['type'] == 'parent') {


                //display route with sub directory
                if (isset($value->getAction()['sub_route']) && $value->getAction()['sub_route'] == true && isset($value->getAction()['child']) && count($value->getAction()['child'])) {

                    // check user auth to access this route
                    if (in_array($value->getName(), $my_routes)) {


                        //check if this is the current opened
                        $active     = '';
                        $opend      = '';
                        $child_name = substr(Route::currentRouteName(), 6);
                        if(in_array($child_name, $value->getAction()['child'])){
                            $active = 'kt-menu__item--active';
                            $opend  = 'kt-menu__item--open';
                        }

                        echo '<li class="kt-menu__item kt-menu__item--submenu ' . $opend . '" >
                                <a href="#" class="kt-menu__link kt-menu__toggle" aria-haspopup="false" data-ktmenu-submenu-toggle="hover"><span class="kt-menu__link-icon"><div class="kt-demo-icon__preview kt-menu__link-text"><img src="' . $value->getAction()['icon'] . '"  width="23px" alt="" srcset=""/></div></span> <span class="kt-menu__link-text"> ' . $value->getAction()['title'] . ' </span> <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu " kt-hidden-height="120" style=""><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">';


                        // display child sub directories
                        foreach ($value->getAction()['child'] as $child){
                            if (isset($routes_data['"admin.' . $child . '"']) && $routes_data['"admin.' . $child . '"']['title'] && $routes_data['"admin.' . $child . '"']['icon'] && Permission::where('permission',"admin.$child")->exists())
                                echo '<li aria-haspopup="true" data-ktmenu-submenu-toggle="hover" class="kt-menu__item  kt-menu__item--submenu ">
                                    <a href="' . route('admin.'.$child) . '" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i> <span class="kt-menu__link-text"> ' . $routes_data['"admin.' . $child . '"']['title'] . ' </span>
                                    </a></li>';

                        }

                        echo '</ul></div>
                                </li>';
                    }
                } else {

                    if (in_array($value->getName(), $my_routes)) {
                        $active = $value->getName() == Route::currentRouteName() ? 'kt-menu__item--active' : '';

                        echo '<li class="kt-menu__item  kt-menu__item--submenu ' . $active . '" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="' . route($value->getName()) . '" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon"><div class="kt-demo-icon__preview kt-menu__link-text"><img src="' . $value->getAction()['icon'] . '"  width="23px" alt="" srcset=""/></div></span> <span class="kt-menu__link-text"> ' . $value->getAction()['title'] . ' </span> </a></li>';
                    }
                }
            }
        }
    }
}

function addRole()
{

    $routes = Route::getRoutes();
    $routes_data = [];
    $id = 0;
    foreach ($routes as $route)
        if ($route->getName())
            $routes_data['"' . $route->getName() . '"'] = ['title' => isset($route->getAction()['title']) ? $route->getAction()['title'] : null];

    foreach ($routes as $value) {

        if (isset($value->getAction()['title']) && isset($value->getAction()['type']) && $value->getAction()['type'] == 'parent') {


            $parent_class = 'gtx_' . $id++;
            echo '


                    <div class="col-md-3 px-xl-3">
                        <div class="card package bg-white shadow">
                            <div class="role-title text-white">
                                <div>
                                    <div class="icheck-primary d-inline mx-2">
                                        <input type="checkbox" name="permissions[]" value="' . $value->getName() . '" id="' . $parent_class . '" class="roles-parent">
                                        <label for="' . $parent_class . '" dir="ltr"></label>
                                    </div>
                                    <label for="' . $parent_class . '">' . $value->getAction()["title"] . '</label>
                                </div>
                            </div>';


            if (isset($value->getAction()['child']) && count($value->getAction()['child'])) {

                echo '<ul class="list-unstyled p-3">';

                foreach ($value->getAction()['child'] as $key => $child) {


                    echo '<li>
                             <div class="form-group clearfix">
                                <div class="icheck-primary d-inline mx-2">
                                    <input type="checkbox"  name="permissions[]" value="admin.' . $child . '"  id="' . $value->getName() . $key . '" class="' . $parent_class . '">
                                    <label for="' . $value->getName() . $key . '" dir="ltr"></label>
                                </div>
                                <label for="' . $value->getName() . $key . '"> ' . $routes_data['"admin.' . $child . '"']['title'] . '</label>
                            </div>

                        </li>';
                }
                echo '</ul>';
            }

            echo '</div></div>';
        }
    }
}

function editRole($id)
{

    $routes         = Route::getRoutes();
    $routes_data    = [];
    $my_routes      = Permission::where('role_id', $id)->pluck('permission')->toArray();
    $id = 0;
    foreach ($routes as $route)
        if ($route->getName())
            $routes_data['"' . $route->getName() . '"'] = ['title' => isset($route->getAction()['title']) ? $route->getAction()['title'] : null];

    foreach ($routes as $value) {

        if (isset($value->getAction()['title']) && isset($value->getAction()['type']) && $value->getAction()['type'] == 'parent') {

            $select = in_array($value->getName(), $my_routes)  ? 'checked' : '';
            $parent_class = 'gtx_' . $id++;
            echo '


                    <div class="col-md-3 px-xl-3">
                        <div class="card package bg-white shadow">
                            <div class="role-title text-white">
                                <div >
                                    <div class="icheck-primary d-inline  mx-2" >
                                            <input type="checkbox" name="permissions[]" value="' . $value->getName() . '" id="' . $parent_class . '" class="roles-parent" ' . $select . '>
                                            <label for="' . $parent_class . '" dir="ltr"></label>
                                    </div>
                                    <label for="' . $parent_class . '">' . $value->getAction()["title"] . '</label>
                                </div>
                            </div>';



            if (isset($value->getAction()['child']) && count($value->getAction()['child'])) {

                echo '<ul class="list-unstyled p-3">';

                foreach ($value->getAction()['child'] as $key => $child) {
                    $select = in_array('admin.' . $child, $my_routes)  ? 'checked' : '';
                    echo '<li>
                             <div class="form-group clearfix">
                                <div class="icheck-primary d-inline" mx-2>
                                    <input type="checkbox"  name="permissions[]" value="admin.' . $child . '"  id="' . $value->getName() . $key . '" class="' . $parent_class . '" ' . $select . '>
                                    <label for="' . $value->getName() . $key . '" dir="ltr"></label>
                                </div>
                                 <label for="' . $value->getName() . $key . '"> ' . $routes_data['"admin.' . $child . '"']['title'] . '</label>
                            </div>

                        </li>';
                }
                echo '</ul>';
            }

            echo '</div></div>';
        }
    }
}
