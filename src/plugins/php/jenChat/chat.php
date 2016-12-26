<?php
  session_start();
  if(!$_SESSION['jenChat_UserID']){
    header("Location: ./login.php");
    exit;
  }
  else if(date("YmdHis",time() - 5) > $_SESSION['jenChat_Prevtime']){
    header("Location: ./login.php?logout=true");
    exit;
  }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US" style="overflow: hidden;">
  <head>
    <title>jenChat</title>
    <style type="text/css">
      #chatContents{height:300px; width:200px;}
    </style>
    <script type="text/javascript"><!--
      var cDocument;
      var cWindow;
    
      window.onload = chat_init;
    
      function chat_init(){
        var chatContents = document.getElementById("chatContents");
    
        //set up a reference to the window object of the IFRAME
        if(window.frames && window.frames["chatContents"]) //IE5, Konq, Safari
          cWindow = window.frames["chatContents"];
        else if(chatContents.contentWindow) //IE5.5+, Moz 1.0+, Opera
          cWindow = chatContents.contentWindow;
        else //Moz < 0.9 (Netscape 6.0)
          cWindow = chatContents;
    
        //set up a reference to the document object of the IFRAME
        if(cWindow.document) //Moz 0.9+, Konq, Safari, IE, Opera
          cDocument = cWindow.document;
        else //Moz < 0.9 (Netscape 6.0)
          cDocument = cWindow.contentDocument;
      }
      function insertMessages(content){
        //place the new messages in a div
        var newDiv = cDocument.createElement("DIV");
        newDiv.innerHTML = content;
    
        //append the messages to the contents
        cDocument.getElementById("contents").appendChild(newDiv);
    
        //scroll the chatContents area to the bottom
        cWindow.scrollTo(0,cDocument.getElementById("contents").offsetHeight);
      }
      function resetForm(){
        document.getElementById("message").value = "";
        document.getElementById("message").focus();
      }//-->
    </script>
	
		<style type="text/css">		
		label {
			font-size: 12px;
		}
		
		input, button {
			border: 1px solid #000000;
			background-color: #FFFFFF;
		}
		
		input[type='text'] {
			width: 115px;
		}
		
		button {
			background-color: #FF0000;
			color: #FFFFFF;
			font-weight: bolder;
		}
		
	</style>
  </head>
  <body>

    <iframe id="chatContents" name="chatContents" src="contents.html" frameBorder="0" style="width: 180px; height: 160px; border: none;"></iframe>

    <form target="post" method="POST" action="post.php">
      <input type="text" name="message" id="message" />
      <input type="submit" class="submit" value=">" />
	  <button onClick="window.location.href = 'login.php?logout=true';">X</button><br />
    </form>

    <iframe id="post" name="post" src="post.php"
      style="display: none;"></iframe>
    <iframe id="thread" name="thread" src="thread.php"
      style="display: none;"></iframe>
  </body>
</html>
