<?php
class GoodsReceived extends Controller{
    
    function __construct(){
        //$this->goodsreceived = $this->model("GoodsReceivedModel");
        //$this->detailgoodsreceived = $this->model("DetailGoodsReceivedModel");
        $this->product = $this->model("ProductModel");
        $this->goodsreceived = $this->model("GoodsReceivedModel");
        $this->detailgoodsreceived = $this->model("DetailGoodsReceivedModel");
    }

    function index(){
        $this->view("layout",array(
			"Page" => "goodsreceived",
            "Product"=> $this->product->getAll()
            //"Goodsreceived" => $this->goodsreceived->getAll()            
		));        
    }
    function ajax(){
        if(isset($_POST['obj'])){
            $detail = json_decode($_POST['obj']);
            //echo $a[0]->id;
            for($i = 0 ; $i < count($detail) ; $i++){
                $bookID = $detail[$i]->id;
                $quantity = $detail[$i]->quantity;
                $price = $detail[$i]->price;
                $total = $detail[$i]->total;
                $array = array('bookID' => $bookID, "quantity" => $quantity , "price" => $price , "total"=> $total);
                if($this->detailgoodsreceived->add($array)==1){
                    echo "Oke";
                }
            }
        }
    }
    function add(){
        
        if(isset($_POST['txttotal']) && $_POST['txtdate'] && $_POST['txtuser'] && $_POST['obj'] ){
            
            $date = $_POST['txtdate'];
            $total= $_POST['txttotal'];
            $user= $_POST['txtuser'];
            $detail = json_decode($_POST['obj']);

            $array = array('date' => $date, "total" => $total , "user" => $user);
            if($this->goodsreceived->add($array)==1){
                for($i = 0 ; $i < count($detail) ; $i++){
                    $bookID = $detail[$i]->id;
                    $quantity = $detail[$i]->quantity;
                    $price = $detail[$i]->price;
                    $total = $detail[$i]->total;
                    $array = array('bookID' => $bookID, "quantity" => $quantity , "price" => $price , "total"=> $total);
                    if($this->detailgoodsreceived->add($array)==1){
                        echo "Oke";
                    }
                }
                $this->view("admin/pages/goodsreceived/goodsreceivedAjax",array(
                    "Product"=> $this->product->getAll(),
                    "msg" => "Add Successful",
                    "color" => "success"
                ));
                return;
            }
        }
        $this->view("admin/pages/author/authorAjax",array(
            "Product"=> $this->product->getAll(),
            "msg" => "Add Failed",
            "color" => "danger"
        ));
    }
    function update(){

    }
    function delete(){

    }
    function pages() {
        $this->view("pages/404");
    }
}
?>