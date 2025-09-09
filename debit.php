
<?php  include'header.php'; ?>


  <!-- DEBIT ENTRY FORM -->
  <section id="debit" class="container my-5">
    <h3 class="mb-4 text-danger">💸 Debit Entry</h3>
    <div class="row g-3">
      <!-- Invoice For -->
      <div class="col-md-4 col-sm-6">
       <form method="post" action="backend.php" enctype="multipart/form-data">

        <label for="debitFor" class="form-label">Invoice For</label>
        <select class="form-control" id="debitFor" name="debit_for">
          <option selected disabled>Please Select</option>
          <option value="train">Train</option>
          <option value="travel">Cab/Bike - Taxi</option>
          <option value="fooding">Fooding / Snacks / Lunch</option>
          <option value="hotel">Hotels</option>
          <option value="others">Others</option>
        </select>
      </div>

      <!-- Amount -->
      <div class="col-md-4 col-sm-6">
        <label for="debitAmount" class="form-label">Amount Paid</label>
        <input type="number" class="form-control" id="debitAmount" name="debit_amount">
      </div>

      <!-- Date & Time -->
      <div class="col-md-4 col-sm-6">
        <label for="debitDateTime" class="form-label">Date & Time</label>
        <input type="datetime-local" class="form-control" id="debitDateTime" name="debit_datetime">
      </div>

      <!-- Proof -->
      <div class="col-md-4 col-sm-6">
        <label for="debitProof" class="form-label">Proof</label>
        <input type="file" class="form-control" id="debitProof" name="debit_proof">
      </div>
    </div>

    <!-- Submit -->
    <div class="row mt-4">
      <div class="col text-center">
        <button name="add_debits" type="submit" class="btn btn-danger px-4">Submit Debit</button>
      </div>
    </div>
    </form>
  </section>

  

  <!-- DEBIT HISTORY TABLE -->
  <section id="debitHistory" class="container my-5">
    <h3 class="mb-4 text-danger">📉 Debit History</h3>
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

$query1= "SELECT * FROM `debits` ORDER BY `id` desc";
$run1= mysqli_query($conn,$query1);


?>

<?php  while($data1= mysqli_fetch_assoc($run1)) { ?>
          <tr>
            <td><?php echo $data1['id']; ?></td>
            <td><?php echo $data1['invoice_for']; ?></td>
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