<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>

<style>

.header{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:70px;
  background:linear-gradient(90deg,#0057b8,#2e86de);
  display:flex;
  align-items:center;
  padding-left:20px;
  box-shadow:0 3px 10px rgba(0,0,0,0.15);
  z-index:999;
}

/* RESET */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

.logo{
  height:60px;
  width:auto;
}
/* BACKGROUND FOTO */
body{
height:100vh;
background:url('{{ asset('assets/balaikota.jpg') }}') no-repeat center center/cover;
display:flex;
justify-content:center;
align-items:center;
position:relative;
}

/* OVERLAY GELAP + BLUR */
body::before{
content:"";
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
backdrop-filter:blur(4px);
}

/* KOTAK LOGIN */
.login-box{
position:relative;
z-index:2;
width:500px;

background:rgba(255,255,255,0.97);
padding:40px 30px;

border-radius:18px;

box-shadow:
0 15px 40px rgba(0,0,0,0.35);

text-align:center;
}

/* JUDUL */
.login-box h2{
margin-bottom:25px;
font-size:24px;
color:#2c3e50;
}

/* INPUT */
input{
width:100%;
padding:13px;

margin-bottom:15px;

border-radius:10px;
border:1px solid #ddd;

font-size:15px;

transition:0.25s;
}

/* FOCUS INPUT */
input:focus{
outline:none;
border-color:#3498db;
box-shadow:0 0 6px rgba(52,152,219,0.4);
}

/* BUTTON */
button{
width:100%;
padding:13px;

margin-top:10px;

border:none;
border-radius:10px;

background:linear-gradient(90deg,#2ecc71,#27ae60);

color:white;
font-size:16px;
font-weight:bold;

cursor:pointer;

transition:0.3s;
}

/* HOVER BUTTON */
button:hover{
transform:translateY(-2px);
box-shadow:0 6px 15px rgba(0,0,0,0.25);
}

/* FOOTER */
.footer{
margin-top:18px;
font-size:13px;
color:#777;
}

/* MOBILE */
@media(max-width:480px){

.login-box{
width:90%;
padding:30px 20px;
}

}
</style>
</head>

<body>

<div class="header">
  <img src="{{ asset('assets/logo.png') }}" class="logo">
  <h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>

<div class="login-box">
<h2>Login Admin</h2>

@if($errors->any())
    <div style="color: red; margin-bottom: 10px;">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login.submit') }}">
@csrf
<input type="text" name="name" placeholder="Username" required value="{{ old('name') }}">

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Masuk</button>

</form>

<div class="footer">
Sistem Penerimaan Paket Kantor
</div>

</div>

</body>
</html>
