<!DOCTYPE html>
<html>

<head>

<title>Admin Tartila Press</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

.navbar {

background-color: #003153; /* Prussian Blue */

}

.btn-danger {

background-color: #5F8D4E; /* Green Tea */

border: none;

}

</style>
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<!-- LOGO -->

<a class="navbar-brand"
href="/dashboard">

Tartila Press Admin

</a>

<!-- TOGGLE MOBILE -->

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarAdmin">

<span class="navbar-toggler-icon"></span>

</button>

<!-- MENU -->

<div
class="collapse navbar-collapse"
id="navbarAdmin">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link"
href="/dashboard">

Dashboard

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="/admin/books">

Buku

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="/admin/packages">

Paket

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="/">

Website

</a>

</li>

<li class="nav-item">

<form
method="POST"
action="/logout">

@csrf

<button
class="btn btn-danger btn-sm ms-2">

Logout

</button>

</form>

</li>

</ul>

</div>

</div>

</nav>

<!-- CONTENT -->

<div class="container mt-4">

@yield('content')

</div>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>