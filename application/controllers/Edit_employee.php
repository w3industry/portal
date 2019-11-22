<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_employee extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id=NULL)
	{
		if(is_user_logged_in())
		{
			$flag= get_current_pos();
			if(check_access($flag))
			{
				$data['emp_login']=$this->Base_model->get_employee_login($id);
				$this->load->view('header');
				$this->load->view('edit_employee',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('dashboard');
			}
		}
		else
		{
			redirect('login');
		}
	}
	public function update_employee()
	{
		$data=$_POST['data'];
		$info=array();
		parse_str($data,$info);

		echo $flag=$this->Base_model->update_employee($info);
		//$flag=$this->Base_model->add_new_broker($info);

	}
	public function regenrate_pass()
	{
		?>
		<input type="text" class="form-control" name="pass" readonly required value="<?php echo random_password();?>">
		<?php
	}
	public function delete_employee($id=NULL)
	{
		$flag=$this->Base_model->delete_employee($id);
		if($flag==true)
		{
			$this->Base_model->delete_aircraft_by_operator($id);
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}
		else
		{
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}
	}

	
}