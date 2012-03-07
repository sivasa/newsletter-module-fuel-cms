<?

class Newsletters extends CI_model{
	public static $table_names = array(
		'newsletters_subscriber' => 'newsletters_subscriber'
	);

	
	function __construct(){
		parent::__construct();	
		$this->load->helper('email')
	}
	
	function add_mail($mail,$nom){
		$no_error = true ;
		if( ! valid_email($mail)){
			$no_error = false ;
		}
		elseif($this->_is_in_list($mail)){
			$no_error = false ;
		}
		else{
			$no_error = $this->_send_notif_subscription($mail);
			if($no_error){
				$this->db->insert(
					self::$table_names['newsletters_subscriber'],
					array(
						'MAIL' => $mail,
						'NAME' => $name
					)
				);
			}
		}
		return $no_error;
	}
	

	
	function supp_mail($mail){
		$no_error = true ;
		$anwser =  CB::db()	->where('MAIL', $mail)
		 					->limit('1')
		 					->delete(self::$table_names['newsletters_subscriber']);
		return $no_error;
	}
	
	
	
	private function _is_in_list($mail){
		$res = false;
		if(	! empty($mail)){
			$answer = $this->db	->select('count(*) as `nb`')
								->from(self::$table_names['newsletters_subscriber']);
								->where('MAIL',$mail)
								->get()->result_array();
			$answer = $answer[0];
			if($answer['nb'] == '1')
				$res = true;
		}
		return $res;
	}
	
	private _send_notif_subscription($subject, $message){
		
	}
	
	
	
}