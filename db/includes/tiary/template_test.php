<?
require_once "./ipfTemplate.php";
$a = new ipfTemplate();

//���[�v�̃T���v��
//�T���v���̂���$values�Ƃ����A�z�z�������Ă����A�ʏ��DB����̃f�[�^������
$values[0] = array(
			"name" => "���{���Y",
			"address" => "�����s�c��1-1-1",
			"email" => "taro@nihon.hoge"
);
$values[1] = array(
			"name" => "�����Ԏq",
			"address" => "�����s������2-2-2",
			"email" => "hanako@tokyo.hoge"
);

$values2[0] = array(
			"name" => "2���{���Y",
			"address" => "2�����s�c��1-1-1",
			"email" => "2taro@nihon.hoge"
);
$values2[1] = array(
			"name" => "2�����Ԏq",
			"address" => "2�����s������2-2-2",
			"email" => "2hanako@tokyo.hoge"
);

$templateData2 = $a->loadTemplate("hoge2.template");//�����I�Ƀe���v���[�g�t�@�C�����w�肷��
foreach($values as $value){
	 $result2 .= $a->makeTemplateData($templateData2, $value);//�u.=�v�ł���_�ɒ���
}

//�{���̃��[�v�̂��߂̃f�[�^
$valuesForLoop["loophoge"] = $values;
$valuesForLoop["loophoge2"] = $values2;

//print_r($valuesForLoop);

//���ʂ�PRINT�̃T���v�������[�v�̌��ʂ�����
$templateData = $a->loadTemplate();//�f�t�H���g�ŃX�N���v�g���Ɠ����e���v���[�g���ǂ܂��
$forTemplate[hoge] = "�e�X�g����`";
$forTemplate[hoge2] = "�e�X�g����`�Q";
$forTemplate[loop_dayo] = $result2;//�����Ń��[�v�̌��ʂ���
$result = $a->makeTemplateData($templateData, $forTemplate, $valuesForLoop);


//��x��������ɕۑ�(�ۑ����ɕ\������遦�����ۑ��\)
$a->putMemory($result);
$a->putMemory("<p>����ɂ��͐V�h�O�Y�ł��B<br>\n");
$a->putMemory("����̓������̕ۑ����̃T���v���ł��B<br>\n");
$a->putMemory("���Ȃ݂ɂ����HTML�̏I���^�O�̌�ɏo�͂���Ă���̂�HTML�Ƃ��Ă͈ᔽ�ł��B<br>\n");

//�\���o��
$a->view();

?>