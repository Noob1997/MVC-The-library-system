<?php
// 本文档自动生成，仅供测试运行
class UserAction extends Action
{
	public function user_msg(){
		import("ORG.Util.Page");

		$b=M("bookmsg");
		$c=M("user");
		$username=$_SESSION['username'];
		$d=$c->where("name='$username'")->find();

		$user_msg=$c->select();
		$this->assign("user_msg",$user_msg);
	
		$total=$b->count();

		$per_page=6;
		$page=new Page($total,$per_page);
		$book_msg=$b->limit($page->firstRow.",".$page->listRows)->select();
		$page->setConfig("header","本图书记录:");
		$page_show=$page->show();
		
		//$book_msg=$b->select();
		$this->assign("book_msg",$book_msg);
		$this->assign("page_show",$page_show);
		$this->assign("d1",$d);
		$this->display("user/user_msg");
	}

	public function user_borrow(){
		header("Content-Type:text/html; charset=utf-8");
		$c=M("user");
		$b=M("bookmsg");

		$id=$_GET['id'];
		
		$username=$_SESSION['username'];
		$d=$c->where("name='$username'")->find();
		$this->assign("d1",$d);

		$book_edit=$b->where("id=$id")->find();
		$this->assign("book_edit",$book_edit);
		$user_msg=$c->select();
		
		if($book_edit['lease']=='已借'){
			echo "<script>alert('借书失败！，已被租借')</script>";
			$this->redirect("user/user_msg");
		}else{
		$this->assign("user_msg",$user_msg);
		$this->assign("book_msg",$book_msg);
		$this->display("user:user_borrow");}


	}

	public function userbook_update(){
		header("Content-Type:text/html; charset=utf-8");
		

		$b=M("bookmsg");
		$id=$_POST['bid'];
		$d=$b->where("id=$id")->find();

		$bookmsg['bookname']=$_POST['bookname'];
		$bookmsg['author']=$_POST['author'];
		$bookmsg['lease']='已借';
		$bookmsg['borrow_party']=$_POST['cname'];
		
		$c=$b->where("id=$id")->save($bookmsg);

		if($c){
		echo "<script>alert('借书成功！')</script>";
		$this->redirect("user/user_msg");}
	}

	public function reguster_add(){
		header("Content-Type:text/html; charset=utf-8");	
		if($_POST['submit'])
			if($_POST['password']!=$_POST['passwordc']){
				echo "<script>alert('添加失败，两次输入密码不一致！')</script>";
				$this->redirect("admin/reguster");
			}
			else{
				$b=M("user");
				$admin_add['name']=$_POST['name'];
				$admin_add['pass']=$_POST['password'];
				$text=$b->add($admin_add);
				if($text){
					echo "<script>alert('注册成功！')</script>";
					$this->redirect("admin/login");
				}
				else{echo "<script>alert('注册失败！')</script>";
					$this->redirect("admin/reguster");
				}
			}
	}

	public function user_back(){
		import("ORG.Util.Page");

		$b=M("bookmsg");
		$c=M("user");
		$username=$_SESSION['username'];
		$d=$c->where("name='$username'")->find();

		$user_msg=$c->select();
		$this->assign("user_msg",$user_msg);
	
		$total=$b->where("borrow_party='$username'")->count();

		$per_page=6;
		$page=new Page($total,$per_page);
		$book_msg=$b->where("borrow_party='$username'")->limit($page->firstRow.",".$page->listRows)->select();
		$page->setConfig("header","本图书记录:");
		$page_show=$page->show();
		
		//$book_msg=$b->select();
		$this->assign("book_msg",$book_msg);
		$this->assign("page_show",$page_show);
		$this->assign("d1",$d);
		$this->display("user:user_back");
	}

		public function userbook_backupdate(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("bookmsg");
		$id=$_GET['id'];
		$d=$b->where("id=$id")->find();

		$bookmsg['lease']='未借';
		$bookmsg['borrow_party']='';

		$c=$b->where("id=$id")->save($bookmsg);
		
		if($c){
		echo "<script>alert('归还成功！')</script>";
		$this->redirect("user/user_back");}
	}
}
?>