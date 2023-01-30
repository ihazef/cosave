<?php include 'db_connect.php';

?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
				<center>	<b>
						Payment List of 
						<?php
						echo "<mark style='color:green'>".$_SESSION['name']."</mark>";
						?></b>
				</large>
</center>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Loan Reference No</th>
							<th class="text-center">Payee</th>
							<th class="text-center">Month</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Penalty</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
							$l_id=$_SESSION['l_id'];
							$i=1;
							$month=" ";
							// $qry = $conn->query("SELECT *,l.ref_no,concat
							//(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address from borrowers b inner join loan_list l on l.borrower_id = b.id order by b.id asc;");
				$qry = $conn->query("SELECT *,l.amount as loan,l.id as lid,l.ref_no,b.status,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name,
				b.contact_no,  b.address from borrowers b inner join loan_list l on l.borrower_id = b.id  inner join payments p
				 on l.id=p.loan_id where l.status=1 and b.id='$l_id' order by p.id asc limit 6");
							while($row = $qry->fetch_assoc()):
								$id=$row['lid'];
								if ($i>=6) {
									break;
								}
								$qry2=$conn->query("SELECT * FROM loan_schedules where loan_id='$id' limit 6");
                             while($row2=$qry2->fetch_assoc()):
								$month=$row2['date_due']; 
								$yes=$row2['payed']=='yes'? number_format($row['loan']/6): "<b>not yet paid</b>";
						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<?php echo $row['ref_no'] ?>
						 	</td>
						 	<td>
						 		<?php echo $row['name'] ?>
						 		
						 	</td>
							<td>
						 		<?php echo  $month;
								  ?>
						 		
						 	</td>
						 	<td class="text -center "><i class="badge badge-primary ">
						 		<?php echo $yes;

								//echo number_format($row['amount'],2)penalty_amount No penalty allowed
								 ?>
						 		
						 	</td> 	
							<td class="text -center">
						 		 <?php echo $pen= $yes<>'<b>not yet paid</b>' ?  number_format($row['penalty_amount'],2):"<i>coming soon</i>";

							
								 ?>
						 		
						 	</td>
						 
						 	>

						 </tr>
						<?php endwhile;
						
					
					 endwhile; ?>
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