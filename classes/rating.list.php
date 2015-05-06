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
    
    protected $_table = "ratings";
    
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
        $columns = array(
                        'id' => __('ID') ,
                        'value' => __('Value') ,
                        'label' => __('Label') ,
                        'description' => __('Description') ,
                        'display' => __('Display')
                        );
        return $columns;
    }
    
    /**
     *
     * Columns that can be sorted
     *
     **/
    public function get_sortable_columns(){
        $sortable = array(
                        'value' => array('value', false) ,
                        'label' => array('label', false) ,
                        'description' => array('description', false)
                         );
        return $sortable;
    }
    
    /**
     *
     * Columns that are going to be hidden
     *
     **/
    public function get_hidden_columns(){
        $hidden_columns = array( 'id' );
        return $hidden_columns;
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
        
        //Get Hidden Columns
        $hidden = $this->get_hidden_columns();
        
        //Get Sortable Columns
        $sortable = $this->get_sortable_columns();
        
        //Show Column Headers
        $this->_column_headers = array($columns, $hidden, $sortable);
        
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
                echo "<tr id='record_".$record->id."'>";
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
                       case "id":  echo '<td '.$attributes.'>'.stripslashes($record->rating_id).'</td>';   break;
                       case "value": echo '<td '.$attributes.'>'.stripslashes($record->value).'</td>'; break;
                       case "label": echo '<td '.$attributes.'>'.stripslashes($record->label).'</td>'; break;
                       case "description": echo '<td '.$attributes.'>'.$record->description.'</td>'; break;
                       case "display": echo '<td '.$attributes.'>'.$record->display.'</td>'; break;
                    }
                }
                echo "</tr>";
            }
        }
    }
}
?>