<?php
namespace MBN;

/**
 * Get the menu by location slug and use it's data
 */
class Menu
{

	public $all_menu_items = false;
	public $menu_name;
	public $menu_location_slug;
	public $level_two_parents = array();
	public $level_one_menu = array();
	public $level_two_menus = array();
	public $level_three_menus = array();
	public $current_level_two_menu = false;
	public $current_level_three_menu = false;
	private $current_post_id;
	private $current_post_permalink;
	private $parent_of_menu_level_two;
	private $parent_of_menu_level_three;
	private $current_item_id;


	function __construct( $menu_location_slug, $role )
	{
		$this->menu_location_slug = $menu_location_slug;

		$this->set_all_menu_items();

		$this->current_post_id = get_the_ID();

		$this->current_post_permalink = $this->get_base_url( get_the_permalink() );

		$this->dispatch_menu_items_in_arrays( $role );

		$this->set_the_current_submenu();
	}


	private function set_all_menu_items()
	{
		if ( !( $locations = get_nav_menu_locations() ) || !isset( $locations[ $this->menu_location_slug ] ) )
			return;

		$menu = wp_get_nav_menu_object( $locations[ $this->menu_location_slug ] );

		if( !$menu )
			return;

		$this->menu_name = $menu->name;

		$this->all_menu_items = wp_get_nav_menu_items($menu->term_id);
	}


	private function set_current_item_id( $menu_item )
	{
		$this->current_item_id = $menu_item->ID;
	}


	private function get_base_url( $url )
	{
		$menu_item_parse_url = parse_url($url);
		if( isset($menu_item_parse_url['host']) && isset($menu_item_parse_url['path']) )
			return rtrim($menu_item_parse_url['host'] . $menu_item_parse_url['path'], '/');

		return rtrim($url, '/');
	}


	private function set_parent_of_menu_level_two_and_three( $menu_item, $level = 2 )
	{

		if( (empty( $this->current_post_id ) || $menu_item->object_id != $this->current_post_id) && $menu_item->object != 'custom' )
			return;

		if($menu_item->object == 'custom'){
			$menu_item_base_url = $this->get_base_url( $menu_item->url );
			if( $menu_item_base_url != $this->current_post_permalink )
				return;
		}

		$this->set_current_item_id( $menu_item );

		if( $menu_item->menu_item_parent == 0 ){

			$this->parent_of_menu_level_two = $menu_item->ID;

		} else {

			if( $level == 2 ){
				$this->parent_of_menu_level_two = $menu_item->menu_item_parent;
				$this->parent_of_menu_level_three = $menu_item->ID;
			}

			if( $level == 3 ){
				$this->parent_of_menu_level_two = $this->level_two_parents[$menu_item->menu_item_parent];
				$this->parent_of_menu_level_three = $menu_item->menu_item_parent;
			}

		}

	}


	private function add_menu_item_to_level_two_array( $menu_item )
	{
		$this->level_two_parents[$menu_item->ID] = $menu_item->menu_item_parent;

		if( !isset($this->level_two_menus[$menu_item->menu_item_parent]) )
			$this->level_two_menus[$menu_item->menu_item_parent] = array();

		array_push($this->level_two_menus[$menu_item->menu_item_parent], $menu_item);
	}


	private function set_current_item_class( $menu_item, $class = 'current-menu-item' )
	{
		if( $this->current_item_id == $menu_item->ID || $this->parent_of_menu_level_two == $menu_item->ID || $this->parent_of_menu_level_three == $menu_item->ID )
			echo $class;
	}


	private function add_menu_item_to_level_one_array( $menu_item )
	{
		array_push($this->level_one_menu, $menu_item);
	}

	private function add_menu_item_to_level_three_array( $menu_item )
	{
		if( !isset($this->level_three_menus[$menu_item->menu_item_parent]) )
			$this->level_three_menus[$menu_item->menu_item_parent] = array();

		array_push($this->level_three_menus[$menu_item->menu_item_parent], $menu_item);
	}

	private function dispatch_menu_items_in_arrays( $role )
	{
		if( !$this->all_menu_items )
			return;

		$last_level_two_item_id = 0;
		$level_three = false;
		foreach ( $this->all_menu_items as $menu_item ) {

			if( $menu_item->menu_item_parent != 0 ){
				if( $menu_item->menu_item_parent == $last_level_two_item_id ){
					$level_three = true;
				} else {
					$level_three = false;
					$last_level_two_item_id = $menu_item->ID;
				}
			}

			$level = $level_three ? 3 : 2;

			$this->set_parent_of_menu_level_two_and_three( $menu_item, $level );

			$item_access_role = carbon_get_nav_menu_item_meta($menu_item->ID, 'menu_access_roles');
			// $item_access_role[] = "administrator";
			if( $item_access_role && !in_array($role, $item_access_role) && $role != "administrator" && $role != "enedis-admin" )
				continue;

			if( $menu_item->menu_item_parent != 0 ){
				if($level_three){
					$this->add_menu_item_to_level_three_array($menu_item);
				} else {
					$this->add_menu_item_to_level_two_array($menu_item);
				}
				continue;
			}

			$this->add_menu_item_to_level_one_array( $menu_item );

		}
	}


	private function get_menu_item_url( $menu_item, $level = 1 )
	{
		if( $level == 1 && $menu_item->url == '#' && isset($this->level_two_menus[ $menu_item->ID ]) )
			return $this->level_two_menus[ $menu_item->ID ][0]->url;

		if( $level == 2 && $menu_item->url == '#' && isset($this->level_three_menus[ $menu_item->ID ]) )
			return $this->level_three_menus[ $menu_item->ID ][0]->url;

		return $menu_item->url;
	}


	public function display_menu_level_one($location = 'header')
	{
		if( !$this->all_menu_items )
			return;

		if( $location == 'header' ): ?>

			<ul class="menu-list">

				<?php
				foreach ($this->level_one_menu as $menu_item) {

					$menu_item_url = $this->get_menu_item_url( $menu_item ); ?>

					<li class="menu-item <?php $this->set_current_item_class( $menu_item ); ?>">
						<a href="<?= $menu_item_url ?>">
							<span><?= $menu_item->title ?></span>
						</a>
					</li>

				<?php
				} ?>

			</ul>

		<?php
		elseif( $location == 'footer' ): ?>

			<ul class="footer-nav">

				<?php
				foreach ($this->level_one_menu as $menu_item) {
					$menu_item_url = $this->get_menu_item_url( $menu_item ); ?>

					<li>
						<a href="<?= $menu_item_url ?>"><?= $menu_item->title ?></a>
					</li>

				<?php
				} ?>

			</ul>

		<?php
		endif;
	}


	private function set_the_current_submenu()
	{
		if( isset($this->level_two_menus[$this->parent_of_menu_level_two]) ){

			$level_two_menu = $this->level_two_menus[$this->parent_of_menu_level_two];

			if( sizeof($level_two_menu) > 0 )
				$this->current_level_two_menu = $level_two_menu;

		}

		if( isset($this->level_three_menus[$this->parent_of_menu_level_three]) ){

			$level_three_menu = $this->level_three_menus[$this->parent_of_menu_level_three];

			if( sizeof($level_three_menu) > 0 )
				$this->current_level_three_menu = $level_three_menu;

		}
	}


	public function display_menu_level_two()
	{
		if( !$this->current_level_two_menu )
			return; ?>

		<ul class="sitenav--level-two_menu-list">

			<?php
			foreach ($this->current_level_two_menu as $menu_item) {

				$menu_item_url = $this->get_menu_item_url( $menu_item, 2 ); ?>

					<li class="menu-item <?php $this->set_current_item_class( $menu_item ); ?>">
						<a href="<?= $menu_item_url ?>"><span><?= $menu_item->title ?></span></a>
					</li>

			<?php
			} ?>

		</ul>

	<?php
	}


	public function display_menu_level_three()
	{
		if( !$this->current_level_three_menu )
			return; ?>

		<ul id="sidenav--level-three" class="sidenav--level-three">

			<?php
			foreach ($this->current_level_three_menu as $menu_item) { ?>

					<li class="menu-item <?php $this->set_current_item_class( $menu_item, 'current' ); ?>">
						<a href="<?= $menu_item->url ?>"><span><?= $menu_item->title ?></span></a>
					</li>

			<?php
			} ?>

		</ul>

	<?php
	}


	private function render_mobile_submenu_items( $parent_item_id )
	{
		if( !$parent_item_id )
			return; ?>

    <div class="item-link-arrow"></div>
    <ul class="submenu">

			<?php foreach ($this->level_two_menus[ $parent_item_id ] as $menu_item) { ?>

				<li class="submenu-item <?php $this->set_current_item_class( $menu_item ); ?>">
					<a href="<?= $menu_item->url ?>">
						<span><?= $menu_item->title ?></span>
					</a>
				</li>

			<?php	} ?>

		</ul>

	<?php
	}


	public function display_menu_mobile()
	{
		if( !$this->all_menu_items )
			return; ?>

		<ul class="fwmb-menu--nav fwmb-menuopen">

			<?php
			foreach ($this->level_one_menu as $menu_item) {
				$parent_item_id = isset($this->level_two_menus[ $menu_item->ID ]) ? $menu_item->ID : false;
				$has_children_class = $parent_item_id ? 'menu-item-has-children' : '';
				$menu_item_url = $this->get_menu_item_url( $menu_item ); ?>

				<li class="menu-item <?= $has_children_class ?> <?php $this->set_current_item_class( $menu_item ); ?>">
					<a href="<?= $menu_item_url ?>">
						<span><?= $menu_item->title ?></span>
					</a>

					<?php $this->render_mobile_submenu_items( $parent_item_id ); ?>
				</li>

			<?php
			} ?>

		</ul>

	<?php
	}

}
?>
