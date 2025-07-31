<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セラノア - SERANOA</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Noto Sans JP', sans-serif; color: #333; background: #f7f9fc; scroll-behavior: smooth; }

    .hero {
      position: relative;
      height: 100vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }
    .bg-video {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      z-index: 0;
    }
    .overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      animation: fadeInUp 1.5s ease-out;
    }
    .hero-content img {
      max-width: 220px;
      margin-bottom: 20px;
      animation: fadeIn 2s ease-out;
    }
    .hero-content h1 {
      font-size: 3em;
      margin-bottom: 20px;
      animation: fadeIn 2.5s ease-out;
    }
    .hero-content p {
      font-size: 1.3em;
      line-height: 1.6;
      animation: fadeIn 3s ease-out;
    }
    .hero-content a.button {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 30px;
      background-color: #007ACC;
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 1.1em;
      border-radius: 8px;
      transition: transform 0.3s ease, background-color 0.3s ease;
      animation: fadeIn 3.5s ease-out;
    }
    .hero-content a.button:hover {
      background-color: #005f99;
      transform: scale(1.05);
    }
    .scroll-down {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      font-size: 1em;
    }
    .scroll-down a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }
    section {
      padding: 60px 20px;
      max-width: 900px;
      margin: auto;
      animation: fadeInUp 1s ease-out;
    }
    section h2 {
      font-size: 2em;
      color: #007ACC;
      margin-bottom: 20px;
      text-align: center;
      border-bottom: 2px solid #007ACC;
      display: inline-block;
    }
    section p {
      font-size: 1.1em;
      line-height: 1.8;
      text-align: center;
    }
    .link-buttons {
      text-align: center;
      margin-top: 30px;
    }
    .link-buttons a {
      display: inline-block;
      margin: 10px;
      padding: 12px 24px;
      background-color: #007ACC;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: background-color 0.3s, transform 0.3s;
    }
    .link-buttons a:hover {
      background-color: #005f99;
      transform: scale(1.05);
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 600px) {
      .hero-content h1 { font-size: 2em; }
      .hero-content p { font-size: 1em; }
    }
  </style>
</head>
<body>
  <div class="hero">
    <video autoplay muted loop playsinline class="bg-video">
      <source src="videos/hero.mp4" type="video/mp4">
      お使いのブラウザは video タグをサポートしていません。
    </video>
    <div class="overlay"></div>
    <div class="hero-content">
      <img src="images/seranoa_logo.png" alt="セラノア ロゴ">
      <h1>セラノア - SERANOA</h1>
      <p>人生の“次の章”を、自分の手でひらく。</p>
      <a href="register.php" class="button">サロンに参加する</a>
    </div>
    <div class="scroll-down">
      <a href="#intro">↓ スクロールして詳しく見る</a>
    </div>
  </div>

  <section id="intro">
    <h2>セラノアとは？</h2>
    <p>
      セラノアは、40〜60代の大人が新たな挑戦を始める実践型サロンです。<br>
      学び・交流・社会との関わりを通じて、“第二の人生”を豊かに彩ります。
    </p>
    <div class="link-buttons">
      <a href="event_list.php">イベント一覧を見る</a>
      <a href="about.php">サロン紹介ページへ</a>
    </div>
  </section>
</body>
</html>
