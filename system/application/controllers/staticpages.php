<?php
      class Staticpages extends Controller 
	       { 
		     function Staticpages()
			    {
				  parent::Controller(); 
				 
				 
		         $this->load->model('staticpages_model');	
				}
			
		    function pages()
			    {
				 
				$this->load->library('facebook_connect');
				$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);			
                $page = $this->staticpages_model->pagedata();
				$data['head_title']=$page[0]->page_title;
					 //echo $page[0]->page_title; die;
				$data["file"]="staticpages";
				$data['page_data'] = $page;
			
				$this->load->view('template',$data);
		       		
	 	 }
			
		
		
}
			
		
 ?>
