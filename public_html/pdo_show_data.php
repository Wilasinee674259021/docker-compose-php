<?php
    // กำหนดตัวแปรสำหรับเชื่อมต่อฐานข้อมูล PDO
    $servername = "db";        // ชื่อ service ของ mariadb ใน docker-compose
    $username   = "admin";     // หรือใช้ "root" ก็ได้
    $password   = "1234";      // รหัสผ่านที่ตั้งไว้ใน docker-compose
    $dbname     = "titanic";   // แก้ให้ตรงกับ MYSQL_DATABASE
    
    try {
        // เชื่อมต่อด้วย PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // ดึงข้อมูล (เปลี่ยนชื่อตารางให้ตรงกับตารางที่มีในฐานข้อมูล titanic เช่น titanic หรือ passengers)
        $sql = "SELECT * FROM titanic"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDO Show Data</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container mt-4">
    
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">แสดงข้อมูล (PDO)</h4>
                <span class="badge bg-light text-dark">ทั้งหมด <?= count($result); ?> รายการ</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <?php if (!empty($result)): ?>
                                    <?php foreach (array_keys($result[0]) as $column): ?>
                                        <th><?= htmlspecialchars($column); ?></th>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <th>ข้อมูล</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($result)): ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <?php foreach ($row as $value): ?>
                                            <td><?= htmlspecialchars($value ?? ''); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="100%" class="text-center text-muted">ไม่พบข้อมูล</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>
    </html>
    <?php
    // ปิดการเชื่อมต่อ
    $conn = null;
    ?>