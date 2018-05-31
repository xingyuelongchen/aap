<?php
class upload{
	protected $filename;
	protected $maxsize;
	protected $minsize;
	protected $allowmime;
	protected $allowext;
	protected $path;
	protected $flag;
	protected $fileinfo;
	protected $error;
	protected $ext;
	
	public function __construct($filename='myfile',$flag=true,$allowext='jpg jpeg png gif psd ai pdf',$allowmime='image/jpeg image/png image/gif',$maxsize=10,$minsize=0,$path='temp'){
		$this->filename=$filename;
		$this->maxsize=$maxsize*1024*1024;
		$this->minsize=$minsize*1024;
		$this->allowmime=$allowmime;
		$this->allowext=$allowext;
		$this->path=$path;
		$this->flag=$flag;
		$this->fileinfo=$this->filename;
	}
	//检测上传文件是否出错
	protected function showError(){
		if(!is_null($this->fileinfo)){
			if($this->fileinfo['error']>0){
				switch($this->fileinfo['error']){
					case 1:
						$this->error = '文件超过系统环境规定上传文件的最大值';
						break;
					case 2:
						$this->error = '文件过大';
						break;
					case 3:
						$this->error = '部分文件被上传';
						break;
					case 4:	
						$this->error = '请选择文件';
						break;
					case 6:
						$this->error = '缓存失败';
						break;
					case 7:
						$this->error = '文件不可写';
						break;
					case 8:
						$this->error = '系统错误';
						break;
					default:
						$this->error = '未知错误！';
				}
				return false;
			}else{
				return true;
			}
		}else{
			$this->error = '上传文件出错';
			return false;
		}
	}
	protected function fileflag(){
		if($this->flag){
			$filename = $this->fileinfo['name'];
			$filetemp = $this->fileinfo['tmp_name'];
			//检测文件类型是否符合要求
			//获取上传文件的扩展名
			$this->ext = pathinfo($filename,PATHINFO_EXTENSION);			
			//验证允许上传的文件类型
			//验证允许上传的文件类型
			$type=explode(' ',$this->allowext);
			if(!in_array($this->ext,$type)){
				$this->error=$filename."文件格式错误！请重新上传";
				return false;
			}
			//验证是否为正确的图像文件
			$arr=['jpg','jpeg','png','gif'];
			if(in_array($this->ext,$arr)){
				if(!@getimagesize($filetemp)){
					$this->error=$filename.'不是正确或指定格式的图像文件';
					return false;
				}
			}
			//验证文件是否通过HTTP的post方式上传
			if(!is_uploaded_file($filetemp)){
				$this->error=$filename.'文件不是通过HTTP POST方式上传的';
				return false;
			}
			return true;
		}else{
			return true;
		}
	}
	
	//检测文件大小
	protected function filesize(){
		$filesize = $this->fileinfo['size'];
		if($filesize>$this->maxsize){
			$this->error = '上传文件过大';
			return false;
		}elseif($filesize<$this->minsize){
			$this->error = '上传文件过小';
			return false;
		}
		return true;
	}
	
	//检测或创建缓存目录
	protected function filepath(){
		if(!file_exists($this->path)){
			mkdir($this->path,0777,true);
			if(!chmod($this->path,0777)){
				$this->error = $this->path.'缓存文件夹创建失败';
				return false;
			}
		}
		return true;
	}

	public function uploadfile(){
		//检测上传文件 ，是否检测文件类型，文件格式，文件类型，文件大小
		if($this->showError()&&$this->fileflag()&&$this->filesize()&&$this->filepath()){
		//通过检查后保存图片
			//生成文件名
			date_default_timezone_set("PRC");
			$fileNewName= date('YmdHis').md5(uniqid(microtime(true),true));
			//存储位置
			$fileNewPath= $this->path.'/'.$fileNewName.'.'.$this->ext;
			//存储操作
			if(@move_uploaded_file($this->fileinfo['tmp_name'],$fileNewPath)){
				
				return $fileNewPath;
			}else{
				
				$this->error='文件上传失败';
				$this->showError();
			}
		}else{
			//没通过检测提示错误信息
			$this->showError();
		}
		return $this->error;
	}
}