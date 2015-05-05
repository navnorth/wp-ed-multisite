<?php

/**
 *
 * Ratings_List class that extends the native List table of WordPress to display list of Ratings
 *
 **/
if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
 
class Rating_List extends WP_List_Table {
    
    protected $_table = "_ratings";
    
    /**
     *
     * Constructor to pass our own arguments
     *
     **/
    function __construct(){
        parent::__construct(array(
                            'singular' => 'wp_list_text_link' ,
                            'plural' => 'wp_list_text_links' ,
                            'ajax' => false
                            ));
    }
    
    /**
     *
     * Table Header and Footer
     *
     **/
    function extra_tablenav( $which ){
        if ( $which == "top" ) {
            echo "Top Header";
        }
        if ( $which == "bottom" ) {
            echo "Bottom Footer";
        }
    }
    
    /**
     *
     * Get Columns of the list
     *
     **/
    function get_columns() {
        return $columns = array(
                                'col_link_id' => __('ID') ,
                                'col_link_value' => __('Value') ,
                                'col_link_label' => __('Label') ,
                                'col_link_description' => __('Description') ,
                                'col_link_display' => __('Display')
                                );
    }
    
    /**
     *
     * Columns that can be sorted
     *
     **/
    public function get_sortable_columns(){
        return $sortable = array(
                                'col_link_value' => 'value' ,
                                'col_link_label' => 'label' ,
                                'col_link_description' => 'description'
                                 );
    }
    
    /**
     *
     * Prepare the ratings table for display
     *
     **/
    function prepare_items(){
        global $wpdb, $_wp_column_headers;
        
        $screen = get_current_screen();
        
        $table = $wpdb->prefix . $this->_table;
        
        //Preparing query
        $query = "Select * FROM {$table}";
        
        //Order Parameters
        $orderby = !empty($_GET['orderby']) ? mysql_real_escape_string($_GET['orderby']) : "ASC";
        
        $order = !empty($_GET['order']) ? mysql_real_escape_string($_GET['order']):"";
        
        if (!empty($orderby) & !empty($order)) {
            $query .= " ORDER BY " . $orderby . " " . $order;
        }
        
        /* Pagination Parameters */
        //Get number of records
        $totalitems = $wpdb->query($query);
        
        $perpage = 5;
        
        $paged = !empty($_GET['paged']) ? mysql_real_escape_string($_GET['paged']) : "";
        
        //Page Number
        if (empty($paged) || !is_numeric($paged) || $paged <=0 ){
            $paged =1;
        }
        //Total number of pages
        $total_pages = ceil($totalitems/$perpage);
        
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= " LIMIT ".(int)$offset.", ".(int)$perpage;
        }
        
        //Register pagination
        $this->set_pagination_args(array(
                                        'total_items' => $totalitems ,
                                        'total_pages' => $total_pages ,
                                        'per_page' => $perpage
                                         ));
        
        //Register Columns
        $columns = $this->get_columns();
        $_wp_column_headers[$screen->id] = $columns;
        
        //Get the items
        $this->items = $wpdb->get_results($query);
    }
    
    /**
     *
     * Displaying the rows from the ratings table
     *
     **/
    function display_rows(){
        //Get items
        $records = $this->items;
        
        //Get the columns
        list($columns, $hidden) = $this->get_column_info();
        
        if (!empty($records)){
            foreach($records as $record) {
                echo "<tr id='record_".$record->link_id."'>";
                foreach ($columns as $column_name=>$column_display_name) {
                    //Style per column
                    $class = "$column_name column-$column_name";
                    $style = "";
                    
                    if ( in_array($column_name, $hidden)) $style=" style='display:none;'";
                    
                    $attributes = $class . $style;
                    
                    //edit link
                    //$editlink = '/wp-admin'
                    
                    //Display the cell
                    switch ( $column_name ) {
                       case "col_link_id":  echo '< td '.$attributes.'>'.stripslashes($record->rating_id).'< /td>';   break;
                       case "col_link_value": echo '< td '.$attributes.'>'.stripslashes($record->value).'5< /td>'; break;
                       case "col_link_label": echo '< td '.$attributes.'>'.stripslashes($record->label).'< /td>'; break;
                       case "col_link_description": echo '< td '.$attributes.'>'.$record->description.'< /td>'; break;
                       case "col_link_display": echo '< td '.$attributes.'>'.$record->display.'< /td>'; break;
                    }
                }
                echo "</tr>";
            }
        }
    }
}
?>