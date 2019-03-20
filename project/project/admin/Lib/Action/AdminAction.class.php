<?php
// 本文档自动生成，仅供测试运行
class AdminAction extends Action
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */


	public function login() {
			header("Content-Type:text/html; charset=utf-8");
			//内置管理员用户admin 密码admin
			$username = $_POST["username"];
			$password = $_POST["password"];
			
			$b=M("adminmsg");
			$b1=M("user");
			$c=$b->where("adminname='$username' and password='$password'")->find();
			$d=$b1->where("name='$username' and pass='$password'")->find();
			if($c){
				echo "<script>alert('管理员登录成功！')</script>;";
				$this->display("index");
			}
			elseif($d){
				echo "<script>alert('登录成功！')</script>;";
				$_SESSION['username']=$_POST['username'];
				$this->assign("username",$_SESSION['username']);
				//dump($d);
				//die;
				$this->assign("d1",$d);
				//用redirect显示不了用户名

				import("ORG.Util.Page");

				$b=M("bookmsg");
				$c=M("user");

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

				$this->display("user/user_msg");
			}
			else{
				echo "<script>alert('登录失败！')</script>;";
				$this->display("login");
			}
		}


	public function logout() {
		//用户退出
				echo "<script>alert('退出成功！')</script>;";
				$this->display("login");
		}

	public function reguster() {
		//用户退出

				$this->display("reguster");
		}

	public function admin_msg() {
		//用户退出
			import("ORG.Util.Page");
			$b=M("adminmsg");

			$total=$b->count();

			$per_page=6;
			$page=new Page($total,$per_page);
			$adminmsg=$b->limit($page->firstRow.",".$page->listRows)->select();
			$page->setConfig("header","个用户:");
			$page_show=$page->show();
			
			//$book_msg=$b->select();
			$this->assign("adminname",$adminmsg);


			$this->display("admin_msg");
		}

	public function admin_add(){
		header("Content-Type:text/html; charset=utf-8");
		$this->display("admin_add");
		
		if($_POST['submit'])
			if($_POST['password']!=$_POST['passwordc']){
				echo "<script>alert('添加失败，两次输入密码不一致！')</script>";
				$this->redirect("admin_add");
			}
			else{
				$b=M("adminmsg");
				$admin_add['adminname']=$_POST['adminname'];
				$admin_add['password']=$_POST['password'];
				$text=$b->add($admin_add);
				if($text){
					echo "<script>alert('添加成功！')</script>";
					$this->redirect("admin_msg");
				}
				else{echo "<script>alert('添加失败！')</script>";

				}
			}
	}

	public function admin_del(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("adminmsg");
		$id=$_GET['id'];
		//dump($id);
		//die;
		$b->where("id=$id")->delete();

		echo "<script>alert('删除成功！')</script>";
		$this->redirect("admin_msg");
	}

	public function admin_edit(){
		$b=M("adminmsg");
		$id=$_GET['id'];
		$admin_edit=$b->where("id=$id")->find();
		$this->assign("admin_edit",$admin_edit);

		$this->display("admin_edit");
	}

	public function admin_update(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("adminmsg");
		$id=$_POST['aid'];

		$adminmsg['adminname']=$_POST['adminname'];
		$adminmsg['password']=$_POST['npassword'];
	
		$c=$b->where("id=$id")->save($adminmsg);

		if($c){
			echo "<script>alert('修改成功！')</script>";
			$this->redirect("admin/admin_msg");
		}
		else {
			echo "<script>alert('修改失败')</script>";
			$this->redirect("admin/admin_msg");
		}
	}
}
?>