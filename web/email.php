<?php
   $to = "debasisp@gc-solutions.net";
   $subject = "This is subject";
   $message = "This is simple text message.";
   $header = "From:sepg@gc-solutions.net\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully...";
   }
   else
   {
      echo "Message could not be sent...";
   }
?>