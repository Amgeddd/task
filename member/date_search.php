<?php
include('header.php');
include('session.php');
include('navbar.php');

$from = $_POST['from']; 
$to = $_POST['to'];

// Establish a connection to the database using mysqli
$conn = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement with a parameterized query
$stmt = $conn->prepare("SELECT * FROM book WHERE date_added BETWEEN ? AND ?");
$stmt->bind_param("ss", $from, $to);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

?>

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
                    <li class="active"><a href="books.php">All Books</a></li>
                    <li><a href="new_books.php">New Books</a></li>
                    <li><a href="old_books.php">Old Books</a></li>
                </ul>
                <!--  -->
                <center class="title">
                    <h1>Books List</h1>
                </center>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="example">
                    <div class="pull-right">
                        <a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
                    </div>
                    <thead>
                        <tr>
                            <th>Book No.</th>                                 
                            <th>Book Title</th>                                 
                            <th>Category</th>
                            <th>Author</th>
                            <th class="action">Copies</th>
                            <th>Edition</th>
                            <th>Publisher Name</th>
                            <th>ISBN</th>
                            <th>Copyright Year</th>
                            <th>Date Added</th>
                            <th>Status</th>	
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Fetch each row as an associative array
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['book_id'];  
                            $cat_id = $row['category_id'];
                            $book_copies = $row['book_copies'];
                            
                            // Query to get the number of pending borrowings for the book
                            $borrow_details = $conn->prepare("SELECT * FROM borrowdetails WHERE book_id = ? AND borrow_status = 'pending'");
                            $borrow_details->bind_param("i", $id);
                            $borrow_details->execute();
                            $borrow_result = $borrow_details->get_result();
                            $count = $borrow_result->num_rows;
                            
                            // Calculate available copies
                            $total =  $book_copies - $count; 
                            
                            // Query to get category information
                            $cat_query = $conn->prepare("SELECT * FROM category WHERE category_id = ?");
                            $cat_query->bind_param("i", $cat_id);
                            $cat_query->execute();
                            $cat_result = $cat_query->get_result();
                            $cat_row = $cat_result->fetch_assoc();
                        ?>
                        <tr class="del<?php echo htmlspecialchars($id); ?>">
                            <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                            <td><?php echo htmlspecialchars($cat_row['classname']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td> 
                            <td class="action"><?php echo htmlspecialchars($total); ?></td>
                            <td><?php echo htmlspecialchars($row['edition']); ?></td>
                            <td><?php echo htmlspecialchars($row['publisher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($row['copyright_year']); ?></td>		
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                        <?php  
                        }  
                        ?>
                    </tbody>
                </table>
            </div>		
        </div>
    </div>
</div>

<?php 
// Close statement and connection
$stmt->close();
$conn->close();
include('footer.php');
?>
