<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-2</title>
</head>
<body>
    
<?php
    $dsn = ʼデータベース名ʼ;
	$user =  ʼユーザー名ʼ;
	$password = ʼパスワードʼ;
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date TEXT,"
	. "pw TEXT,"
	.");";
	$stmt = $pdo->query($sql);
	
	$name = $_POST["name"];
	$comment = $_POST["comment"]; 
    $date = date("Y/m/d/ H:i:s");
    $pw = $_POST["password"]; 

    $dum = $_POST["dum"];
    $delete = $_POST["del"];
    $delpw = $_POST["delpass"];
    $edi = $_POST["edi"];
    $edipw = $_POST["edipass"];

    if(empty($str)&&empty($name)&&empty($delete)&&empty($edi)&&empty($dum)&&empty($pw)&&empty($delpw)&&empty($edipw)) {
        echo "コメントが入力されていません。";
    }
    else{
        if((isset($str)||isset($name))&&empty($delete)&&empty($edi)&&empty($delpw)&&empty($edipw)){
            if(empty($dum)){
                $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, pw) VALUES (:name, :comment, :date, :pw)");
	            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $sql -> bindParam(':date', $date, PDO::PARAM_STR);		
                $sql -> bindParam(':pw', $pw, PDO::PARAM_STR);	   
	            $sql -> execute();
            }
        
            else{
                $id = $dum; 
	            $sql = 'UPDATE tbtest SET name=:name,comment=:comment,date=:date,pw=:pw WHERE id=:id';
            	$stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	            $stmt -> bindParam(':date', $date, PDO::PARAM_STR);		
                $stmt -> bindParam(':pw', $pw, PDO::PARAM_STR);	
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	            $stmt->execute();
            }
        }
        
        if(isset($delete)){
            $sql = 'SELECT * FROM tbtest';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
        		if($row['id']==$delete){
        		    if($row['pw'] != $delpw){
        		        echo "パスワードが違います。";
            		}
            		else{
            		    $id = $delete;
                        $sql = 'delete from tbtest where id=:id';
	                    $stmt = $pdo->prepare($sql);
	                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                    $stmt->execute();
        		    }
        		}    
	        }
        }
    
        if(isset($edi)){
            
            $sql = 'SELECT * FROM tbtest';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
        		if($row['id']==$edi){
        		    if($row['pw'] != $edipw){
        		        echo "パスワードが違います。";
            		}
            		else{  
            		    $edinum = $row['id'];
                        $ediname = $row['name'];
                        $edistr = $row['comment'];
                        $edipass = $row['pw'];
        		    }
        		}    
		    }
        }
        
    }
?>
    
    <form action="" method="post">
    <input type="text" name="name" placeholder="名前" value ="<?php echo $ediname;?>"><br>
    <input type="text" name="comment" placeholder="コメント" value ="<?php echo $edistr;?>">
    <input type="text" name="password" placeholder="パスワード" value ="<?php echo $edipass;?>">
    <input type="hidden" name="dum" placeholder="ダミー番号" value ="<?php echo $edinum;?>">   
    <input type="submit" name="submit"><br>
    <input type="number" name="del" placeholder="削除対象番号" style="width:100px">
    <input type="text" name="delpass" placeholder="パスワード" style="width:100px">
    <input type="submit" name="submit" value="削除"><br>
    <input type="number" name="edi" placeholder="編集対象番号" style="width:100px">
    <input type="text" name="edipass" placeholder="パスワード" style="width:100px">
    <input type="submit" name="submit" value="編集">
    </form>
    
<?php    
    $sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	echo "<hr>";
	}
     
?>

</body>
</html>