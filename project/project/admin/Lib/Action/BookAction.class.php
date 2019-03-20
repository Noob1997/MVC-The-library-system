<?php
// 本文档自动生成，仅供测试运行
class BookAction extends Action
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function book_msg() {

		import("ORG.Util.Page");
		$b=M("bookmsg");

		$total=$b->count();

		$per_page=6;
		$page=new Page($total,$per_page);
		$book_msg=$b->limit($page->firstRow.",".$page->listRows)->select();
		$page->setConfig("header","本图书记录:");
		$page_show=$page->show();
		
		//$book_msg=$b->select();
		$this->assign("book_msg",$book_msg);
		$this->assign("page_show",$page_show);

        $this->display("book:book_msg");
    }
	
	public function book_add(){
		$this->display("book:book_add");
		$b=M("bookmsg");
		$book_add['bookname']=$_POST['bookname'];
		$book_add['author']=$_POST['author'];
		$book_add['tag']=$_POST['tag'];
		$book_add['lease']='未借';

		$text=$b->add($book_add);
		if($text){
			echo "<script>alert('添加成功！')</script>";
			$this->redirect("book_msg");
			}
		}

	public function book_del(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("bookmsg");
		$id=$_GET['id'];
		$b->where("id=$id")->delete();
		echo "<script>alert('删除成功！')</script>";
		$this->redirect("book_msg");
	}

	public function book_dels(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("bookmsg");
		$id=$_GET['id'];
		$l='id in('.implode(',',$id).')';
		$b->where($l)->delete();
		echo "<script>alert('删除成功！')</script>";
		$this->redirect("book_msg");
	}
	
	public function book_edit(){
		$b=M("bookmsg");
		$id=$_GET['id'];
		$book_edit=$b->where("id=$id")->find();
		$this->assign("book_edit",$book_edit);

		$this->display("book:book_edit");
	}

	public function book_update(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("bookmsg");
		$id=$_POST['bid'];

		$bookmsg['bookname']=$_POST['bookname'];
		$bookmsg['author']=$_POST['author'];
		$bookmsg['tag']=$_POST['tag'];

		$c=$b->where("id=$id")->save($bookmsg);
		if($c){
		echo "<script>alert('修改成功！')</script>";
		$this->redirect("book/book_msg");}
		else {
			echo "<script>alert('没有改动,修改失败！')</script>";
			$this->redirect("book/book_msg");
		}
	}

	public function book_msg_borrow(){
		import("ORG.Util.Page");
		$b=M("bookmsg");

		$total=$b->count();

		$per_page=6;
		$page=new Page($total,$per_page);
		$book_msg=$b->limit($page->firstRow.",".$page->listRows)->select();
		$page->setConfig("header","本图书记录:");
		$page_show=$page->show();
		
		//$book_msg=$b->select();
		$this->assign("book_msg",$book_msg);
		$this->assign("page_show",$page_show);
		$this->display("book:book_msg_borrow");
	}

	public function book_user(){
		import("ORG.Util.Page");
		$b=M("user");

		$total=$b->count();

		$per_page=6;
		$page=new Page($total,$per_page);
		$book_user=$b->limit($page->firstRow.",".$page->listRows)->select();
		$page->setConfig("header","个用户:");
		$page_show=$page->show();
		
		//$book_msg=$b->select();
		$this->assign("book_user",$book_user);
		$this->assign("page_show",$page_show);

        $this->display("book:book_user");
	}

	public function book_userdel(){
		header("Content-Type:text/html; charset=utf-8");
		$b=M("user");
		$id=$_GET['id'];
		$b->where("id=$id")->delete();
		echo "<script>alert('删除成功！')</script>";
		$this->redirect("book_user");
	}
}
?>