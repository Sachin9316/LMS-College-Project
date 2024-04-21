<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $book_name = $_POST['book_name'];
   $book_price = $_POST['book_price'];
   $book_image = $_POST['book_image'];
   $book_quantity = $_POST['book_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$book_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$book_name', '$book_price', '$book_quantity', '$book_image')") or die('query failed');
      $message[] = 'book added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>HAND PICKED UP BOOK FROM YOUR LIBRARY.</h3>
      <p>A library is a place where books and other sources of information are stored and made accessible for reading or study.</p>
      <a href="about.php" class="white-btn">Discover more</a>
   </div>

</section>

<section class="books">

   <h1 class="title">Latest Books</h1>

   <div class="box-container">

      <?php  
         $select_books = mysqli_query($conn, "SELECT * FROM `books` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_books) > 0){
            while($fetch_books = mysqli_fetch_assoc($select_books)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_books['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_books['name']; ?></div>
      <div class="price">₹<?php echo $fetch_books['price']; ?>/-</div>
      <input type="number" min="1" name="book_quantity" value="1" class="qty">
      <input type="hidden" name="book_name" value="<?php echo $fetch_books['name']; ?>">
      <input type="hidden" name="book_price" value="<?php echo $fetch_books['price']; ?>">
      <input type="hidden" name="book_image" value="<?php echo $fetch_books['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no books added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Load More</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>About us</h3>
         <p>Thank you very much. For those who are hindered by the smallest of the so-called responsibilities of the body, but often get?</p>
         <a href="about.php" class="btn">Read More</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Have any DOUBT ?</h3>
      <p>Borrow books that match your interests.Enjoy a homei feel library service with books selected by our librarians.Request books from our collection and we’ll send them to you.</p>
      <a href="contact.php" class="white-btn">Contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>