
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Request and Transfer</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5 row">
        <h1>Fund Request and Transfer</h1>
        <!-- Fund Request Form -->
        <div class="card mt-4 col">
            <div class="card-body">
                <h2>Request Funds</h2>
                <form action="{{ route('requestFund') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="requestAmount" class="form-label">Amount to Request</label>
                        <input type="number" class="form-control" id="requestAmount" name="requestAmount" required> 
                    </div>
                    <div class="mb-3">
                        <label for="requestAmount" class="form-label">Currency to Request</label>
                        <input type="text" class="form-control" id="requestCurrency" name="requestCurrency" required> 
                    </div>
                    {{-- <div class="mb-3">
                        <label for="requestReason" class="form-label">Reason for Request</label>
                        <textarea class="form-control" id="requestReason" name="requestReason" rows="3" required></textarea>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
            </div>
        </div>
        
        <!-- Fund Transfer Form -->
        <div class="card mt-4 col">
            <div class="card-body">
                <h2>Transfer Funds</h2>
                <form action="process_transfer.php" method="POST">
                    <div class="mb-3">
                        <label for="recipientAccount" class="form-label">Recipient Account</label>
                        <input type="text" class="form-control" id="recipientAccount" name="recipientAccount" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="transferAmount" class="form-label">Amount to Transfer</label>
                        <input type="number" class="form-control" id="transferAmount" name="transferAmount" required>
                    </div> --}}
                    <button type="submit" class="btn btn-success">Transfer Funds</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
