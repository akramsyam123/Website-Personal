<tr>
  <td height="27" bgcolor="#003300"><span class="style10"><strong>Search User</strong></span></td>
</tr>
<tr>
  <td height="26">
    <form id="formSearch" name="formSearch" method="get" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="32">Search by Username:</td>
          <td>
            <label>
              <input type="text" name="searchQuery" id="searchQuery" value="<?php echo isset($_GET['searchQuery']) ? $_GET['searchQuery'] : ''; ?>" />
            </label>
          </td>
          <td>
            <label>
              <input type="submit" name="searchButton" id="searchButton" value="Search" />
            </label>
          </td>
        </tr>
      </table>
    </form>
  </td>
</tr>
<tr>
  <td height="25" bgcolor="#003300"><span class="style10"><strong>User List</strong></span></td>
</tr>
<tr>
  <td>
    <table width="100%" border="1" bordercolor="#003300">
      <tr>
        <th height="32" bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Id</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>UserName</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Edit</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style12">Delete</div></th>
      </tr>
      <?php
      $con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");
      $searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';
      
      // Query untuk menampilkan data berdasarkan pencarian
      if ($searchQuery) {
          $sql = "SELECT * FROM admin_master WHERE UserName LIKE '%" . mysqli_real_escape_string($con, $searchQuery) . "%'";
      } else {
          $sql = "SELECT * FROM admin_master";
      }
      
      $result = mysqli_query($con, $sql);
      
      while ($row = mysqli_fetch_array($result)) {
          $Id = $row['AdminId'];
          $UserName = $row['UserName'];
      ?>
      <tr>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Id; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $UserName; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><a href="EditUser.php?AdminId=<?php echo $Id; ?>">Edit</a></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><a href="DeleteUser.php?AdminId=<?php echo $Id; ?>">Delete</a></strong></div></td>
      </tr>
      <?php
      }
      // Retrieve Number of records returned
      $records = mysqli_num_rows($result);
      ?>
      <tr>
        <td colspan="4" class="style3"><div align="left" class="style12"><?php echo "Total " . $records . " Records"; ?> </div></td>
      </tr>
      <?php
      // Close the connection
      mysqli_close($con);
      ?>
    </table>
  </td>
</tr>
