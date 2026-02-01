<!---------------------------------------------------------------------------------------------
   제목 : 내 손으로 만드는 PHP 쇼핑몰무 (실습용 디자인 HTML)

   소속 : 인덕대학교 컴퓨터소프트웨어학과
   이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<?
   include "main_top.php";
?>

<!-------------------------------------------------------------------------------------------->   
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->   

<script>
   function cart_edit(kind,pos) 
   {
      if (kind=="deleteall") 
         location.href = "cart_edit.php?kind=deleteall";
      else if (kind=="delete")
         location.href = "cart_edit.php?kind=delete&pos="+pos;
      else if (kind=="insert")   
      {
         var num=eval("form2.num"+pos).value;
         location.href = "cart_edit.php?kind=insert&pos="+pos+"&num="+num;
      }
      else if (kind=="update")   
      {
         var num=eval("form2.num"+pos).value;
         location.href = "cart_edit.php?kind=update&pos="+pos+"&num="+num;
      }
   }
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="">

<div class="row m-3 mb-0">
   <div class="col" align="center">

      <h4 class="my-3">장바구니</h4>

      <hr class="m-0">
      <table class="table table-sm mb-5">
         <tr height="40" class="bg-light">
            <td width="10%">이미지</td>
            <td width="35%">상품정보</td>
            <td width="10%">판매가</td>
            <td width="20%">수량</td>
            <td width="10%">금액</td>
            <td width="10%">삭제</td>
         </tr>
         <?
         $cart=$_COOKIE["cart"];
         $n_cart=$_COOKIE["n_cart"];


         
         $total=0;
         if(!$n_cart) $n_cart=0;
         for($i=1;$i<=$n_cart;$i++)
         {
            if($cart[$i])
            {
               list($id,$num,$opts_id1,$opts_id2)=explode("^",$cart[$i]);
               
               $sql="select * from product where id=$id";
               $result=mysqli_query($db,$sql);
               if(!$result)exit("에러: $sql");
               $row=mysqli_fetch_array($result);
               
               $sql="select * from opts where no=$opts_id1";
               $result1=mysqli_query($db,$sql);
               if(!$result1)exit("에러: $sql");
               $opts1=mysqli_fetch_array($result1);
               
               $sql="select * from opts where no=$opts_id2";
               $result2=mysqli_query($db,$sql);
               if(!$result2)exit("에러: $sql");
               $opts2=mysqli_fetch_array($result2);
               
               $price=$row["price"];
               if($row["icon_sale"]==1){
                  $price=round($price * (100 - $discount) / 100, -3);
               }else $price;
               $sum=$price*$num;
               $total+=$sum;
         
         ?>
         <tr height="85" style="font-size:14px;">
            <td>
               <a href="product.php?id=<?=$row["id"];?>"><img src="product/<?=$row["image1"];?>" width="60" height="70"></a>
            </td>
            <td align="left" valign="middle">
               <a href="product.php?id=<?=$row["id"];?>" style="color:#0066CC"><?=$row["name"];?></a><br>
               <small><b>[옵션]</b> <?=$opts1["name"];?> &nbsp; <?=$opts2["name"];?></small>
            </td>
            <td><?=number_format($price);?></td>
            <td>
               <div class="d-inline-flex">
                  <input type="text"  name="num<?=$i;?>" size="2" value="<?=$num;?>" class="form-control form-control-sm text-center">
               </div>
               <a href = "javascript:cart_edit('update','<?=$i;?>')" class="btn btn-sm mybutton mb-1" style="color:#0066CC">수정</a> 
            </td>
            <td><?=number_format($sum);?></td>
            <td>
               <a href = "javascript:cart_edit('delete','<?=$i;?>')" class="btn btn-sm mybutton" style="color:#D06404">삭제</a> 
            </td>
         </tr>
         <?
            }
         }
         if($total<$max_baesongbi) $total=$total+$baesongbi;
         ?>
         
         <tr height="40" align="right" class="bg-light" style="font-size:14px;">
            <td width="10%" align="center"><img src="images/cart_image1.gif" border="0"></td>
            <td width="90%" colspan="5" class="pe-4">
               <font color="#0066CC">총 합계금액</font> : 상품구매금액( <?=number_format($total - $baesongbi);?> ) + 배송비( <?=number_format($baesongbi);?> ) = <font style="font-size:16px"><b><?=number_format($total);?></b></font>
            </td>
         </tr>
      </table>

      <a href="index.html"  class="btn btn-sm btn-outline-secondary mx-1">&nbsp;계속 쇼핑하기&nbsp;</a>
      <a href="javascript:cart_edit('deleteall',0)"  class="btn btn-sm btn-outline-secondary mx-1">&nbsp;장바구니 비우기&nbsp;</a>
      <a href="order.html"  class="btn btn-sm btn-dark text-white mx-1">&nbsp;결재하기&nbsp;</a>

   </div>
</div>

</form>

<br><br><br><br><br><br><br><br><br>

<!-------------------------------------------------------------------------------------------->   
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->   

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?
   include "main_bottom.php";
?>

<!-------------------------------------------------------------------------------------------->   
</div>

</body>
</html>
