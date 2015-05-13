<?php

if( ! class_exists("WP_List_Table"))
    require_once(ABSPATH . "wp-admin/includes/class-wp-list-table.php");

class Organization_List extends WP_List_Table {
    public static $table = "organizations";
    public static $per_page = 10;
    
    function __construct()
    {
        parent::__construct(array(
            "singular" => "wp_list_text_link",
            "plural" => "wp_list_text_links",
            "ajax" => FALSE
        ));
    }
    
    function get_columns()
    {
        return array(
            "cb" => "<input type='checkbox' />",
            "id" => __("ID"),
            "FIPST" => __("State"),
            "LEAID" => __("LEAID"),
            "LEANM" => __("LEANM")
        );
    }
    
    function get_sortable_columns()
    {
        return array(
            "FIPST" => array("FIPST", FALSE),
            "LEAID" => array("LEAID", FALSE),
            "LEANM" => array("LEANM", FALSE)
        );
    }
    
    function get_hidden_columns()
    {
        return array(
            "id"
        );
    }
    
    function get_bulk_actions()
    {
        return array(
            "delete" => "Delete"
        );
    }
    
    function column_cb($item)
    {
        return sprintf(
            "<input type=\"checkbox\" name=\"organization[]\" value=\"%s\" />", $item["id"]
        );
    }
    
    function single_row($item)
    {
        $actions = array(
            "edit" => sprintf("<a href='?page=%s&action=%s&id=%d'>Edit</a>", $_REQUEST["page"] , "edit-organization" , $item->organization_id),
            "delete" => sprintf("<a class='delete-organization' href='?page=%s&action=%s&id=%d&_wpnonce=" . wp_create_nonce("gat-delete-organization-nonce") . "'>Delete</a>", $_REQUEST["page"] , "delete-organization" , $item->organization_id)
        );
        
        return sprintf('%1$s %2$s', $item->FIPST, $this->row_actions($actions));
    }
    function column_FIPST($item)
    {
        $actions = array(
            "edit" => sprintf("<a href='?page=%s&action=%s&id=%d'>Edit</a>", $_REQUEST["page"], "edit", $item["organization_id"]),
            "delete" => sprintf("<a href='?page=%s&action=%s&id=%d'>Delete</a>", $_REQUEST["page"], "delete", $item["organization_id"])
        );
        
        return sprintf('%1$s %2$s', $item["FIPST"], $this->row_actions($actions));
    }
    
    function prepare_items()
    {
        global $wpdb, $_wp_column_headers;
        
        $screen = get_current_screen();
    
        $sql = "SELECT * FROM `" . $wpdb->prefix . self::$table . "`";
        
        $orderby = ! empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : "ASC";
        
        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : "";
        
        if ( ! empty($orderby) && ! empty($order))
            $sql .= " ORDER BY " . $orderby . " " . $order;
            
        $total_items = $wpdb->query($sql);
        
        $per_page = self::$per_page;
        
        $paged = ! empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : "";
        
        //Page number
        if (empty($paged) || ! is_numeric($paged) || $paged <= 0)
            $paged = 1;
        
        //Total number of pages
        $total_pages = ceil($total_items / $per_page);
        
        if ( ! empty($paged) AND ! empty($per_page))
        {
            $offset = ($paged - 1) * $per_page;
            $sql .= " LIMIT " . (int) $offset . ", " . (int) $per_page;
        }
        
        // Register pagination
        $this->set_pagination_args(array(
            "total_items" => $total_items ,
            "total_pages" => $total_pages ,
            "per_page" => $per_page
        ));
        
        // Register columns
        $columns = $this->get_columns();
        //Get hidden columns
        $hidden = $this->get_hidden_columns();
        //Get sortable columns
        $sortable = $this->get_sortable_columns();
        //Show column headers
        $this->_column_headers = array($columns, $hidden, $sortable);
        //Get items
        $this->items = $wpdb->get_results($sql);
    }
    
    function display_rows()
    {
        // Get items
        $record = $this->items;
        //Get columns
        list($columns, $hidden) = $this->get_column_info();
        
        if ( ! empty($record))
        {
            foreach($record as $entry)
            {
                echo "<tr id='record_" . $record->id . "'>";
                
                foreach ($columns AS $column_name => $column_display_name)
                {
                    //Style per column
                    $class = $column_name. " column-" . $column_name;
                    
                    $style = "";
                    $class = "class='". $class . "' ";
                    
                    if (in_array($column_name, $hidden))
                        $style= " style='display:none;'";
                        
                    $attributes = $class . $style;
                    
                    switch ($column_name)
                    {
                        case "id":
                            echo '<td ' . $attributes . '>' . stripslashes($entry->organization_id) . '</td>';
                            break;
                        case "cb":
                            echo '<td ' . $attributes . '><input type="checkbox" name="organization[]" value="' . stripslashes($entry->organization_id).'" /></td>';
                            break;
                        case "FIPST":
                            echo '<td ' . $attributes . '>' . stripslashes($this->single_row($entry)) . '</td>';
                            break;
                        case "LEAID":
                            echo '<td ' . $attributes . '>' . stripslashes($entry->LEAID) . '</td>';
                            break;
                        case "LEANM":
                            echo '<td ' . $attributes . '>' . $entry->LEANM . '</td>';
                            break;
                    }
                }
                
                echo "</tr>";
            }
        }
    }
}
