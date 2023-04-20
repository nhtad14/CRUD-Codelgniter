<?php
 
 
class Project_model extends CI_Model{
 
    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }
 
   
    public function get_all()
    {
        $this->db->select("*");
        $this->db->from("product");
        $this->db->order_by("id_products" ,'desc');
        $query = $this->db->get()->result();
        return $query;
    }
    
    public function store($data)
    {   
        $query = $this->db->insert('product', $data);
        return $query;
    }
 
    
    public function get_product($id)
    {
        $this->db->select("*");
        $this->db->from("product");
        $this->db->where("id_products",$id);
        $query = $this->db->get()->row();
        return $query;
    }
 
    public function update($data,$id) 
    {   
        $this->db->where('id_products', $id);
        $query = $this->db->update('product', $data);
        return $query;
    }
 
    
    public function delete($id)
    {
        $this->db->where('id_products', $id);
        $query= $this->db->delete('product');
        return $query;
    }
    
    //datatable
    var $column_order = array(null, 'name_products','content'); //set column field database for datatable orderable
    var $column_search = array('name_products','content'); //set column field database for datatable searchable 
    var $order = array('id_products' => 'desc'); // default order 
    private function _get_datatables_query()
    {
         
        $this->db->from("product");
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
        function get_datatables()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
    
        function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
    
        public function count_all()
        {
            $this->db->from("product");
            return $this->db->count_all_results();
        }


}
?>