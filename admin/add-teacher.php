<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
 $tcrname=$_POST['tcrname'];
 $tcremail=$_POST['tcremail'];
 $tcrclass=$_POST['tcrclass'];
 $gender=$_POST['gender'];
 $dob=$_POST['dob'];
 $tcrid=$_POST['tcrid'];
 $connum=$_POST['connum'];
 $uname=$_POST['uname'];
 $password=md5($_POST['password']);
 $image=$_FILES["image"]["name"];
 $ret="select UserName from tblteacher where UserName=:uname || tcrid=:tcrid";
 $query= $dbh -> prepare($ret);
$query->bindParam(':uname',$uname,PDO::PARAM_STR);
$query->bindParam(':tcrid',$tcrid,PDO::PARAM_STR);
$query-> execute();
     $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$extension = substr($image,strlen($image)-4,strlen($image));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Logo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
$image=md5($image).time().$extension;
 move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$image);
$sql="insert into tblteacher(TeacherName,Email,Materia,Gender,DOB,MobileNumber,UserName,Password,Image)values(:tcrname,:tcremail,:tcrclass,:gender,:dob,:tcrid,:connum,:uname,:password,:image)";
$query=$dbh->prepare($sql);
$query->bindParam(':tcrname',$tcrname,PDO::PARAM_STR);
$query->bindParam(':tcremail',$tcremail,PDO::PARAM_STR);
$query->bindParam(':tcrclass',$tcrclass,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':tcrid',$tcrid,PDO::PARAM_STR);
$query->bindParam(':connum',$connum,PDO::PARAM_STR);
$query->bindParam(':uname',$uname,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':image',$image,PDO::PARAM_STR);
 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Professor Foi Adicionado")</script>';
echo "<script>window.location.href ='add-teacher.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}}

else
{

echo "<script>alert('Username or Professor Id  already exist. Please try again');</script>";
}
}
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Future Maker || Adicionar Professores</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Adicionar Professores</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Menu</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Adicionar Professores</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Adicionar Professores</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Nome do Professor</label>
                        <input type="text" name="tcrname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email do Professor</label>
                        <input type="text" name="email" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Classe do Professor</label>
                        <select  name="tcrclass" class="form-control" required='true'>
                          <option value="">Selecionar classe</option>
                         <?php 

$sql2 = "SELECT * from    tblclass ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->ID);?>"><?php echo htmlentities($row1->ClassName);?> <?php echo htmlentities($row1->Section);?></option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Gênero</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Esculher o Gênero</option>
                          <option value="Male">Masculino♂</option>
                          <option value="Female">Feminino♀</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Data do Aniversário</label>
                        <input type="date" name="dob" value="" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Código do Professor</label>
                        <input type="text" name="tcrid" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Foto do Professor</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Número de Contato</label>
                        <input type="text" name="connum" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
<h3>Detalhes de Login</h3>
<div class="form-group">
                        <label for="exampleInputName1">Nome de Usuário</label>
                        <input type="text" name="uname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Senha</label>
                        <input type="Password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>