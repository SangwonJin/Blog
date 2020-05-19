<!-- contact -->
<div class="section grey lighten-5" id="section_contact">
  <div class="row container">
    <h1 class="grey-text text-darken-3 lighten-3 center-align sectionHeading">
      Contact
    </h1>
    <div class="row">
      <div class="col s12 m12">
        <div class="card blue-grey darken-1">
          <div class="card-content white-text">
            <?php
            if (!isset($_POST["emailSubmit"])) {
            ?>

              <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="contactForm">
                <div style="width: 80%; margin:0 auto">
                  <div style="width: 40%;">
                    <div>
                      <label class="white-text" for="">Your Name*</label><br><input class="validate" type="text" name="name">
                    </div>
                    <div>
                      <label class="white-text" for="">Your Email*</label><br><input class="validate" type="text" name="from_email" width="200px">
                    </div>
                    <div>
                      <label class="white-text" for="">Subject*</label><br><input class="validate" type="text" name="subject" width="200px">
                    </div>
                  </div>
                  <div style="width: 80%;">
                    <label class="white-text" for="">Message</label><br><textarea style=" height:200px;" name="message" cols="50" rows="4" form="contactForm"></textarea>
                  </div><br>
                  <div style="width: 10%;">
                    <input class="waves-effect waves-light btn-large" type="submit" name="emailSubmit" value="Send">
                  </div>
              </form>
            <?php
            } else {
              if (isset($_POST["name"]) && isset($_POST["from_email"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
                $name = $_POST['name'];
                $to_email = "clubwonni@gmail.com";
                $from_email = $_POST["from_email"];
                $subject = $_POST["subject"];
                $body = wordwrap("Name:" . $name . "\r\n" . "Message: " . $_POST["message"], 100, "\r\n");
                $headers = "From:{$from_email} \r\n";
                $headers .= "Cc:bob@test.com";

                if (mail($to_email, $subject, $body, $headers)) {
                  echo ("Email successfully sent     <a href='" . $_SERVER["PHP_SELF"] . "'>send another email</a>");
                } else {
                  echo ("Email sending failed...");
                }
              } else {
                echo "Please check contact again. something is missing";
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>