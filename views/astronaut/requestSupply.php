<?php include '../views/common/header.php'; ?>

<h2>Supply Chain Management</h2>

<div class="dashboard-grid">
    <div class="auth-card" style="margin: 0; max-width: 100%;">
        <h3>Requisition Form</h3>
        <form action="index.php?action=request_supply" method="POST">
            <div class="form-group">
                <label>Target Mission</label>
                <select name="mission_id" class="form-control" required>
                    <?php foreach($myMissions as $mission): ?>
                        <option value="<?php echo $mission['id']; ?>"><?php echo htmlspecialchars($mission['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Item Description</label>
                <input type="text" name="item_name" class="form-control" placeholder="e.g., Oxygen Cylinders" required>
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="1" min="1" required>
            </div>

            <button type="submit" class="btn">Submit Requisition</button>
        </form>
    </div>

    <!-- Request History -->
    <div style="grid-column: span 2;">
        <h3>Requisition Status</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myRequests as $req): ?>
                        <tr>
                            <td><?php echo $req['request_date']; ?></td>
                            <td><?php echo htmlspecialchars($req['item_name']); ?></td>
                            <td><?php echo $req['quantity']; ?></td>
                            <td>
                                <span class="badge" style="color: <?php echo $req['status']=='pending'?'var(--primary-color)':'#a0a6cc'; ?>">
                                    <?php echo strtoupper($req['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
