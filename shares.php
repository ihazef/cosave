<?php include 'db_connect.php';
 include('indexl.php'); 
 
 ?>

<div class="container-fluid col-lg-20">
	<div class="col-lg-20">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b center>Loan List</b>
				</large>
				<!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->  
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="shares-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="25%">
                        <col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="25%">	
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
                            <th class="text-center">Member</th>
							<th class="text-center">jan</th>
							<th class="text-center">feb</th>
							<th class="text-center">march</th>
							<th class="text-center">april</th>
							<th class="text-center">may</th>
                            <th class="text-center">june</th>
							<th class="text-center">july</th>
							<th class="text-center">Aug</th>
							<th class="text-center">Sept</th>
                            <th class="text-center">Oct</th>
							<th class="text-center">Nov</th>
                            <th class="text-center">Dec</th>
                            <th class="text-center">Shares</th>
                            <th class="text-center">Value</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						//patienceigiraneza2@gmail.com
						
				
							$qry = $conn->query("SELECT *,concat(b.lastname,', ',b.firstname,' ',b.middlename)as 
							name, b.contact_no, b.address from borrowers b ");
							
							while($row = $qry->fetch_assoc()):
						 ?>
						 <tr>
						 	<!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->  
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p><b><?php echo $row['name'] ?></b></p>
						 		
						 	</td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							  <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							 <td class="text-center"> </td>
							
						 	<td class="text-center">
						 			<button class="btn btn-primary add_shares" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 	</td>

						 </tr>
<!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->  
						<?php endwhile; ?>
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
	$('#shares-list').dataTable()
	
	$('.add_shares').click(function(){
		uni_modal("Edit Loan","add_share.php?id="+$(this).attr('data-id'),'mid-large')
	})
	

</script>