<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<link rel="stylesheet" href="asset/css/chat.css">
</head>
<body>

<div id="chatbot">
  <div id="chatbot-header">
    <img width="22" src="asset/images/arrow-left-wide-line.svg" alt="">
    <span class="header-title">Power Of Memory</span>
  </div>

  <div id="chatbot-messages">
        <!-- Received -->

    <div class="message-row received">
      <div  class="message-wrap">
        <div class="avatar-message">
          <div class="avatar">TM</div>
          <div class="message received">👋 Hey ! Bien joué Clément !</div>
        </div>
      </div>
    </div>
    <!-- Sent -->

    <div class="message-row sent">
      <div class="message-wrap">
        <div class="message sent">Yes ! Bien joué Clément !</div>
        <div class="message-time">il y a 2 minutes</div>
      </div>
    </div>
    <!-- Received -->

    <div class="message-row received">
      <div class="message-wrap">
        <div class="avatar-message">
          <div class="avatar">CP</div>
          <div class="message received">Merci beaucoup !!</div>
        </div>
        <div class="message-time">À l'instant</div>
      </div>
    </div>
  </div>

  <div id="chatbot-input">
    <input id="sent-input" type="text" placeholder="Écris un message...">
  </div>
</div>
<div>
</div>
</body>
</html>
