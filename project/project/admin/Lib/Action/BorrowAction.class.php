<?php
// 本文档自动生成，仅供测试运行
class BorrowAction extends Action
{

		public function borrow_edit(){
			$b=M("bookmsg");
			$id=$_GET['id'];
			$borrow_edit=$b->where("id=$id")->find();
			$this->assign("borrow_edit",$borrow_edit);
			$this->display("borrow_edit");
		}

		public function borrow_update(){
			$bookmsg['borrow_party']=$_POST['borrow_party'];
			if($bookmsg['borrow_party']==""){
			header("Content-Type:text/html; charset=utf-8");
			$b=M("bookmsg");
			$id=$_POST['bid'];
			$bookmsg['lease']="未借";
			$b->where("id=$id")->save($bookmsg);
			echo "<script>alert('修改成功！')</script>";
			$this->redirect("book/book_msg_borrow");}

			elseif($bookmsg['borrow_party']){
				header("Content-Type:text/html; charset=utf-8");
				$b=M("bookmsg");
				$id=$_POST['bid'];
				$bookmsg['lease']="已借";
				$b->where("id=$id")->save($bookmsg);
				echo "<script>alert('修改成功！')</script>";
				$this->redirect("book/book_msg_borrow");
			}
			else{
				echo "<script>alert('修改失败！')</script>";
				$this->redirect("book/book_msg_borrow");
			}
	}
}
?>