<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar.php'); ?>
    <div class="container">
		<div class="margin-top">
			<div class="row">	
			<div class="span12">	
			   <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
                                </div>
						<!--  -->
								    <ul class="nav nav-pills">
										<li><a href="books.php">All Books</a></li>
										<li><a href="new_books.php">New Books</a></li>
										<li class="active"><a href="old_books.php">Old Books</a></li>
									</ul>
						<!--  -->
						<center class="title">
						<h1>Old Books</h1>
						</center>
                            <table cellpadding="0" cellspacing="0" border="0" class="table  table-bordered" id="example">
								<div class="pull-right">
								<a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
								</div>
							
                                <thead>
                                    <tr>
									    <th>Book No.</th>                                 
                                        <th>Book Title</th>                                 
                                        <th>Category</th>
										<th>Author</th>
										<th>Copies</th>
										<th>Edition</th>
										<th>Publisher Name</th>
										<th>ISBN</th>
										<th>Copyright Year</th>
										<th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
								 
                                  <?php
// Assuming $conn is your database connection variable
$user_query = $conn->prepare("SELECT * FROM book WHERE status = ?");
$status = 'old'; // Example status, dynamically set this as required
$user_query->bind_param("s", $status);
$user_query->execute();
$result = $user_query->get_result();

while ($row = $result->fetch_assoc()) {
    $id = $row['book_id'];
    $cat_id = $row['category_id'];

    // Prepare the second query using prepared statements as well
    $cat_query = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
    $cat_query->bind_param("s", $cat_id);
    //Prepared Statements: By using prepare(), bind_param(), and execute(), your SQL statements are sent to the database separately from the data, 
    //thus preventing SQL injection by design.
    $cat_query->execute();
    $cat_result = $cat_query->get_result();
    $cat_row = $cat_result->fetch_assoc();

    // Process your data here
}

?>

									<tr class="del<?php echo $id ?>">
									
									                              
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_title']; ?></td>
									<td><?php echo $cat_row ['classname']; ?> </td>
                                    <td><?php echo $row['author']; ?> </td> 
                                    <td class="action"><?php echo $row['book_copies']; ?> </td>
									<td><?php echo $row['edition']; ?></td>
									 <td><?php echo $row['publisher_name']; ?></td>
									 <td><?php echo $row['isbn']; ?></td>
									 <td><?php echo $row['copyright_year']; ?></td>		
									 <td><?php echo $row['date_added']; ?></td>
									
									
                                    </tr>
									<?php  }  ?>
                           
                                </tbody>
                            </table>
							
			
			</div>		
			</div>
		</div>
    </div>
<?php include('footer.php') ?>
