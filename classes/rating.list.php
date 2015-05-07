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
    
    protected $_per_page = 10;
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
                        'label' => __('Label') ,
                        'value' => __('Value') ,
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
                        'label' => array('label', false) ,
                        'value' => array('value', false) ,
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
    
    /*function column_default( $item, $column_name ) {
        switch( $column_name ) { 
          case 'label':
          case 'value':
          case 'description':
          case 'display':
            return $item[ $column_name ];
          case 'cb':
             return sprintf('<input type="checkbox" name="rating[]" value="%s" />', $item['id']);  
          default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
    }*/
    
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
     * Adding Checkbox in every Row for bulk action
     *
     **/
    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="rating[]" value="%s" />', $item['id']
        );    
    }
    
    /**
     *
     * Action Links under Label field
     *
     **/
    function column_label($item) {
        var_dump($item);
        $actions = array(
                        'edit' => sprint( '<a href="?page=%s&action=%s&id=%d">Edit</a>', $_REQUEST['page'] , 'edit' , $item['rating_id'] ) ,
                        'delete' => sprintf( '<a href="?page=%s&action=%s&id=%d">Delete</a>' , $_REQUEST['page'] , 'delete' , $item['rating_id'] )
                         );
        
        return sprintf( '%1$s %2$s' , $item['label'] , $this->row_actions($actions) );
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
                       case "id":  echo '<td '.$attributes.'>'.stripslashes($record->rating_id).'</td>';   break;
                       case "cb":  echo '<td '.$attributes.'><input type="checkbox" name="rating[]" value="'.stripslashes($record->rating_id).'" /></td>';   break;
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