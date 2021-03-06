<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		 parent::__construct();
		 $this->load->library('dummy');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	/**
	 *  患者リスト
	 *	・上部に緊急な患者を表示
	 *	・患者検索
	 *		患者名、患者カナ、患者病名、薬剤名
	 *
	 */
	public function patient_list(){
		$this->load->model('Patient_model', 'Patient');
		$data['patient_list'] = $this->Patient->get_all_data();
		//var_dump($patient_data);
		$this->load->view('hospital/hospital_patient_list', $data);
	}

	/**
	 * 患者登録
	 * 登録後は患者リストへ遷移
	 */
	 public function patient_insert(){
			if ( ! isset($_POST['sub'])){// 入力フォーム表示
					$this->load->view('hospital/hospital_patient_insert');
			} else {// 登録処理
					$data = array(
						'patient_number' => $this->input->post('patient_number'),
						'image' => $this->input->post('image'),
						'age' => $this->input->post('age'),
						'name' => $this->input->post('name'),
						'name_kana' => $this->input->post('name_kana'),
						'area' => $this->input->post('area'),
						'disease' => $this->input->post('disease'),
						'medicine' => $this->input->post('medicine'),
						'caution' => $this->input->post('caution'),
					);
					$this->load->model('Patient_model', 'Patient');
					$this->Patient->insert_data($data);
					redirect( 'hospital/patient_list' );
			}
	 }

	/**
	 *	患者詳細
	 *		患者名、患者カナ、患者生年月日、病名、薬剤名、病歴、
	 *		心拍、体温、消費カロリー、
	 *		複数データはカンマ区切りで保存
	 *
	 */
	public function patient_details($id){
		$this->load->model('Patient_model', 'Patient');
		$data['patient_info'] = $this->Patient->get_target_data($id);
		// var_dump($data);
		$this->load->view('hospital/hospital_patient_details', $data);
	}
}
