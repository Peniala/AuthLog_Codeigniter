<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./body.css">
    <link rel="stylesheet" href="./table.css">
    <link rel="stylesheet" href="./pagination.css">
    <link rel="stylesheet" href="./side_bar.css">
    <link rel="stylesheet" href="./chart.css">
</head>
<body>
    <nav class="barre_nav">
        <form action="/Dashboard">
            <input type="date" name="date" id="" <?php if(isset($date)) echo "value=\"".$date."\"" ?> >
            <button type="submit">Search</button>
            <a href="/Auth/actualize?date=<?= $date;?>&p=Dashboard" class="actu"><button type="button">Actualize</button></a>
        </form>
    </nav>
    <section class="center charts">
        <div class="pie">
            <canvas id="global"></canvas>
        </div>
        <div class="levels">
            <div class="license">
                <div class="bars">
                    <h4>License 1</h4>
                    <canvas id="l1Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>License 2</h4>
                    <canvas id="l2Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>License 3</h4>
                    <canvas id="l3Chart"></canvas>
                </div>
            </div>
            <div class="master">
                <div class="bars">
                    <h4>Master 1</h4>
                    <canvas id="m1Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>Master 2</h4>
                    <canvas id="m2Chart"></canvas>
                </div>
            </div>
        </div>
        <a class="redirect" href="/Connected?date=<?= $date ?>" style="padding: 2vw;">View lists of connection</a>
    </section>
    <div class="side_bar">
        <div class="button_nav">
            <img src="./bars.png" alt="Bars" id="image">
        </div>
        <div class="list">
            <a href="#" onClick="printChart()" class="link link_pdf"><img class="pdf" src="file-pdf.png" alt="PDF"> Export to PDF</a>
            <a href="/Auth" class="link">View session</a>
            <a href="/Dashboard" class="actived link">Dashboard</a>
            <a href='/deconnexion' class="link">Log out</a>
        </div>
    </div>
    <script>
        function printChart(){
            const bar = document.querySelector(".side_bar");
            const center = document.querySelector(".center");
            const pie = document.querySelector(".pie");
            const link = document.querySelector("form a");
            const button = document.querySelector("form button");
            const redirect = document.querySelector(".redirect");

            bar.style.display = "none";
            link.style.display = "none";
            button.style.display = "none";
            redirect.style.display = "none";
            center.style.width = "100%";
            center.style.marginTop = "5%";
            pie.style.marginTop = "13%";

            window.print();

            bar.style.display = "block";
            link.style.display = "inline";
            button.style.display = "inline";
            redirect.style.display = "inline";
            center.style.width = "80%";
            center.style.marginTop = "3%";
            pie.style.marginTop = "15%";
        }
    </script>
    <script src="../chart.js-4.4.2/package/dist/chart.umd.js"></script>
    <script>
        

        const globalChart = document.getElementById('global');
        const l1Chart = document.getElementById('l1Chart');
        const l2Chart = document.getElementById('l2Chart');
        const l3Chart = document.getElementById('l3Chart');
        const m1Chart = document.getElementById('m1Chart');
        const m2Chart = document.getElementById('m2Chart');

        new Chart(globalChart, {
            type: 'pie',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label: 'personnes',
                    backgroundColor:['#471696','#aaa1d8'],
                    data: [<?= count($l1_c)+count($l2_c)+count($l3_c)+count($m1_c)+count($m2_c).','.(count($l1)+count($l2)+count($l3)+count($m1)+count($m2)-count($l1_c)-count($l2_c)-count($l3_c)-count($m1_c)-count($m2_c));?>]
                }]
            }
        });
        new Chart(l1Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    backgroundColor:['#00977e','#fc844d'],
                    data: [<?= count($l1_c).",".count($l1)-count($l1_c);?>]
                }]
            }
        });
        new Chart(l2Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    backgroundColor:['#109754','#f7693e'],
                    data: [<?= count($l2_c).",".count($l2)-count($l2_c);?>]
                }]
            }
        });
        new Chart(l3Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    backgroundColor:['#36506d','#e22626'],
                    data: [<?= count($l3_c).",".count($l3)-count($l3_c);?>]
                }]
            }
        });
        new Chart(m1Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    backgroundColor:['#0d1094','#df0303'],
                    data: [<?= count($m1_c).",".count($m1)-count($m1_c);?>]
                }]
            }
        });
        new Chart(m2Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    backgroundColor:['#1e21da','#ff0000'],
                    data: [<?= count($m2_c).",".count($m2)-count($m2_c);?>]
                }]
            }
        });

        const barre_nav = document.querySelector(".barre_nav");
        const button_nav = document.querySelector(".button_nav");
        const image = document.querySelector("#image");
        const center = document.querySelector(".center");
        const list_nav = document.querySelector(".list");
        const side_bar = document.querySelector(".side_bar");
        const title = document.querySelector(".title");

        button_nav.addEventListener("click",()=>{
            if(list_nav.style.display === "block"){
                center.style.width = "90%";
                barre_nav.style.width = "35%";
                // barre_nav.style.height = "15%";
                barre_nav.style.textAlign = "left";
                image.setAttribute("src","./bars.png");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "#fff";
                side_bar.style.width = "10%";
                title.style.marginTop = "8%";
            }
            else{
                center.style.width = "80%";
                barre_nav.style.width = "35%";
                // barre_nav.style.height = "18%";
                barre_nav.style.textAlign = "center";
                image.setAttribute("src","./chevron-down.png");
                list_nav.style.display = "block";
                side_bar.style.backgroundColor = "#030838";
                side_bar.style.width = "20%";
                button_nav.style.backgroundColor = "#fff";
                title.style.marginTop = "12%";
            }
            // alert('click');
        });

    </script>
</body>
</html>