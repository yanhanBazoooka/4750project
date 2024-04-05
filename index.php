<?php include('header.php'); ?>

<main>
    <table>
        <thead>
            <tr>
                <th>League</th>
                <th>Team</th>
                <th>Position</th>
                <th>Player</th>
                <th>Kill</th>
                <th>Death</th>
                <th>Assist</th>
                <!-- More headers -->
            </tr>
        </thead>
        <tbody>
            <?php
            include('connect-db.php');

            $sql = "SELECT * FROM stats_table"; // Replace with your actual table name
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['league']}</td>
                            <td>{$row['team']}</td>
                            <td>{$row['position']}</td>
                            <td>{$row['player']}</td>
                            <td>{$row['kill']}</td>
                            <td>{$row['death']}</td>
                            <td>{$row['assist']}</td>
                            <!-- More data -->
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No results found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</main>

<?php include('footer.html'); ?>
<footer class="primary-footer bg-dark p-2" style="margin-bottom: 0rem;">
  <small class="copyright" style="color:white">&copy; Your name</small>
  
  <div style="padding:6px 16px 20px 6px">
    <small class="copyright" style="color:white">        
    League of Legends Pro Stats
    </small>
  </div>
</footer>
