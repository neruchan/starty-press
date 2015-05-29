<?
/**
 * ipfMem�N���X
 *
 * @access	public
 * @author	Reiun Ni <reiun@social-net.jp>
 * @create	2010/12/01
 * @version	$Id: ipfMem.php, v 1.0 2010/12/01 Reiun Ni Exp $
 **/
class ipfMem{
	var $conn;		///�ڑ�ID

	/** 
	* �R���X�g���N�^
	* 
	* @access	public
	* @param	�Ȃ�
	*/
	function __construct() {
		$this->conn = new Memcache;
		$this->conn->connect('127.0.0.1', 11211);
	}
	/** 
	* �f�X�g���N�^
	* 
	* @access	public
	* @param	�Ȃ�
	*/
	function __destruct() {
	}

	/** 
	* �������L���V���[���擾
	* 
	* @access	public
	* @param	String	$mem_key	�������L���V���[�擾��ܰ��
	*/
	function get($mem_key){
		return $this->conn->get($mem_key);
	}

	/** 
	* �������L���V���[�ɏ�������
	* 
	* @access	public
	* @param	String	$mem_key	�������L���V���[�擾��ܰ��
	*/
	function set($mem_key, $value){
		$this->conn->set($mem_key, $value);
	}
}
?>