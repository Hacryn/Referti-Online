<html lang="it">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Referti Online</title>
	
	<style>
		body{background-color: #212529; color: white}
        form{margin:50px}
        .display-1{color: white; text-align: center;}
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
	</style>
</head>
<body>
    <nav id="NavBar" class="navbar navbar-dark bg-dark">
        <ul class="nav">
            <li class="nav-item">
			    <a class="nav-link active" href="index.html"><b>⬅ Indietro</b></a>
		    </li> 
        </ul>
    </nav>
    <div id="ReportBox" class="h-flex container">
        <?php
            echo(report_table($report));
        ?>
    </div>
</body>
</html>