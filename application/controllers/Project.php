<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project extends CI_Controller {
  public $post;
   public function __construct() {
      parent::__construct(); 
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->model('Project_model', 'productmodel');
   }
    // Hiển thị products
  public function index()
  {
    $data['title'] = "List Products";
    $this->load->view('layout/header');       
    $this->load->view('project/index',$data);
    $this->load->view('layout/footer');
  }
  public function listData(){
    $data=$this->productmodel->get_all();
    echo json_encode($data);
  }
  //Detai product
  public function GetProduct($id){
    $data=$this->productmodel->get_product($id);
    echo json_encode($data);
  }
  // Create Product
   public function addItem(){
        
    // validate input
    $this->form_validation->set_rules('name_products', 'Name', 'required');// required => input không được để trống
    $this->form_validation->set_rules('content', 'Description', 'required');
    if($this->form_validation->run()== FALSE){// Kiểm tra dữ liệu có hợp lệ hay không 
      $errors = $this->form_validation->error_array();
      $message = [
        'status' => 'warning',
        'massage' => 'Vui long kiem tra lai',
        'errors' => $errors
      ];
    }else{
        $data=array(
            'name_products' => $this->input->post('name_products'),
            'content' => $this->input->post('content')
        );
        $this->productmodel->store($data);
        $message = [
          'status' => 'success',
          'massage' => 'Add Product Successsfully',
        ];
      }
    echo json_encode($message);
      
  }
  // UpdateProduct
  public function UpdateProduct($id){
    $this->form_validation->set_rules('name_products', 'Name', 'required');// required => input không được để trống
    $this->form_validation->set_rules('content', 'Description', 'required');
    if($this->form_validation->run()== FALSE){// Kiểm tra dữ liệu có hợp lệ hay không 
      $errors = $this->form_validation->error_array();
      $message = [
        'status' => 'warning',
        'massage' => 'Vui long kiem tra lai',
        'errors' => $errors
      ];

    }else{
      $data = array(
            'name_products' => $this->input->post('name_products'),// dữ liệu lấy từ input form
            'content' => $this->input->post('content')
        );
        $this->productmodel->update($data,$id);

        $message = [
          'status' => 'success',
          'massage' => 'Update Product Succsessfully',
        ];
    }

    echo json_encode($message);
    
  }
    // Delete Products
    public function DeleteProduct($id){
     $data=$this->productmodel->delete($id);
     $message = [
          'status' => 'success',
          'massage' => 'Deleted Product Successsfully',
        ];
     echo json_encode($message);
    }

  //Datatable
  public function ajax_list()
    {
        $list = $this->productmodel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $row = array();
            $row[] = $products->name_products;
            $row[] = $products->content;
            $row[] = sprintf('<button style="margin-right: 20px" type="button" class="btn btn-sm btn-primary ml-2 showModal" data-id="%s" >Edit</button> ', $products->id_products);
            $row[] = sprintf('<button  type="button" class="btn btn-sm btn-primary ml-2 DeleteProduct"  data-id="%s" >Delete</button>', $products->id_products);

            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->productmodel->count_all(),
                        "recordsFiltered" => $this->productmodel->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
 
 
 
}