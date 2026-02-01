<!---------------------------------------------------------------------------------------------
   제목 : 내 손으로 만드는 PHP 쇼핑몰무 (실습용 디자인 HTML)

   소속 : 인덕대학교 컴퓨터소프트웨어학과
   이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->


<?
   include "main_top.php";
   $id=$_REQUEST["id"];
   $sql="select * from product where id=$id ";
   $result=mysqli_query($db,$sql);
   if(!$result)exit("에러: $sql");
   $row=mysqli_fetch_array($result);
   
   $price=$row["price"];
   $discount=$row["discount"];
   $imagename2=$row["image2"] ? $row["image2"] : "nopic.png";
         
   $formatted_price = number_format($price);
   $discounted_price = number_format(round($price * (100 - $discount) / 100, -3));
   #$sale_price=round($price * (100 - $discount) / 100, -3);
   #$price=($row["icon_sale"]==1) ? $sale_price : $price;
   if($row["icon_sale"]==1){
      $price=round($price * (100 - $discount) / 100, -3);
   }else $price;
                  

?>

<!-------------------------------------------------------------------------------------------->   
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->   

<!--  현재 페이지 Javascript  -------------------------------------------->
<script >
   function cal_price() 
   {
      form2.prices.value = (form2.num.value * form2.price.value).toLocaleString();
      form2.num.focus();
   }

   function check_form2(str) 
   {
      if (form2.opts1.value==0) {
         alert("옵션1을 선택하십시요.");
         form2.opts1.focus();
         return;
      }
      if (form2.opts2.value==0) {
         alert("옵션2를 선택하십시요.");
         form2.opts2.focus();
         return;
      }
      if (!form2.num.value) {
         alert("수량을 입력하십시요.");
         form2.num.focus();
         return;
      }
      if (str == "D") {
         form2.action = "order.html";
         form2.kind.value = "order";
         form2.submit();
      }
      else {
         form2.action = "cart_edit.php";
         form2.submit();
      }
   }
</script>

<!-- form2 시작  -->

<form name="form2" method="post" action="">
<input type="hidden" name="kind" value="insert">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="price" value="<?=$price;?>">

<!--  상품 사진/정보(제품명,가격,옵션)  -->
<div class="row mx-1 my-4">
   <div class="col" align="center">

      <table class="table table-sm table-borderless">
         <tr>
            <td valign="top" align="center" width="50%">
               <img src="product/<?=$imagename2;?>" width="80%" 
                  class="img-thumbnail img-fluid mt-2"  style="cursor:zoom-in" 
                  data-bs-toggle="modal" data-bs-target="#zoomModal">
            </td>
            <td  width="50%" align="left" valign="top" class="px-0">
               <hr size="5px" width="100%" class="my-2">
               <table width="100%" style="font-size:12px;" class="table table-sm table-borderless p-0 m-0">
                  <tr height="50">
                     <td colspan="2"  align="left" style="font-size:20px; color: #222222;">
                        <?=$row["name"];?>
                     </td>
                  </tr>
                  <tr height="35">
                     <td colspan="2" align="left">
                     <?
                        echo ($row["icon_new"]==1) ? '<img src="images/i_new.gif">&nbsp;' : '';
                        echo ($row["icon_hit"]==1) ? '<img src="images/i_hit.gif">&nbsp;' : '';
                        echo ($row["icon_sale"]==1) ? '<img src="images/i_sale.gif">&nbsp;<br><font color="red" size="3">' .$row["discount"]. "%". '</font>' : '';
                        
                     ?>
                        
                     </td>
                  </tr>
                  
                  <tr><td colspan="2"><hr class="my-2"></td></tr>
                  <?
                     if ($row["icon_sale"] == 1) {

                  ?>
                           <tr height="35">
                              <td width="30%" align="left">판매가</td>
                              <td width="70%" align="left" style="font-size:15px;"><strike><?=$formatted_price;?>원</strike></td>
                           </tr>
                           <tr height="35">
                              <td  align="left">할인가</td>
                              <td style="font-size:15px;" align="left"><?=$discounted_price;?> 원</td>
                           </tr>
                  <?      
                        } 
                        else {
                           
                  ?>
                           <tr height="35">
                           <td width="30%" align="left">판매가</td>
                           <td width="70%" align="left" style="font-size:15px;"><?=$formatted_price;?>원</td>
                           </tr>
                  <?
                        }
                        $sql="select * from opts where opt_id=$row[opt1] order by id";
                        $result=mysqli_query($db,$sql);
                        if(!$result)exit("에러: $sql");
                        
                        if (mysqli_num_rows($result) > 0) {
                  ?>
                  
                  <tr><td colspan="2"><hr class="my-2"></td></tr>
                  <tr>
                     <td align="left">옵션1</td>
                     <td  align="left">
                        <select name="opts1" class="form-select form-select-sm mb-2" style="width:90%;font-size:12px;">
                        <option value='0' selected>옵션을 선택하세요.</option>
                        <?
                           while ($row1 = mysqli_fetch_array($result)) 
                           {
                              if (isset($_REQUEST["opt1"]) && $_REQUEST["opt1"] == $row1["id"]) 
                              {
                                 echo("<option value='" . $row1["id"] . "' selected>" . $row1["name"] . "</option>");
                              }
                              else 
                              {
                                 echo("<option value='" . $row1["id"] . "'>" . $row1["name"] . "</option>");
                              }
                           }
                        ?>
                           
                        </select>
                     </td>
                  </tr>
                  <?
                        }
                     $sql="select * from opts where opt_id=$row[opt2] order by id";
                        $result=mysqli_query($db,$sql);
                        if(!$result)exit("에러: $sql");
                        if (mysqli_num_rows($result) > 0) {
                  ?>
                  <tr>
                     <td align="left">옵션2</td>
                     <td  align="left">
                        <select name="opts2" class="form-select form-select-sm" style="width:90%;font-size:12px;">
                        <option value='0' selected>옵션을 선택하세요.</option>
                           <?
                           while ($row1 = mysqli_fetch_array($result)) 
                           {
                              if (isset($_REQUEST["opt2"]) && $_REQUEST["opt2"] == $row1["id"]) 
                              {
                                 echo("<option value='" . $row1["id"] . "' selected>" . $row1["name"] . "</option>");
                              }
                              else 
                              {
                                 echo("<option value='" . $row1["id"] . "'>" . $row1["name"] . "</option>");
                              }
                           }
                           ?>
                           
                        </select>
                     </td>
                  </tr>
                  <?
                  }
                  ?>
                  <tr><td colspan="2"><hr class="my-2"></td></tr>
                  <tr>
                     <td align="left">수량</td>
                     <td  align="left">
                        <div class="d-inline-flex">
                           <input type="text" name="num" size="5" value="1" 
                              class="form-control form-control-sm" style="text-align:center;"
                              onChange="javascript:cal_price()">
                        </div>
                     </td>
                  </tr>
                  
                  <tr>
                     <td align="left">금액</td>
                     <td align="left">
                        <div class="d-inline-flex">
                           <input type="text" name="prices" value="<?=($row["icon_sale"]==1) ? $discounted_price : $formatted_price;?>" size="10" 
                              class="form-control form-control-sm"
                              style="border:0;background-color:white;text-align:left;font-size:18px;font-weight:bold;" readonly>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" height="100" align="center">
                        <a href="javascript:check_form2('D')" 
                           class="btn btn-sm btn-secondary text-light">바로 구매</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:check_form2('C')" 
                           class="btn btn-sm btn-outline-secondary">장바구니</a>
                     </td>
                  </tr>
               </table>

            </td>
         </tr>
      </table>

   </div>
</div>

</form>
<!-- form2 끝 -->

<hr class="my-0 mx-3">

<div align="center">
<?
   if($row["image3"]) {
?>
   <br>
   본 제품의 상세설명은 다음과 같습니다....
   <br><br><br>
<?
      echo "<img src='product/$row[image3]'>";
   }
?>
   <br><br>
   
</div>   

<br><br>

<!-- Zoom Modal 이미지 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="zoomModalLabel"><?=$row["name"];?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div align="center" class="modal-body">
        <img src="product/<?=$imagename2;?>" class="img-thumbnail" style="cursor:pointer" class="btn-close"  data-bs-dismiss="modal" aria-label="Close">
      </div>
    </div>
  </div>
</div>

<!-------------------------------------------------------------------------------------------->   
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->   

<?
   include "main_bottom.php";
?>

<!-------------------------------------------------------------------------------------------->   
</div>

</body>
</html>
