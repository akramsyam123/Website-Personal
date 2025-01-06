<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>toko pakaian muslim azzahra</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style10 {color: #FFFFFF}
.style3 {font-weight: bold}
-->
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  
  <?php
  include "Header.php";
  ?>
  
  <div id="content">
    <h2><span style="color:#003300"> Category Management</span></h2>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27" bgcolor="#003300"><span class="style10"><strong>Create New Category</strong></span></td>
      </tr>
      <tr>
  <td height="26">
    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="32">Category Name (Search or Add):</td>
          <td>
            <label>
              <input type="text" name="txtName" id="txtName" value="<?php echo isset($_POST['txtName']) ? $_POST['txtName'] : ''; ?>" />
            </label>
          </td>
          <td>
            <label>
              <input type="submit" name="searchButton" id="searchButton" value="Search" />
            </label>
          </td>
          <td>
            <label>
              <input type="submit" name="addButton" id="addButton" value="Add Category" />
            </label>
          </td>
        </tr>
        <tr>
          <td height="34">Description:</td>
          <td>
            <label>
              <textarea name="txtDesc" id="txtDesc" cols="35" rows="3"></textarea>
            </label>
          </td>
        </tr>
        <tr>
          <td height="34">Upload Image:</td>
          <td>
            <label>
              <input type="file" name="txtFile" id="txtFile" />
            </label>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <label>
            </label>
          </td>
        </tr>
      </table>
    </form>
  </td>
</tr>
<tr>
  <td height="25" bgcolor="#003300"><span class="style10"><strong>Category List</strong></span></td>
</tr>
<tr>
  <td>
    <table width="100%" border="1" bordercolor="#003300">
      <tr>
        <th height="32" bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Id</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Category Name</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Description</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Edit</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style12">Delete</div></th>
      </tr>
      <?php
      // Database connection
      $con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");

      // Logika untuk tombol Search dan Add
      if (isset($_POST['addButton'])) {
          // Add new category logic
          $categoryName = $_POST['txtName'];
          $description = $_POST['txtDesc'];
          $insertQuery = "INSERT INTO Category_Master (CategoryName, Description) VALUES ('$categoryName', '$description')";
          mysqli_query($con, $insertQuery);
          echo "<p>Category added successfully!</p>";
      }

      // Logika pencarian
      $searchQuery = isset($_POST['txtName']) ? $_POST['txtName'] : '';
      if (!empty($searchQuery) && isset($_POST['searchButton'])) {
          // Search by Category Name
          $sql = "SELECT * FROM Category_Master WHERE CategoryName LIKE '%" . mysqli_real_escape_string($con, $searchQuery) . "%'";
      } else {
          // Default: fetch all records
          $sql = "SELECT * FROM Category_Master";
      }

      $result = mysqli_query($con, $sql);

      while ($row = mysqli_fetch_array($result)) {
          $Id = $row['CategoryId'];
          $CategoryName = $row['CategoryName'];
          $Description = $row['Description'];
      ?>
      <tr>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Id; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $CategoryName; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Description; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><a href="EditCategory.php?CatId=<?php echo $Id; ?>">Edit</a></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><a href="DeleteCategory.php?CatId=<?php echo $Id; ?>">Delete</a></strong></div></td>
      </tr>
      <?php
      }
      $records = mysqli_num_rows($result);
      ?>
      <tr>
        <td colspan="5" class="style3"><div align="left" class="style12"><?php echo "Total " . $records . " Records"; ?> </div></td>
      </tr>
      <?php
      mysqli_close($con);
      ?>
    </table>
  </td>
</tr>
    </table>
    <table width="100%" border="0" cellspacing="3" cellpadding="3">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p><img src="img/gamis.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
        <td><p><img src="img/abaya.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
        <td><p><img src="img/kaftan.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#BCE0A8"><div align="center" class="style9">gamis</div></td>
        <td bgcolor="#BCE0A8"><div align="center" class="style9">abaya</div></td>
        <td bgcolor="#BCE0A8"><div align="center" class="style9">kaftan</div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
 <?php
 include "Right.php";
 ?>
  <div style="clear:both;"></div>
   <?php
 include "Footer.php";
 ?>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
</body>
</html>
