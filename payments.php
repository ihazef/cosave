<?php include 'db_connect.php'; 

 ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Payment List</b>
					<button class="btn btn-primary  col-md-2 float-right" type="button" id="new_payments"><i class="fa fa-plus"></i> New Payment</button>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Loan Reference No</th>
							<th class="text-center">Payee</th>
							<th class="text-center">Next Month</th>
							<th class="text-center">Amount/<br>payed</th>
							<th class="text-center">Amount/<br>unpaid</th>
							<th class="text-center">Penalty</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
							$month=" ";
							// $qry = $conn->query("SELECT *,l.ref_no,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address from borrowers b inner join loan_list l on l.borrower_id = b.id order by b.id asc;");
				$qry = $conn->query("SELECT *,b.id as bid,l.amount as loani,sum(p.amount) as tot,l.id as lid,l.ref_no,b.status,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name,
				b.contact_no,  b.address from borrowers b inner join loan_list l on l.borrower_id = b.id  inner join payments p
				 on l.id=p.loan_id where l.status=1 order by b.id asc");
							while($row = $qry->fetch_assoc()):
								$id=$row['lid'];
								$qry2=$conn->query("SELECT * FROM loan_schedules where loan_id='$id' and payed='no'");
                             $row2=$qry2->fetch_assoc();
								$month=$row2['date_due']; 
								$interest=($row['loani']*5)/100 + $row['loani'];
								$unpaid=$interest-$row['tot'];
								$_SESSION['l_id']= $row['bid'];$_SESSION['name']= $row['name'];
						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td><a href="index.php?page=list&?l_id=<?php echo $row['ref_no'] ?>">
						 		<?php echo $row['ref_no'] ?></a>
						 	</td>
						 	<td>
						 		<?php echo $row['name'] ?>
						 		
						 	</td>
							<td>
						 		<?php echo  $month;
								  ?>
						 		
						 	</td>
						 	<td class="text -center "><i class="badge badge-primary ">
						 		<?php echo number_format($row['tot'],2) ;

								//echo number_format($row['amount'],2)penalty_amount No penalty allowed
								 ?>
						 		
						 	</td> 	
							<td>
								<?php echo number_format($unpaid,2) ?>
							</td>
							<td class="text -center">
						 		<i class="badge badge-primary "> <?php echo $add = (date('Ymd',strtotime($month)) < date("Ymd") ) ?  number_format($row['penalty_amount'],2) : " No penalty allowed </i>";

							
								 ?>
						 		
						 	</td>
						 
						 	<td class="text-center">
						 			<button class="btn btn-primary edit_payment" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 	</td>

						 </tr>

						<?php  endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#loan-list').dataTable()
	$('#new_payments').click(function(){
		uni_modal("New Payement","manage_payment.php",'mid-large')
	})
	$('.edit_payment').click(function(){
		uni_modal("Edit Payement","manage_payment.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this data?","delete_payment",[$(this).attr('data-id')])
	})
function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Payment successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>