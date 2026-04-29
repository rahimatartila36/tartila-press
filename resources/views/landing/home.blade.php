<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Tartila Press</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

:root {

--primary:#003153;
--secondary:#D0F0C0;

}

.hero {

background:var(--primary);
color:white;
padding:120px 20px;

}

</style>

</head>

<body>

@include('components.navbar')

@include('components.hero')

@include('components.about')

@include('components.services')

@include('components.packages')

@include('components.books')

<footer
class="text-center py-4"
style="background:#003153;color:white">

<p>

© 2026 Tartila Press

</p>

</footer>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>