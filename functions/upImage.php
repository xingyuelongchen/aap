<?php
header('content-type:text/html;charset=utf-8');
//检测是否多文件上传
//返回文件信息
function getfiles($value){
	$i=0;
	
		if(@is_string($val['name'])){
			$files[$i] = $val;
			$i++;
		}elseif(is_array($value['name'])){
			foreach($value['name'] as $key=>$info){
				$files[$i]['name'] = $value['name'][$key];
				$files[$i]['type'] = $value['type'][$key];
				$files[$i]['tmp_name'] = $value['tmp_name'][$key];
				$files[$i]['error'] = $value['error'][$key];
				$files[$i]['size'] = $value['size'][$key];
				$i++;
			}
		}elseif(is_array($val['name'])){
			foreach($val['name'] as $key=>$info){
				$files[$i]['name'] = $val['name'][$key];
				$files[$i]['type'] = $val['type'][$key];
				$files[$i]['tmp_name'] = $val['tmp_name'][$key];
				$files[$i]['error'] = $val['error'][$key];
				$files[$i]['size'] = $val['size'][$key];
				$i++;
			}
		}
	//print_r($files);
	return $files;
}

/**
	fileInfo	array	上传的文件信息
	flag		bool	是否验证文件类型
	type		string	文件类型，多个用空格分隔
	maxsize		int		当前文件最大值
	path		string	存档目录名
*/
function uploadFile($file,$flag= false, $path='images',$maxsize=10,$type = 'jpeg png gif psd txt ai jpg'){
		if($file['error'] == 0){
			$maxsize=round(1024*1024*$maxsize);
			$filename = $file['name'];
			$filetype =$file['type'];
			$filesize =$file['size'];
			$filetmp_name = $file['tmp_name'];
			$res=array();
				//检测文件大小是否符合要求
				if($filesize > $maxsize){
					$res['msg']='false';
					$res['dest']=$file['name'].'上传文件过大';
				}
				
				//检测文件类型是否符合要求
				//获取上传文件的扩展名
				$ext = pathinfo($filename,PATHINFO_EXTENSION);
				
				//验证允许上传的文件类型
				if($flag){
					//验证允许上传的文件类型
					$type=explode(' ',$type);
					if(!in_array($ext,$type)){
						$res['msg']='false';
						$res['dest']="文件格式错误！请重新上传";
					}
					//验证是否为正确的图像文件
					$arr=['jpg','jpeg','png','gif'];
					if(in_array($ext,$arr)){
						if(!@getimagesize($filetmp_name)){
							$res['msg']='false';
							$res['dest']=$file['name'].'不是正确或指定格式的图像文件';
						}
					}
				}
				
				//验证文件是否通过HTTP的post方式上传
				// if(!is_uploaded_file($filetmp_name)){
					// $res['msg']='false';
					// $res['dest']=$file['name'].'文件不是通过HTTP POST方式上传的';
				// }
				
				//生成新的文件名，防止同名文件被覆盖
				$newfilename = date('Ymd').md5(uniqid(microtime(true))).'.'.$ext;
				$destination = 'images/'.$path;
				//检测目录是否存在
				//print($destination);exit;
				if((!file_exists($destination)) && $path){
					mkdir($destination,0777,true);
					if(!chmod($destination,0777)){
						$res['msg']='false';
						$res['dest']=$destination.'缓存文件夹创建失败';
					}
				}
				if($res){
					//$res['dest']=null;
					return $res;
				}
				
				//文件需要保存的路径和名称
				$appoint=$destination.'/'.$newfilename;
				//把文件保存到指定目录
				if(move_uploaded_file($filetmp_name,$appoint)){
					$res['msg']="true";
					//文件保存路径
					$res['dest']=$appoint;
				}else{
					$res['msg']="false";
					$res['dest']='文件保存失败！';
				}
				return $res;
		}else{
			//匹配错误信息
			switch($file['error']){
				case 1:
					$res['msg']='false';
					$res['dest']= '上传文件超过 php.ini 文件中 upload_max_filesize 规定的值';
					break;
				case 2:
					$res['msg']='false';
					$res['dest']= '超过表单MAX_FILE_SIZE限制的大小';
					break;
				case 3:
					$res['msg']='false';
					$res['dest']= '部分文件被上传';
					break;
				case 4:	
					$res['msg']='false';
					$res['dest']= '没有选择要上传的文件';
					break;
				case 6:
					$res['msg']='false';
					$res['dest']= '没有找到临时目录';
					break;
				case 7:
					$res['msg']='false';
					$res['dest']= '系统错误';
					break;
				case 8:
					$res['msg']='false';
					$res['dest']= '系统错误';
					break;
			}
			return $res;
		}
		
	}
	
	function upfile($value,$local){
		//print_r($local);exit;
		$files = getfiles($value);
		$i=0;$y=0;
		foreach($files as $fileinfo){
			$res = uploadFile($fileinfo,true,$local);
			$arr[$i][$y]=$res['msg'];
			$arr[$i][$y+1]=$res['dest'];
			$i++;
		}
		$arr = array_values(array_filter($arr));
		return $arr;
		}
?>