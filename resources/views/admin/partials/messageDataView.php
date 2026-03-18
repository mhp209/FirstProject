<table>
    <?php if ($safety_option): ?>
        <thead>
            <tr>
                <th>Name:</th> 
                <td><?= $safety_option['reason_option'] ?></td>
            </tr>
            <tr>
                <th>Alias Name:</th>
                <td><?= $safety_option['alias'] ?></td>
            </tr>
            <tr>
                <th>Message:</th>
                <td><?= $safety_option['message'] ?></td>
            </tr>
        </thead>
    <?php else: ?>
        <p>Reason Details not found.</p>
    <?php endif; ?>
</table>