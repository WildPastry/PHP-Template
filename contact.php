<?php
    if($_POST){
        // var_dump($_POST);
        // $name = $_POST["name"];
        // $email = $_POST["email"];
        // $message = $_POST["message"];
        // $subscribe = $_POST["subscribe"];

        extract($_POST);

        $errors = array();

        if(!$name){
            array_push($errors, "Name is required, please enter a value");
        } else if(strlen($name) < 2){
            array_push($errors, "Please enter at least 2 characters for your name");
        } else if(strlen($name) > 100){
            array_push($errors, "Your name can't be more than 100 characters");
        }

        if(!$email){
            array_push($errors, "Email is required, please enter a value");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Your email is invalid");
        }

        if(!$message){
            array_push($errors, "A message is required, please enter a value");
        } else if(strlen($message) < 10){
            array_push($errors, "Your message must be at least 10 characters long");
        } else if(strlen($message) > 1000){
            array_push($errors, "Your message needs to be less than 1000 characters");
        }

        if(empty($errors)){
            $to = $email;
            $subject = 'email enquiry';
            $emailMessage = 'You have recieved an email<br>Here is the message<br>';
            $emailMessage += $message;
            $headers = array(
                'From' => 'richard.hpa@acgedu.com',
                'Reply-To' => 'richard.hpa@acgedu.com',
                'X-Mailer' => 'PHP/'.phpversion()
            );
            mail($to,$subject,$emailMessage,$headers);

            header("Location: index.php");
        }

    }








    $page = "contact";
    $desc = "This is the description of the Contact Page";

    // include("templates/header.php");
    require("templates/header.php");
 ?>

<main role="main" class="inner cover">
    <h1 class="cover-heading">Contact Page</h1>
    <p class="lead">Contact us about your query</p>

    <?php if($_POST && !empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach($errors as $singleError): ?>
                    <li><?= $singleError; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="contact.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" rows="3" name="message"><?php if(isset($_POST['message'])){ echo $_POST['message']; } ?></textarea>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="subscribe" name="subsribe" <?php if(isset($_POST['subsribe'])){ echo 'checked'; } ?>>
          <label class="form-check-label" for="subscribe">Subscribe to Newsletter</label>
        </div>
        <button type="submit" class="btn btn-outline-light btn-block">Submit</button>
    </form>


</main>

<?php require("templates/footer.php"); ?>
