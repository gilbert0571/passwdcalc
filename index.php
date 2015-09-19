<meta http-equiv="content-type" content="text/html; charset=gb2312" />
<?php
$cal_method="+";
 
if(!empty($_POST)){
  if(isset($_POST["domain"])&& isset($_POST["keyword"])){
    if(empty($_POST["domain"])){
        echo "<font color=#FF0000>域名不能为空</font><br>";
        unset($_POST["sub"]);
    }
    if(empty($_POST["keyword"])){
        echo "<font color=#FF0000>密钥不能为空</font><br>";
        unset($_POST["sub"]);
    }
  if (isset($_POST["sub"])){
  $domain=$_POST['domain'];
  $keyword=$_POST['keyword'];
  $cal_method=$_POST['cal_method'];
  $domain_internal=iconv("gbk","UTF-8",$domain);
  //echo strlen($domain_internal)."\n";
  //echo dechex(ord($domain_internal[0])) ."\n";
  //echo dechex(ord($domain_internal[1])) ."\n";  
  	//echo "PHP版本:".phpversion() . "\n";
	//$domain="QQ";
	//$keyword="010107207";
	$str1=GetPass($domain_internal . $keyword,$cal_method);
	$str2=GetPass($domain_internal . $str1,$cal_method);
	$result= $str1 . $str2;
}
//	echo substr($result,0,4) ."\n";
//	echo substr($result,4,4)."\n";
//	echo substr($result,8,4)."\n";
//	echo substr($result,12,4)."\n";

	//var_dump($result);
 
  
  
 // echo "domain=$domain<br>";
  //echo "keyword=$keyword<br>";
  //echo "cal_method=$cal_method<br>";
 
    /*if($cal_method=="/" || $cal_method=="%"){
        if($keyword==0){
            echo "<font color=#FF0000>0不能作为除数！</font><br>";
            unset($_POST["sub"]);  
        }
    }*/
} 
  //switch($cal_method){
 //   case "+";
  //    $result=$domain+$keyword;break;
  //  }
    

}

function getShortStr($l,$cal_method){
		$Seed_symbol="*#&@!$%^~`0aA1bB2cC3Dd4eE5fF6gG7hH8iI9jJ0kK1lL2mM3nN34oO5pP6qQ7rR8sS9tTuUvVwWxXyYzZ*#&@!$%^~`";
		$Seed_digit="0123456789";
		$Seed_text="0aA1bB2cC3Dd4eE5fF6gG7hH8iI9jJ0kK1lL2mM3nN34oO5pP6qQ7rR8sS9tTuUvVwWxXyYzZ";
		 switch($cal_method){
     case "sym";
       $Seed = $Seed_symbol;break;
     case "dig";
       $Seed = $Seed_digit;break;
     case "alp";
       $Seed = $Seed_text;break;
     default:
       $Seed = $Seed_symbol;        
    }

		$seed_len= strlen($Seed);
		//echo "seed_len=" .$seed_len ."\n";
		$sb="";	$n=0;
		$l=gmp_strval(gmp_div_q("0x" . $l , "1"));
		while (((int)($l) > 1) && $n <32 ){
		    //var_dump($l);
		    $id= gmp_strval(gmp_div_r($l, $seed_len));
		    //var_dump($id);
			$sb .= $Seed[(int)($id)];
			//var_dump($sb);
			$l=gmp_strval(gmp_div_q($l , $seed_len));	 
			$n ++;
		}
		return $sb;
}

function GetHex($string){
    $hex='';
    for ($i=0; $i < 7; $i++){
        $hex = $string[$i*2]. $string[$i*2+1].$hex;
    }
    $head=hexdec ($string[$i*2]) &7;
    $head=dechex($head);
    $hex = $head. $string[7*2+1].$hex;
    return $hex;
}
function GetPass($data,$cal_method){
    $str=md5($data);
    $md5vale_str= GetHex($str);
    //$div1 = gmp_div_q("0x" . $md5vale, "1");
    //echo gmp_strval($div1) . "\n";
    //$md5vale= hexdec($md5vale_str) ;
    //printf("0x:%x\nld:%ld\n",$md5vale,$md5vale) ;
    $str1 = getShortStr($md5vale_str,$cal_method);
    return $str1;
}

?>
 
<html>
 <script>
function change(value){
<!--alert(value);-->
document.getElementById("showtext").value= document.getElementById("showtext").value + document.getElementById(value).value;
}
</script>

  <head>
    <title>Password Calculator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="./css/bootstrap.min.css"> 
    <style>
        body {
          background-color: #f5f5f5;
        }
        table,textarea{
          text-align: center;  
          border-collapse:separate;
          border-spacing:10px;  
        }
        div{margin:8px 8px;} 
        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
               -moz-border-radius: 5px;
                border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
               -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
            margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
            }
     </style>  
  </head>   
  </head>
  <body>

    <h1 align="center">密码计算器</h1>
<form class="form-signin" role="form" align="center" action="" method="post">
  <div class="form-group" align="center">
    <label class="sr-only" for="exampleInputEmail2">domain</label>
    <input style="width:100%"   type="text" class="form-control"  placeholder="请输入域名" value="<?php  echo isset($domain)?$domain:"";?>" name="domain">
  </div>
  <div class="form-group" align="center">
    <label class="sr-only" for="exampleInputPassword2">keyword</label>
    <input style="width:100%"  type="password" class="form-control"  placeholder="请输入密钥" value="<?php  echo isset($keyword)?$keyword:"";?>" name="keyword">
  </div>
    <div class="form-group" align="center">
    <select class="form-control" name="cal_method" style="width:100%" > 
      <option <?php if ($cal_method == "sym"){echo "selected='selected'";} ?> value="sym" >字符</option>
      <option <?php if ($cal_method == "dig"){echo "selected='selected'";} ?> value="dig" >数字</option>
      <option <?php if ($cal_method == "alp"){echo "selected='selected'";} ?> value="alp" >字母</option>      
    </select>
  </div> 
  <div align="center"><button type="submit" class="btn btn-default"  name="sub" style="width:60px">计算</button></div>
  <!--<div class="clearfix" />-->
  <div class="form-group clearfix" align="center">
  <textarea  class="form-control"  rows="1"  id="showtext" style="width:100%" >  </textarea> 
  </div> 
  <div class="form-group clearfix" align="center">
  <table style="width:100%">
    <tr>
      <td><input style="width:100%" type="button" id="b1" onclick="change('b1')" value= <?php echo isset($result)?substr($result,0,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b2" onclick="change('b2')" value= <?php echo isset($result)?substr($result,1,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b3" onclick="change('b3')" value= <?php echo isset($result)?substr($result,2,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b4" onclick="change('b4')" value= <?php echo isset($result)?substr($result,3,1):"?" ;?>  ></input> </td>
    </tr>
    <tr>
      <td><input style="width:100%" type="button" id="b5" onclick="change('b5')" value= <?php echo isset($result)?substr($result,4,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b6" onclick="change('b6')" value= <?php echo isset($result)?substr($result,5,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b7" onclick="change('b7')" value= <?php echo isset($result)?substr($result,6,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b8" onclick="change('b8')" value= <?php echo isset($result)?substr($result,7,1):"?" ;?>  ></input> </td>
    </tr>
    <tr>
      <td><input style="width:100%" type="button" id="b9" onclick="change('b9')" value= <?php echo isset($result)?substr($result,8,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b10" onclick="change('b10')" value= <?php echo isset($result)?substr($result,9,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b11" onclick="change('b11')" value= <?php echo isset($result)?substr($result,10,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b12" onclick="change('b12')" value= <?php echo isset($result)?substr($result,11,1):"?" ;?>  ></input> </td>
    </tr>
    <tr>
      <td><input style="width:100%" type="button" id="b13" onclick="change('b13')" value= <?php echo isset($result)?substr($result,12,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b14" onclick="change('b14')" value= <?php echo isset($result)?substr($result,13,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b15" onclick="change('b15')" value= <?php echo isset($result)?substr($result,14,1):"?" ;?>  ></input> </td>
      <td><input style="width:100%" type="button" id="b16" onclick="change('b16')" value= <?php echo isset($result)?substr($result,15,1):"?" ;?>  ></input> </td>
    </tr>
  </table>
  </div> 
</form>
    <!--<script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>-->
    <!--<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>-->
    <script src="./query.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>
<script>
//去除新浪弹窗
window.onload = function(){
    if(document.body.lastChild.nodeName == "DIV"){
        document.body.lastChild.getElementsByTagName("div")[0].lastChild.click();
    }
    if(document.body.lastChild.nodeName == "DIV"){
        document.body.appendChild = function(div){
            return true;
        };
        document.body.removeChild(document.body.lastChild);
    }
};
</script>