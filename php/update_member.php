<?php
include_once 'header.php';
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_id'])) {
    // Retrieve form data
    $member_id = $_POST['member_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    
    // Update user record in the database
    $stmt = $conn->prepare("UPDATE member SET first_name=?, last_name=?, birthday=?, email=? WHERE member_id=?");
    $stmt->bind_param("sssss", $first_name, $last_name, $birthday, $email, $member_id);
    $stmt->execute();
    $stmt->close();

    header('Location:display_member.php?stat=Updated_successfully');
    exit();
}

// Fetch user information for display
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $member_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM member WHERE member_id = ?");
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member= $result->fetch_assoc();
    $stmt->close();
}
?>

<a href="#" class="nav_logo1">Dashboard</a>                              <!--TODO ADD -->             

<ul class="nav_items">
<li class="nav_item">
    <a href="#" class="nav_link">Home</a>                                               
    <a href="#" class="nav_link">Member Registration</a>
    <a href="display_member.php" class="nav_link">Member Management</a>
    <p class="my_account">
      <i class="uil uil-user" style="color: #fff;"></i>
      <span style="color: #fff;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
    </p>
    <button class="button2" id="logoutBtn">Logout</button>
  </li>
</ul>
</nav>
</header>
<main class="body1">
  <main class="table" data-aos="zoom-in">
    <div class="header_container">
      <h1 class="header_title">Library Members</h1>
      <button class="button2 add_member_button" onclick="window.location.href='#'">Add New Member</button>
    </div>
    <section class="table_body">
      <table>
              <thead>
                  <tr>
                    <th>Meember ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birthday</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <form id="editForm" action="update_member.php" method="post">
                    <td><?php echo isset($member['member_id']) ? htmlspecialchars($member['member_id']) : ''; ?></td>
                    <td><input type="text" class="rounded-input" name="first_name" id="first_name" value="<?php echo isset($member['first_name']) ? htmlspecialchars($member['first_name']) : ''; ?>" required></td>
                    <td><input type="text" class="rounded-input" name="last_name" id="last_name" value="<?php echo isset($member['last_name']) ? htmlspecialchars($member['last_name']) : ''; ?>" required></td>
                    <td><input type="date" class="rounded-input" name="birthday" id="birthday" value="<?php echo isset($member['birthday']) ? htmlspecialchars($member['birthday']) : ''; ?>" required></td>
                    <td><input type="email" class="rounded-input" name="email" id="email" value="<?php echo isset($member['email']) ? htmlspecialchars($member['email']) : ''; ?>" required></td>
                    <td><a href="#" id="updateLink">Update</a></td>
                    <input type="hidden" name="member_id" value="<?php echo isset($member['member_id']) ? htmlspecialchars($member['member_id']) : ''; ?>">
                  </form>
                </tr>
              </tbody>
          </table>
        </section>
      </main>
    </main>
  
  <script>
    document.getElementById("updateLink").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById('editForm').submit();
    });
  </script>


<?php
include_once 'footer.php';
$conn->close();
?>
