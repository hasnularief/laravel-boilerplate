<?php

namespace App\Views\Composers;

use Illuminate\view\View;
use Illuminate\Support\Facades\Cache;
use App\Menu;
use Carbon\Carbon;
use Route;

class SidebarMenuComposer
{

	protected $route;

	protected $path;
	
	protected $menu;

  protected $composed = "";

	public function compose(View $view) {
		$this->menu = $this->getRawMenu();

    $this->route = Route::currentRouteName();
		$this->path  = request()->pathInfo;
		$this->composeMenu($view);
	}

	private function composeMenu(View $view) {	
		$this->menu = $this->setActive();
		$this->generate($this->menu);
		$view->with('menu', $this->composed);
	}

  private function setActive($parent = null) {
    
    if(is_null($parent))
      $parent = $this->menu;

    for($i = 0; $i<count($parent); $i++) {
      if(isset($parent[$i]->children)){
        if($this->setActive($parent[$i]->children)){
          $parent[$i]->active = true; return $parent;
        }
      }
      
      if(isset($parent[$i]->route) && $parent[$i]->route == $this->route){
        $parent[$i]->active = true;
        return $parent;
      }
    }

    return false;

  }

  private function generate($menu) {
    $angle = '<span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>';
    
    if(!$menu)
      $menu = $this->getRawMenu();

    foreach($menu as $m) {
      if(is_object($m) && !isset($m->children) && $m->visibility) {
        $this->composed .= '<li ' . (isset($m->active) ? 'class="active"' : '') . '><a href="' . route($m->route) . '"><i class="' . $m->icon . '"></i><span> ' . $m->name . '</span></a></li>';
      }
      elseif(isset($m->children) && count($m->children) > 0 && $m->visibility) {
        $this->composed .=  '<li class="treeview ' . (isset($m->active) ? 'active menu-open' : '') . '">'.
                '<a href="#"><i class="' . $m->icon . '"></i> <span>' . $m->name . '</span>'.
                  '<span class="pull-right-container">'.
                    '<i class="fa fa-angle-left pull-right"></i>'.
                  '</span>'.
                '</a>'.
                '<ul class="treeview-menu">';
                  $this->generate($m->children);
        $this->composed .= '</ul></li>';
      }
    }
  }

  private function getRawMenu() {
    return [
          (object)[ 'name' => 'Dashboard', 'icon' => 'fa fa-dashboard', 'route' => 'home' , 'visibility' => false],
          (object)[
            'name' => 'Administrator', 'icon' => 'fa fa-folder',
            'visibility' => true,
            'children' => [
              (object)[ 'name' => 'Users', 'icon' => 'fa fa-users', 'route' => 'users' , 'visibility' => true],
              (object)[ 'name' => 'Roles', 'icon' => 'fa fa-circle-o', 'route' => 'roles' , 'visibility' => false],
            ]
          ]
         ];
  }


}
