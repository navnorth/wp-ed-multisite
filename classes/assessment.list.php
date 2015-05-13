<?php

/**
 *
 * Assessment Custom List
 *
 **/

if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Assessment_List extends WP_List_Table{
    protected static $_table = "assessments";
    
    //Records per page
    protected $_per_page = 10;
    
    public function __construct(){
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
            
        }
        if ( $which == "bottom" ) {
            
        }
    }
    
    /**
     *
     * Get Columns of the list
     *
     **/
    function get_columns() {
        $columns = array(
                        'cb' => '<input type="checkbox" />' ,
                        'id' => __('ID') ,
                        'title' => __('Title') ,
                        'description' => __('Description') 
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
                        'title' => array('title', false) ,
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
     * Add Bulk Actions on Custom Rating List Table
     *
     **/
    function get_bulk_actions() {
        $actions = array(
          'delete'    => 'Delete'
        );
        return $actions;
    }
    
    /**
     *
     * Prepare the ratings table for display
     *
     **/
    function prepare_items(){
        global $wpdb, $_wp_column_headers;
        
        $screen = get_current_screen();
        
        $table = $wpdb->prefix . self::$_table;
        
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
        
        $perpage = $this->_per_page;
        
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
                    $class = "class='{$class}' ";
                    if ( in_array($column_name, $hidden)) $style=" style='display:none;'";
                    
                    $attributes = $class . $style;
                    
                    //edit link
                    //$editlink = '/wp-admin'
                    
                    //Display the cell
                    switch ( $column_name ) {
                       case "id":  echo '<td '.$attributes.'>'.stripslashes($record->id).'</td>';   break;
                       case "cb":  echo '<td '.$attributes.'><input type="checkbox" name="assessments[]" value="'.stripslashes($record->rating_id).'" /></td>';   break;
                       case "title":
                        echo '<td '.$attributes.'>'.stripslashes($this->single_row($record)).'</td>';
                        break;
                       case "description": echo '<td '.$attributes.'>'.$record->description.'</td>'; break;
                    }
                }
                echo "</tr>";
            }
        }
    }
}

?>