<?php
/**
*配置参数列表
_fonts  path	字体文件路径
_width  int		画布宽度
_height	int		画布高度
_size	int		字体大小
_length	int		验证码长度	
_image	object	画布资源
_type	int		验证码干扰类型  0:雪花   1:像素   2:线段   3:像素和线段
*/
class Captcha{
	//字体
	private $_fonts='';
	//宽度
	private $_width=200;
	//高度
	private $_height=80;
	//字体大小
	private $_size=0;
	//长度
	private $_length=4;
	//画布资源
	private $_image=null;
	//干扰类型
	private $_type=0;
	
	public function __construct($arr=null){
		//检测参数是否为真
		if(is_array($arr)&&count($arr)>0){
			// 检测字体文件是否可读
			if(isset($arr['fonts'])&&is_file($arr['fonts'])&&is_readable($arr['fonts'])){
				$this->_fonts = $arr['fonts'];
			}else{
				return false;
			}
			//检测是否设置画布宽高
			if(isset($arr['width'])&&$arr['width']>0){
				$this->_width = (int)$arr['width'];
			}
			if(isset($arr['height'])&&$arr['height']>0){
				$this->_height = (int)$arr['height'];
			}
			//检测是否设置字体大小
			if(isset($arr['size'])&&$arr['size']>0){
				$this->_size = (int)$arr['size'];
			}
			//检测是否设置验证码长度
			if(isset($arr['length'])&&$arr['length']>0){
				$this->_length = (int)$arr['length'];
			}
			//配置干扰元素
			if(isset($arr['type'])&&$arr['type']==0){
				$this->_type = $arr['type'];
			}
			if(isset($arr['type'])&&$arr['type']==1){
				$this->_type = $arr['type'];
			}
			if(isset($arr['type'])&&$arr['type']==2){
				$this->_type = $arr['type'];
			}
			
			//创建画布
			$this->_image = imagecreatetruecolor($this->_width,$this->_height);
			return $this->_image;
			//
			//
		}else{
			return false;
		}
		
	}
	//得到验证码
	public function getCaptcha(){
		//设置画布背景颜色
		$bgcolor = imagecolorallocate($this->_image,255,255,255);
		//填充画布背景
		imagefilledrectangle($this->_image,0,0,$this->_width,$this->_height,$bgcolor);
		//调用函数生成验证码
		$str = $this->_generateStr($this->_length);
		//判断生成的验证码是否合法
		
		if(!$str){
			return false;
		}
		//使用循环绘制验证码
		$fonts = $this->_fonts;//同一个验证码字体不变，所以放在循环外面
		for($i=0;$i<$this->_length;$i++){
			$size = ($this->_size===0)?mt_rand(18,30):$this->_size;
			$angle = mt_rand(-30,30);
			$x = ceil($this->_width/$this->_length)*$i+mt_rand(1,5);
			$y = ceil($this->_height/1.5+mt_rand(-7,13));
			$color = $this->getRandColor();
			$text = $str[$i];
			imagettftext($this->_image,$size,$angle,$x,$y,$color,$fonts,$text);
		}
		
		//使用循环绘制验证码干扰元素
		if($this->_type==0){
			$this->interfere($this->_type,30);
		}
		if($this->_type==1 || $this->_type==3){
			$this->interfere($this->_type,ceil($this->_width*$this->_height/10));
		}			
		if($this->_type==2 || $this->_type==3){
			$this->interfere($this->_type);
		}			
		
		//输出验证码图片;
		
		ob_clean();
		header('content-type:image/png');
		imagepng($this->_image);
		imagedestroy($this->_image);
		return strtolower($str);
	}
	
	//生成验证码
	private function _generateStr($length=4){
		//验证length参数是否合法
		if($length<0||$length>10){ 
			return false;
		}
		//创建验证码数组
		$chars = array(
			'a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z',
			'A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z',
			1,2,3,4,5,7,9,8,6
		);
		$str = join('',array_rand(array_flip($chars),$length));
		//返回验证码字符串
		return $str;
	}
	
	//生成验证码干扰元素
	private function interfere($type=0,$num=50){
		if($type==0){
			
			for($i=0;$i<$num;$i++){
				imagestring($this->_image,mt_rand(1,5),mt_rand(0,$this->_width),mt_rand(0,$this->_height),'*',$this->getRandColor());
			}
		}
		if($type==1 || $type == 3){
			for($i=0;$i<$num;$i++){
				$x = mt_rand(0,$this->_width);
				$y = mt_rand(0,$this->_height);
				imagesetpixel($this->_image,$x,$y,$this->getRandColor());
			}
		}
		if($type==2 || $type == 3){
			for($i=0;$i<5;$i++){
				$x = mt_rand(0,$this->_width);
				$y = mt_rand(0,$this->_height);
				$x1 = mt_rand(0,$this->_width);
				$y1 = mt_rand(0,$this->_height);
				imageline($this->_image,$x,$y,$x1,$y1,$this->getRandColor());
			}
		}
	}
	//生成随机颜色
	private function getRandColor(){
		//生成画笔随机颜色
		return imagecolorallocate($this->_image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
	}
}


?>