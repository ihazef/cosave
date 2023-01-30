<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM payments where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}
}

?>
<div class="container-fluid">
    <div class="col-lg-12">
        <form method="POST" action="pay.php">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">Loan Reference No.</label>
                        <select name="loan_id" id="" class="custom-select browser-default select2">
                            <option value=""></option>
                            <?php 
							$loan = $conn->query("SELECT * from loan_list where status =1 ");
							while($row=$loan->fetch_assoc()):
							?>
                            <option value="<?php echo $row['id'] ?>"
                                <?php echo isset($loan_id) && $loan_id == $row['id'] ? "selected" : '' ?>>
                                <?php echo $row['ref_no'] ?></option>
                            <?php endwhile; ?>
                        </select>
                   </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label"> Amount to pay</label>
                    <input type="number" name="amount" class="form-control text-right" step="any" id="" required="">

                </div>
            </div>
    </div>
    
       

        </form>
    </div>
</div>
