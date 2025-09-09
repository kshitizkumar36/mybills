
<?php  include'header.php'; ?>
  <!-- CREDIT ENTRY FORM -->
  <section id="credit" class="container my-5">
    <h3 class="mb-4 text-success">💰 Credit Entry</h3>
    <div class="row g-3">
      <!-- Invoice For -->
      <div class="col-md-4 col-sm-6">
          <form method="post" action="backend.php" enctype="multipart/form-data">
        <label for="credit_source" class="form-label">Credit Source</label>
        <select class="form-control" id="credit_source" name="credit_source">
          <option selected disabled>Please Select</option>
          <option value="rajeshsir">Rajesh Bagga</option>
        
        </select>
      </div>

      <!-- Amount -->
      <div class="col-md-4 col-sm-6">
        <label for="creditAmount" class="form-label">Amount Credited</label>
        <input type="number" class="form-control" id="creditAmount" name="credit_amount">
      </div>

      <!-- Date & Time -->
      <div class="col-md-4 col-sm-6">
        <label for="creditDateTime" class="form-label">Date & Time</label>
        <input type="datetime-local" class="form-control" id="creditDateTime" name="credit_datetime">
      </div>

      <!-- Proof -->
      <div class="col-md-4 col-sm-6">
        <label for="creditProof" class="form-label">Proof</label>
        <input type="file" class="form-control" id="creditProof" name="credit_proof">
      </div>
    </div>

    <!-- Submit -->
    <div class="row mt-4">
      <div class="col text-center">
        <button type="submit" name="add_credit" class="btn btn-success px-4">Submit Credit</button>
      </div>
    </div>
    </form>
  </section>



  <!-- CREDIT HISTORY TABLE -->
  <section id="creditHistory" class="container my-5">
    <h3 class="mb-4 text-success">📊 Credit History</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Invoice For</th>
            <th>Amount</th>
            <th>Date & Time</th>
            <th>Proof</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
include'connection.php';

$query1= "SELECT * FROM `credits` ORDER BY `id` desc";
$run1= mysqli_query($conn,$query1);


?>

<?php  while($data1= mysqli_fetch_assoc($run1)) { ?>
          <tr>
            <td><?php echo $data1['id']; ?></td>
            <td><?php echo $data1['source']; ?></td>
            <td><?php echo $data1['amount']; ?></td>
            <td><?php echo $data1['date_time']; ?></td>
            <td><a href="<?php echo $data1['proof']; ?>">View</a></td>
          </tr>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>

<?php include'footer.php'; ?>