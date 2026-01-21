<?php include '../views/common/header.php'; ?>

<div class="page-admin-supplies">
    <h2>Supply Request Logistics</h2>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Astronaut</th>
                    <th>Mission</th>
                    <th>Item Requested</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($supplyRequests as $request): ?>
                    <tr>
                        <td><?php echo $request['request_date']; ?></td>
                        <td><?php echo htmlspecialchars($request['astronaut_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['mission_title']); ?></td>
                        <td><?php echo htmlspecialchars($request['item_name']); ?></td>
                        <td><?php echo $request['quantity']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($supplyRequests)): ?>
                    <tr><td colspan="5">No supply requests found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
