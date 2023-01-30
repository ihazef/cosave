<?php 

if ($_SERVER['REQUEST_METHOD']=='POST') {
if (empty($_REQUEST['amount'])) {
    echo "<script>alert('amount field is empty.. fiil and continue')</script>";
    echo "<script>window.location.replace('index.php?page=payments')</script>"; 
}
//echo $_REQUEST['loan_id'];
     include 'db_connect.php';
    $amount= $_POST['amount'];
    
    $loan_id= $_POST['loan_id'];
    $query="SELECT *from loan_list where id='$loan_id'";
    
    $select=$conn->query($query);
   $fetch=$select->fetch_array();
   $b=$fetch['barrower_id'];
   $barrower="SELECT * from borrowers where id='$b'";
   $bar=$conn->query($barrower);
   $bar=$bar->fetch_array();
   $payee=$bar['firstname']." ".$bar['middlename']." ".$bar['lastname'];
   $loan=$fetch['amount'];
    $interest=($loan*5)/100;
    $tot=$loan+($loan*5)/100;
    $monthly=$tot/6;
     $penalty=0;$over=0;
     $mon1=$monthly;
    $mon2=$mon1+$monthly;
    $mon3=$mon2+$monthly;
    $mon4=$mon3+$monthly;
    $mon5=$mon4+$monthly;
    $mon6=$mon5+$monthly;
    
    $date=date("ymd");
    $check=$conn->query("SELECT * from  loan_schedules where loan_id='$loan_id' and payed='no' limit 1");
 
    $check=$check->fetch_array();
$to=$check['date_due'];

    $now=strtotime($date);
// echo "loan = $loan ,interest = $interest, penalty= $penalty, tot = $tot ";
    $querytp="SELECT *, sum(amount) as am FROM `payments` where id='$loan_id' ";

    $payed=$conn->query($querytp);

    $payedd=$payed->fetch_array();
    $n=0;$under=true;
    $schedule=strtotime($to);
    $payed_amount=$payedd['am'];
    if ($schedule<$now)
     {
     $penalty=($interest*10)/100;
     $over=1;
    }
 $up=$payed_amount+$amount;
    if ($payedd['am']>0):
       if($up>=$mon1 || $up>=$mon2 || $up>=$mon3 || $up>=$mon4 || $up>=$mon5 || $up>=$mon6 ):
    $update=$conn->query("UPDATE loan_schedules set payed='yes' where loan_id='$loan_id' and date_due='$to'");
    $insert=$conn->query("INSERT into payments values('','$loan_id','$payee','$amount','$penalty','$over',now())");
    header("refresh:1;url=index.php?page=payments"); 
       else:
    $insert=$conn->query("INSERT into payments values('','$loan_id','$payee','$amount','$penalty','$over',now())");
    header("refresh:1;url=index.php?page=payments"); 
endif;
        

    else:
             $insert=$conn->query("INSERT into payments values('','$loan_id','$payee','$amount','$penalty','$over',now())");
        
            if ($insert) {
         if($amount==$mon1):
            $pdate=$conn->query("UPDATE loan_schedules set payed='yes' where loan_id='$loan_id' and date_due='$to'");
            if ($update) {
            header("refresh:1;url=index.php?page=payments");
            }  
            else{header("refresh:1;url=index.php?page=payments");}
             else:header("refresh:1;url=index.php?page=payments");
        endif;
        }
            
            else{
             echo "<script>alert('failed to pay loan')</script>";

              header("refresh:1;url=index.php?page=payments");
             }
   
  endif;
}
?>