<?php
class oii_walker_nav_menu extends Walker_Nav_Menu {
	/**
	 * What the class handles.
	 *
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	public $count = 0;
	
	public $level = 0;
	
	public $index = 0;
	
	public $mega_menu_item_count = 0;
	
	public $left = false;
	
	public $right = false;
	
	public $separator = false;
	
	public $mega_menu = false;
	
	public $mega_index = 0;
	
	public $mega_menu_id;
	
	public $items = array();
	
	public $all_items = array();
	
	public $menu_items = array();
	
	public $mega_menu_items = array();
	
	public $mega_menu_ids = array();
	
	//Pass menu items from wp_nav_menu 
	public function __construct($menuitems){
	    $this->items = $menuitems;
	    
	    $itemindex = 0;
	    
	    if (!empty($this->items)){
		foreach($this->items as $item) {
		    $itemindex++;
		    $this->all_items[] = (object)array(
					    'index' => $itemindex,
					    'id' => $item->ID,
					    'title' => $item->title,
					    'parent' => $item->menu_item_parent,
					    'haschildren' => in_array('menu-item-has-children',$item->classes)
					    );
		}
	    }
	}
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$this->level = $depth;
		
		$indent = str_repeat("\t", $depth);
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
		    'sub-menu',
		    'menu-depth-' . $display_depth
		    );
		
		
		if ($this->menu_items[$this->index-1]->ancestor) {
		    $this->left = true;
		    $this->mega_menu_id = $this->menu_items[$this->index-1]->ancestor;
		    $classes[] = "oii-mega-menu";
		    $this->mega_menu_items = $this->get_nav_menu_item_children($this->menu_items[$this->index-1]->ancestor, $this->items);
		    
		    foreach($this->mega_menu_items as $mega_menu_item) {
			$this->mega_menu_ids[] = $mega_menu_item->ID;
		    }
		    
		    $this->mega_menu_item_count = count($this->mega_menu_items);
		}
		
		$class_names = implode( ' ', $classes );
		$output .= "\n$indent<ul class=\"$class_names\">\n";
		
		if ($this->left) {
		    $output .= "\n$indent<li class='oii-mega-menu-left'><ul>";
		    $this->left = false;
		    $this->right = true;
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		
		if ($this->mega_index==$this->mega_menu_item_count){
		    $output .= "</li></ul><!-- End of Right Menu -->";
		}
		
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$ancestor = null;
		$grandparent = null;
		$mega_index = -1;
		
		if ($depth>0)
		    $this->count++;
		
		$this->index++;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		//if  ($item->menu_item_parent==0 && in_array('menu-item-has-children', $item->classes))
		if  ($item->menu_item_parent==0 && in_array('menu-item-has-children', $classes))
		    $ancestor = $item->ID;
		    
		if (in_array($item->ID,$this->mega_menu_ids)){
		    $grandparent = $this->mega_menu_id;
		    $this->mega_index++;
		    $mega_index = $this->mega_index;
		}
		
		$this->menu_items[] = (object)array(
				    'index' => $this->index,
				    'mega_index' => $this->mega_index,
				    'id' => $item->ID,
				    'depth' => $depth,
				    'title' => $item->title,
				    'parent' => $item->menu_item_parent,
				    //'haschildren' => in_array('menu-item-has-children',$item->classes),
				    'haschildren' => in_array('menu-item-has-children',$classes),
				    'ancestor' => $ancestor,
				    'grandparent' => $grandparent
				    );
		
		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
	    
		$output .= "</li>\n";
		if(isset($this->all_items[$this->index])){
			if(($this->mega_index>=$this->mega_menu_item_count/2) && $this->all_items[$this->index]->parent==$this->mega_menu_id){
			    $this->separator = true;
			}
		}
		if ($this->separator && $this->right) {
		    if ($depth==1) {
			$output .= "</ul><!-- End of Left Menu --></li>";
			$output .= "<li class='oii-mega-menu-right'><ul>";
			$this->separator = false;
			$this->right = false;
		    }
		}
	}
	
	/**
	* Returns all child nav_menu_items under a specific parent
	*
	* @param int the parent nav_menu_item ID
	* @param array nav_menu_items
	* @param bool gives all children or direct children only
	* @return array returns filtered array of nav_menu_items
	*/
	private function get_nav_menu_item_children( $parent_id, $nav_menu_items, $depth = true ) {
	    $nav_menu_item_list = array();
	    foreach ( (array) $nav_menu_items as $nav_menu_item ) {
		if ( $nav_menu_item->menu_item_parent == $parent_id ) {
		    $nav_menu_item_list[] = $nav_menu_item;
		if ( $depth ) {
		    if ( $children = $this->get_nav_menu_item_children( $nav_menu_item->ID, $nav_menu_items ) )
			$nav_menu_item_list = array_merge( $nav_menu_item_list, $children );
		    }
		}
	    }
	    return $nav_menu_item_list;
	}

} // Walker_Nav_Menu
?>